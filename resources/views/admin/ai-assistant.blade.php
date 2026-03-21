@extends('adminlte::page')

@section('title', __('ai_assistant.title'))

@section('content_header')
    <h1>{{ __('ai_assistant.header') }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('ai_assistant.card_title') }}</h3>
            </div>
            <div class="card-body">
                <div id="chat-messages" style="height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
                    <div class="text-muted">{{ __('ai_assistant.placeholder') }}</div>
                </div>
                <form id="chat-form">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="question" class="form-control" placeholder="{{ __('ai_assistant.placeholder') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">{{ __('ai_assistant.send_button') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('ai_assistant.tools_header') }}</h3>
            </div>
            <div class="card-body">
                <button class="btn btn-success btn-block mb-2" id="generatePageBtn">
                    <i class="fas fa-magic"></i> {{ __('ai_assistant.generate_page') }}
                </button>
                <button class="btn btn-info btn-block mb-2" id="generateSectionBtn">
                    <i class="fas fa-layer-group"></i> {{ __('ai_assistant.generate_section') }}
                </button>
                <button class="btn btn-secondary btn-block" id="reindexBtn">
                    <i class="fas fa-sync"></i> {{ __('ai_assistant.reindex') }}
                </button>
            </div>
        </div>
    </div>
</div>

@php
    // Предаване на преведените съобщения към JavaScript
    $translations = [
        'reindex_confirm' => __('ai_assistant.reindex_confirm'),
        'page_created' => __('ai_assistant.page_created'),
        'section_created' => __('ai_assistant.section_created'),
        'reindex_started' => __('ai_assistant.reindex_started'),
        'unknown_error' => __('ai_assistant.unknown_error'),
        'communication_error' => __('ai_assistant.communication_error'),
        'waiting' => __('ai_assistant.waiting'),
    ];
@endphp

@stop

@section('js')
<script>
    const translations = @json($translations);
    console.log('AI Assistant JS loaded');

    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const questionInput = document.getElementById('question');
    const generatePageBtn = document.getElementById('generatePageBtn');
    const generateSectionBtn = document.getElementById('generateSectionBtn');
    const reindexBtn = document.getElementById('reindexBtn');

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const question = questionInput.value.trim();
        if (!question) return;

        chatMessages.innerHTML += `<div class="text-right mb-2"><strong>{{ __('ai_assistant.you') ?? 'Ти' }}:</strong> ${escapeHtml(question)}</div>`;
        questionInput.value = '';

        try {
            const response = await fetch('{{ route("ai.ask") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ question })
            });
            const data = await response.json();
            chatMessages.innerHTML += `<div class="text-left mb-2"><strong>AI:</strong> ${escapeHtml(data.answer)}</div>`;
        } catch (error) {
            chatMessages.innerHTML += `<div class="text-left mb-2 text-danger"><strong>Грешка:</strong> ${error.message}</div>`;
        }
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });

    generatePageBtn.addEventListener('click', async () => {
        console.log('generatePage clicked');
        const prompt = window.prompt(translations.generate_page_prompt || 'Опиши каква страница искаш да създадеш:');
        if (!prompt) return;

        try {
            const response = await fetch('{{ route("ai.generate.page") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ prompt })
            });
            const data = await response.json();
            if (data.success) {
                alert(translations.page_created);
                window.open(data.edit_url, '_blank');
            } else {
                alert(translations.unknown_error + ': ' + (data.error || ''));
            }
        } catch (error) {
            alert(translations.communication_error + error.message);
        }
    });

    generateSectionBtn.addEventListener('click', async () => {
        console.log('generateSection clicked');
        const prompt = window.prompt(translations.generate_section_prompt || 'Опиши каква секция искаш да създадеш (например "hero банер за началната страница"):');
        if (!prompt) return;

        try {
            const response = await fetch('{{ route("ai.generate.section") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ prompt })
            });
            const data = await response.json();
            if (data.success) {
                alert(translations.section_created);
                window.open(data.edit_url, '_blank');
            } else {
                alert(translations.unknown_error + ': ' + (data.error || ''));
            }
        } catch (error) {
            alert(translations.communication_error + error.message);
        }
    });

    reindexBtn.addEventListener('click', async () => {
        console.log('reindex clicked');
        if (!confirm(translations.reindex_confirm)) return;
        try {
            await fetch('{{ route("ai.reindex") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            alert(translations.reindex_started);
        } catch (error) {
            alert(translations.communication_error + error.message);
        }
    });

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
</script>
@stop