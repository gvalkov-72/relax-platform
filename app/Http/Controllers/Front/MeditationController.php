<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BrainwavePreset;
use App\Models\AudioFile;

class MeditationController extends Controller
{
    public function index()
    {
        $presets = BrainwavePreset::all();
        $ambient = AudioFile::all();

        return view('pages.meditation', compact('presets', 'ambient'));
    }
}