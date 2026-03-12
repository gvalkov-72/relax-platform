@extends('adminlte::page')

@section('title', 'Meditation')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Meditation Session</h3>
    </div>

    <div class="card-body">

        <div class="form-group">
            <label>Brainwave preset</label>

            <select id="preset" class="form-control">

                @foreach($presets as $preset)

                    <option
                        value="{{ $preset->id }}"
                        data-mode="{{ $preset->mode }}"
                        data-frequency="{{ $preset->frequency }}"
                        data-audio="{{ $preset->audio_file }}"
                    >
                        {{ $preset->name }}
                    </option>

                @endforeach

            </select>
        </div>

        <div class="form-group mt-3">
            <label>Ambient sound</label>

            <select id="ambient" class="form-control">

                <option value="">None</option>

                @foreach($ambient as $sound)

                    <option value="{{ $sound->file_path }}">
                        {{ $sound->title }}
                    </option>

                @endforeach

            </select>
        </div>

        <div class="mt-4">

            <button onclick="startSession()" class="btn btn-success">
                Start Session
            </button>

            <button onclick="stopSession()" class="btn btn-danger">
                Stop
            </button>

        </div>

    </div>
</div>

<script src="/js/meditation-player.js"></script>

@endsection