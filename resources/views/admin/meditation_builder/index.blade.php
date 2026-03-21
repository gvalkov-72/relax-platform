@extends('adminlte::page')

@section('title', __('meditation_builder.title.index'))

@section('content_header')
    <h1>{{ __('meditation_builder.header.builder', ['name' => $meditation->name]) }}</h1>
@stop

@section('content')

<a href="{{ route('admin.meditation.builder.create', $meditation->id) }}" class="btn btn-primary mb-3">
    {{ __('meditation_builder.button.add_item') }}
</a>

<button id="previewBtn" class="btn btn-success mb-3">
    {{ __('meditation_builder.button.preview') }}
</button>

<div class="card">
    <div class="card-header">
        {{ __('meditation_builder.header.timeline') }}
    </div>
    <div class="card-body">
        <div id="timeline">
            @foreach($items as $item)
                <div class="timeline-item"
                     data-id="{{ $item->id }}"
                     data-start="{{ $item->start_time }}"
                     data-duration="{{ $item->duration ?? 60 }}"
                     data-type="{{ $item->item_type }}"
                     style="left:{{ $item->start_time * 4 }}px;width:{{ ($item->duration ?? 60) * 4 }}px">
                    {{ __('meditation_builder.item_type.' . $item->item_type) }}
                    <form method="POST" action="{{ route('admin.meditation.builder.destroy', $item->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn">×</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>

@stop

@section('css')
<style>
    #timeline{
        position:relative;
        height:140px;
        background:#f4f6f9;
        border:1px solid #ddd;
        overflow-x:auto;
    }
    .timeline-item{
        position:absolute;
        top:50px;
        height:40px;
        background:#17a2b8;
        color:white;
        border-radius:4px;
        cursor:move;
        padding:8px;
        font-size:12px;
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .delete-btn{
        position:absolute;
        top:-10px;
        right:-10px;
        border:none;
        background:red;
        color:white;
        border-radius:50%;
        width:18px;
        height:18px;
        font-size:10px;
    }
</style>
@stop

@section('js')
<script>
    const pxPerSecond = 4

    document.querySelectorAll('.timeline-item').forEach(item => {
        let dragging = false
        let startX
        let startLeft

        item.addEventListener('mousedown', e => {
            dragging = true
            startX = e.clientX
            startLeft = item.offsetLeft
        })

        document.addEventListener('mousemove', e => {
            if(!dragging) return
            let dx = e.clientX - startX
            item.style.left = (startLeft + dx) + 'px'
        })

        document.addEventListener('mouseup', () => {
            if(!dragging) return
            dragging = false
            let seconds = Math.round(item.offsetLeft / pxPerSecond)
            fetch('/admin/meditation-builder/update-position',{
                method:'POST',
                headers:{
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                },
                body:JSON.stringify({
                    id:item.dataset.id,
                    start_time:seconds
                })
            })
        })
    })

    document.getElementById('previewBtn').addEventListener('click', ()=>{
        preview()
    })

    function preview(){
        document.querySelectorAll('.timeline-item').forEach(item=>{
            let start = item.dataset.start
            let type = item.dataset.type
            setTimeout(()=>{
                if(type === 'generator'){
                    playTone()
                }
                if(type === 'brainwave'){
                    playBrainwave()
                }
            }, start * 1000)
        })
    }

    function playTone(){
        const ctx = new AudioContext()
        const osc = ctx.createOscillator()
        osc.frequency.value = 432
        osc.connect(ctx.destination)
        osc.start()
        setTimeout(()=>osc.stop(),5000)
    }

    function playBrainwave(){
        const ctx = new AudioContext()
        const osc = ctx.createOscillator()
        osc.frequency.value = 10
        osc.connect(ctx.destination)
        osc.start()
        setTimeout(()=>osc.stop(),5000)
    }
</script>
@stop