@extends('layouts.front')

@section('content')
    <div class="container mt-4">
        <h1>{{ $page->title }}</h1>
        <div class="content">
            {!! $page->content !!}
        </div>
    </div>
@endsection