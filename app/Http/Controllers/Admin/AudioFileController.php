<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AudioFile;
use Illuminate\Support\Facades\Storage;

class AudioFileController extends Controller
{

    public function index()
    {
        $audioFiles = AudioFile::latest()->paginate(15);

        return view('admin.audio.index', compact('audioFiles'));
    }

    public function create()
    {
        return view('admin.audio.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
            'audio' => 'required|mimes:mp3,wav,ogg|max:20480'
        ]);

        $path = $request->file('audio')->store('audio','public');

        AudioFile::create([
            'name' => $request->name,
            'file_path' => $path,
            'type' => $request->file('audio')->extension(),
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.audio.index')
            ->with('success','Audio uploaded successfully');

    }

    public function edit(AudioFile $audio)
    {
        return view('admin.audio.edit', compact('audio'));
    }

    public function update(Request $request, AudioFile $audio)
    {

        $request->validate([
            'name' => 'required|max:255'
        ]);

        if($request->hasFile('audio'))
        {

            Storage::disk('public')->delete($audio->file_path);

            $path = $request->file('audio')->store('audio','public');

            $audio->file_path = $path;

            $audio->type = $request->file('audio')->extension();

        }

        $audio->name = $request->name;

        $audio->is_active = $request->has('is_active');

        $audio->save();

        return redirect()->route('admin.audio.index')
            ->with('success','Audio updated');

    }

    public function destroy(AudioFile $audio)
    {

        Storage::disk('public')->delete($audio->file_path);

        $audio->delete();

        return redirect()->route('admin.audio.index')
            ->with('success','Audio deleted');

    }

}