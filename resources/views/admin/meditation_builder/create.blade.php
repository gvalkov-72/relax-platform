@extends('adminlte::page')

@section('title', __('meditation_builder.title.create'))

@section('content_header')
    <h1>{{ __('meditation_builder.header.add_item') }}</h1>
@stop

@section('content')

<form method="POST" action="{{ route('admin.meditation.builder.store') }}">
    @csrf
    <input type="hidden" name="meditation_id" value="{{ $meditation->id }}">

    <div class="form-group">
        <label for="item_type">{{ __('meditation_builder.label.item_type') }}</label>
        <select name="item_type" id="item_type" class="form-control">
            <option value="audio">{{ __('meditation_builder.item_type.audio') }}</option>
            <option value="brainwave">{{ __('meditation_builder.item_type.brainwave') }}</option>
            <option value="generator">{{ __('meditation_builder.item_type.generator') }}</option>
            <option value="silence">{{ __('meditation_builder.item_type.silence') }}</option>
        </select>
    </div>

    <div class="form-group" id="audio_group">
        <label for="audio_file">{{ __('meditation_builder.label.audio_file') }}</label>
        <select name="item_id" class="form-control">
            <option value="">{{ __('meditation_builder.label.none') }}</option>
            @foreach($audioFiles as $audio)
                <option value="{{ $audio->id }}">{{ $audio->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group" id="brainwave_group" style="display:none;">
        <label for="brainwave_preset">{{ __('meditation_builder.label.brainwave_preset') }}</label>
        <select name="item_id" class="form-control">
            <option value="">{{ __('meditation_builder.label.none') }}</option>
            @foreach($brainwaves as $bw)
                <option value="{{ $bw->id }}">{{ $bw->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="start_time">{{ __('meditation_builder.label.start_time') }}</label>
        <input type="number" name="start_time" class="form-control" value="0">
    </div>

    <div class="form-group">
        <label for="duration">{{ __('meditation_builder.label.duration') }}</label>
        <input type="number" name="duration" class="form-control">
    </div>

    <div class="form-group">
        <label for="volume">{{ __('meditation_builder.label.volume') }}</label>
        <input type="number" name="volume" class="form-control" value="100">
    </div>

    <button class="btn btn-success">{{ __('meditation_builder.button.save') }}</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function(){
        const typeSelect = document.getElementById("item_type");
        const audioGroup = document.getElementById("audio_group");
        const brainwaveGroup = document.getElementById("brainwave_group");

        function updateForm()
        {
            const type = typeSelect.value;
            audioGroup.style.display = "none";
            brainwaveGroup.style.display = "none";

            if(type === "audio") {
                audioGroup.style.display = "block";
            }
            if(type === "brainwave") {
                brainwaveGroup.style.display = "block";
            }
        }

        typeSelect.addEventListener("change", updateForm);
        updateForm();
    });
</script>

@stop