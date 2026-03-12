<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meditation;

class MeditationController extends Controller
{
    public function index()
    {
        $meditations = Meditation::latest()->paginate(15);

        return view('admin.meditations.index', compact('meditations'));
    }

    public function create()
    {
        return view('admin.meditations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Meditation::create([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.meditations.index')
            ->with('success', 'Meditation created successfully.');
    }

    public function edit(Meditation $meditation)
    {
        return view('admin.meditations.edit', compact('meditation'));
    }

    public function update(Request $request, Meditation $meditation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $meditation->update([
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.meditations.index')
            ->with('success', 'Meditation updated successfully.');
    }

    public function destroy(Meditation $meditation)
    {
        $meditation->delete();

        return redirect()->route('admin.meditations.index')
            ->with('success', 'Meditation deleted.');
    }
}