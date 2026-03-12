<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BrainwavePreset;

class BrainwavePresetController extends Controller
{

    public function index()
    {

        $presets = BrainwavePreset::latest()->paginate(15);

        return view('admin.brainwaves.index', compact('presets'));

    }

    public function create()
    {

        return view('admin.brainwaves.create');

    }

    public function store(Request $request)
    {

        $request->validate([

            'name' => 'required|max:255',
            'base_frequency' => 'required|numeric',
            'beat_frequency' => 'required|numeric',
            'duration' => 'required|integer'

        ]);

        BrainwavePreset::create([

            'name' => $request->name,
            'base_frequency' => $request->base_frequency,
            'beat_frequency' => $request->beat_frequency,
            'duration' => $request->duration,
            'is_active' => $request->has('is_active')

        ]);

        return redirect()->route('admin.brainwaves.index')
            ->with('success','Preset created');

    }

    public function edit(BrainwavePreset $brainwave)
    {

        return view('admin.brainwaves.edit', compact('brainwave'));

    }

    public function update(Request $request, BrainwavePreset $brainwave)
    {

        $request->validate([

            'name' => 'required|max:255',
            'base_frequency' => 'required|numeric',
            'beat_frequency' => 'required|numeric',
            'duration' => 'required|integer'

        ]);

        $brainwave->update([

            'name' => $request->name,
            'base_frequency' => $request->base_frequency,
            'beat_frequency' => $request->beat_frequency,
            'duration' => $request->duration,
            'is_active' => $request->has('is_active')

        ]);

        return redirect()->route('admin.brainwaves.index')
            ->with('success','Preset updated');

    }

    public function destroy(BrainwavePreset $brainwave)
    {

        $brainwave->delete();

        return redirect()->route('admin.brainwaves.index')
            ->with('success','Preset deleted');

    }

}