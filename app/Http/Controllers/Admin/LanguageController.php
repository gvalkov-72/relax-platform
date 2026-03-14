<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::orderBy('sort_order')->get();
        return view('admin.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(Request $request)
    {
        if ($request->is_default) {
            Language::where('is_default', true)->update(['is_default' => false]);
        }

        Language::create([
            'name' => $request->name,
            'code' => $request->code,
            'is_default' => $request->is_default ?? false,
            'is_active' => $request->is_active ?? true,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.languages.index')
            ->with('success', 'Language created.');
    }

    public function edit($id)
    {
        $language = Language::findOrFail($id);
        return view('admin.languages.edit', compact('language'));
    }

    public function update(Request $request, $id)
    {
        if ($request->is_default) {
            Language::where('is_default', true)->update(['is_default' => false]);
        }

        $language = Language::findOrFail($id);
        $language->update([
            'name' => $request->name,
            'code' => $request->code,
            'is_default' => $request->is_default ?? false,
            'is_active' => $request->is_active ?? true,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.languages.index')
            ->with('success', 'Language updated.');
    }

    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        $language->delete();

        return back()->with('success', 'Language deleted.');
    }
}