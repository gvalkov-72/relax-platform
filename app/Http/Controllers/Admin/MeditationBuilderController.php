<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meditation;
use App\Models\MeditationItem;
use App\Models\AudioFile;
use App\Models\BrainwavePreset;
use Illuminate\Http\Request;

class MeditationBuilderController extends Controller
{

    public function index($meditationId)
    {
        $meditation = Meditation::findOrFail($meditationId);

        $items = MeditationItem::where('meditation_id', $meditationId)
            ->orderBy('start_time')
            ->get();

        return view('admin.meditation_builder.index', compact(
            'meditation',
            'items'
        ));
    }

    public function create($meditationId)
    {
        $meditation = Meditation::findOrFail($meditationId);

        $audioFiles = AudioFile::where('is_active', 1)->get();
        $brainwaves = BrainwavePreset::where('is_active', 1)->get();

        return view('admin.meditation_builder.create', compact(
            'meditation',
            'audioFiles',
            'brainwaves'
        ));
    }

    public function store(Request $request)
    {
        MeditationItem::create([
            'meditation_id' => $request->meditation_id,
            'item_type' => $request->item_type,
            'item_id' => $request->item_id,
            'volume' => $request->volume,
            'start_time' => $request->start_time,
            'duration' => $request->duration,
        ]);

        return redirect()
            ->route('admin.meditation.builder', $request->meditation_id)
            ->with('success', 'Item added successfully');
    }

    public function destroy($id)
    {
        $item = MeditationItem::findOrFail($id);
        $meditationId = $item->meditation_id;

        $item->delete();

        return redirect()
            ->route('admin.meditation.builder', $meditationId)
            ->with('success', 'Item removed');
    }
}