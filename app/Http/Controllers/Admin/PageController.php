<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Language;
use App\Models\PageTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     */
    public function index()
    {
        $pages = Page::with('translations')->orderBy('sort_order')->get();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create()
    {
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        $parentPages = Page::with('translations')->get();
        
        return view('admin.pages.create', compact('languages', 'parentPages'));
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(Request $request)
    {
        // Валидация
        $request->validate([
            'template' => 'required|string',
            'parent_id' => 'nullable|exists:pages,id',
            'show_in_menu' => 'boolean',
            'is_home' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        // Създаване на основния запис в pages
        $page = Page::create([
            'parent_id' => $request->parent_id,
            'template' => $request->template,
            'show_in_menu' => $request->has('show_in_menu'),
            'is_home' => $request->has('is_home'),
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        // Запазване на преводите за всеки активен език
        $languages = Language::where('is_active', true)->get();
        foreach ($languages as $language) {
            $transData = $request->input($language->code);
            
            // Генериране на slug, ако не е попълнен
            $slug = $transData['slug'] ?? Str::slug($transData['title'] ?? '');
            
            PageTranslation::create([
                'page_id' => $page->id,
                'language_id' => $language->id,
                'title' => $transData['title'] ?? '',
                'menu_title' => $transData['menu_title'] ?? ($transData['title'] ?? ''),
                'slug' => $slug,
                'excerpt' => $transData['excerpt'] ?? null,
                'content' => $transData['content'] ?? null,
                'meta_title' => $transData['meta_title'] ?? null,
                'meta_description' => $transData['meta_description'] ?? null,
                'meta_keywords' => $transData['meta_keywords'] ?? null,
            ]);
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit($id)
    {
        $page = Page::with('translations')->findOrFail($id);
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        $parentPages = Page::with('translations')->where('id', '!=', $id)->get();
        
        return view('admin.pages.edit', compact('page', 'languages', 'parentPages'));
    }

    /**
     * Update the specified page in storage.
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'template' => 'required|string',
            'parent_id' => 'nullable|exists:pages,id',
            'show_in_menu' => 'boolean',
            'is_home' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        // Актуализиране на основния запис
        $page->update([
            'parent_id' => $request->parent_id,
            'template' => $request->template,
            'show_in_menu' => $request->has('show_in_menu'),
            'is_home' => $request->has('is_home'),
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        // Актуализиране на преводите
        $languages = Language::where('is_active', true)->get();
        foreach ($languages as $language) {
            $transData = $request->input($language->code);
            
            // Генериране на slug, ако не е попълнен
            $slug = $transData['slug'] ?? Str::slug($transData['title'] ?? '');
            
            PageTranslation::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'language_id' => $language->id,
                ],
                [
                    'title' => $transData['title'] ?? '',
                    'menu_title' => $transData['menu_title'] ?? ($transData['title'] ?? ''),
                    'slug' => $slug,
                    'excerpt' => $transData['excerpt'] ?? null,
                    'content' => $transData['content'] ?? null,
                    'meta_title' => $transData['meta_title'] ?? null,
                    'meta_description' => $transData['meta_description'] ?? null,
                    'meta_keywords' => $transData['meta_keywords'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete(); // Преводите ще се изтрият автоматично (cascade)

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}