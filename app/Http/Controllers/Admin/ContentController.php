<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Attachment;
use App\Models\ContentShare;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $query = Content::with(['author', 'tags'])->latest(); // 👈 tags са заредени

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        $contents = $query->paginate(20);
        $types = ['idea', 'document', 'message'];

        return view('admin.contents.index', compact('contents', 'types'));
    }

    public function create()
    {
        $types = ['idea' => 'Идея', 'document' => 'Документ', 'message' => 'Съобщение'];
        $users = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.contents.create', compact('types', 'users', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:idea,document,message',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
            'attachments.*' => 'nullable|file|max:10240',
            'share_view' => 'nullable|array',
            'share_view.*' => 'exists:users,id',
            'share_edit' => 'nullable|array',
            'share_edit.*' => 'exists:users,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['published_at'] = $validated['published_at'] ?? now();

        $content = Content::create($validated);

        // Прикачени файлове
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('uploads', 'public');
                $content->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }

        // Споделяне за преглед
        if ($request->filled('share_view')) {
            foreach ($request->share_view as $userId) {
                if ($userId != Auth::id()) {
                    ContentShare::create([
                        'content_id' => $content->id,
                        'user_id' => $userId,
                        'permission' => 'view',
                    ]);
                }
            }
        }

        // Споделяне за редакция
        if ($request->filled('share_edit')) {
            foreach ($request->share_edit as $userId) {
                if ($userId != Auth::id()) {
                    ContentShare::create([
                        'content_id' => $content->id,
                        'user_id' => $userId,
                        'permission' => 'edit',
                    ]);
                }
            }
        }

        // Тагове
        if ($request->filled('tags')) {
            $content->tags()->sync($request->tags);
        }

        return redirect()->route('admin.contents.index')
            ->with('success', 'Записът е създаден успешно.');
    }

    public function show(Content $content)
    {
        if (!$content->canView(Auth::user())) {
            abort(403, 'Нямате права да видите този запис.');
        }

        return view('admin.contents.show', compact('content'));
    }

    public function edit(Content $content)
    {
        if (!$content->canEdit(Auth::user())) {
            abort(403, 'Нямате права да редактирате този запис.');
        }

        $types = ['idea' => 'Идея', 'document' => 'Документ', 'message' => 'Съобщение'];
        $users = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->get();
        $tags = Tag::orderBy('name')->get();

        $sharedView = $content->shares()->where('permission', 'view')->pluck('user_id')->toArray();
        $sharedEdit = $content->shares()->where('permission', 'edit')->pluck('user_id')->toArray();
        $selectedTags = $content->tags->pluck('id')->toArray();

        return view('admin.contents.edit', compact('content', 'types', 'users', 'tags', 'sharedView', 'sharedEdit', 'selectedTags'));
    }

    public function update(Request $request, Content $content)
    {
        if (!$content->canEdit(Auth::user())) {
            abort(403, 'Нямате права да редактирате този запис.');
        }

        $validated = $request->validate([
            'type' => 'required|in:idea,document,message',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
            'attachments.*' => 'nullable|file|max:10240',
            'share_view' => 'nullable|array',
            'share_view.*' => 'exists:users,id',
            'share_edit' => 'nullable|array',
            'share_edit.*' => 'exists:users,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $validated['published_at'] = $validated['published_at'] ?? $content->published_at;
        $content->update($validated);

        // Нови прикачени файлове
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('uploads', 'public');
                $content->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }

        // Обновяване на споделянията
        $content->shares()->delete();

        if ($request->filled('share_view')) {
            foreach ($request->share_view as $userId) {
                if ($userId != Auth::id()) {
                    ContentShare::create([
                        'content_id' => $content->id,
                        'user_id' => $userId,
                        'permission' => 'view',
                    ]);
                }
            }
        }

        if ($request->filled('share_edit')) {
            foreach ($request->share_edit as $userId) {
                if ($userId != Auth::id()) {
                    ContentShare::create([
                        'content_id' => $content->id,
                        'user_id' => $userId,
                        'permission' => 'edit',
                    ]);
                }
            }
        }

        // Тагове
        if ($request->filled('tags')) {
            $content->tags()->sync($request->tags);
        } else {
            $content->tags()->detach();
        }

        return redirect()->route('admin.contents.index')
            ->with('success', 'Записът е обновен.');
    }

    public function destroy(Content $content)
    {
        if (!$content->canDelete(Auth::user())) {
            abort(403, 'Нямате права да изтриете този запис.');
        }

        foreach ($content->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $content->delete();

        return redirect()->route('admin.contents.index')
            ->with('success', 'Записът е изтрит.');
    }

    public function deleteAttachment(Attachment $attachment)
    {
        $content = $attachment->content;
        if (!$content->canEdit(Auth::user())) {
            return response()->json(['error' => 'Нямате права'], 403);
        }

        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();

        return response()->json(['success' => true]);
    }

    public function download(Attachment $attachment)
    {
        $content = $attachment->content;
        if (!$content->canView(Auth::user())) {
            abort(403, 'Нямате права да свалите този файл.');
        }

        $path = Storage::disk('public')->path($attachment->file_path);
        return response()->download($path, $attachment->file_name);
    }
}