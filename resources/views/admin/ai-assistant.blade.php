@extends('adminlte::page')

@section('title', 'AI Assistant')

@section('content_header')
    <h1>🤖 AI Assistant</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Chat with your CMS</h3>
            </div>
            <div class="card-body">
                <div id="chat-messages" style="height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
                    <div class="text-muted">Задай въпрос за страниците и секциите...</div>
                </div>
                <form id="chat-form">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="question" class="form-control" placeholder="Попитай нещо...">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Изпрати</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Инструменти</h3>
            </div>
            <div class="card-body">
                <button class="btn btn-success btn-block mb-2" id="generatePageBtn">
                    <i class="fas fa-magic"></i> Генерирай страница
                </button>
                <button class="btn btn-info btn-block mb-2" id="generateSectionBtn">
                    <i class="fas fa-layer-group"></i> Генерирай секция
                </button>
                <button class="btn btn-secondary btn-block" id="reindexBtn">
                    <i class="fas fa-sync"></i> Преиндексирай
                </button>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    // За дебъг
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

        chatMessages.innerHTML += `<div class="text-right mb-2"><strong>Ти:</strong> ${question}</div>`;
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
            chatMessages.innerHTML += `<div class="text-left mb-2"><strong>AI:</strong> ${data.answer}</div>`;
        } catch (error) {
            chatMessages.innerHTML += `<div class="text-left mb-2 text-danger"><strong>Грешка:</strong> ${error.message}</div>`;
        }
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });

    generatePageBtn.addEventListener('click', async () => {
        console.log('generatePage clicked');
        const prompt = window.prompt('Опиши каква страница искаш да създадеш:');
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
                alert('Страницата е създадена!');
                window.open(data.edit_url, '_blank');
            } else {
                alert('Грешка: ' + (data.error || 'Неизвестна грешка'));
            }
        } catch (error) {
            alert('Грешка при комуникация: ' + error.message);
        }
    });

    generateSectionBtn.addEventListener('click', async () => {
        console.log('generateSection clicked');
        const prompt = window.prompt('Опиши каква секция искаш да създадеш (например "hero банер за началната страница"):');
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
                alert('Секцията е създадена!');
                window.open(data.edit_url, '_blank');
            } else {
                alert('Грешка: ' + (data.error || 'Неизвестна грешка'));
            }
        } catch (error) {
            alert('Грешка при комуникация: ' + error.message);
        }
    });

    reindexBtn.addEventListener('click', async () => {
        console.log('reindex clicked');
        if (!confirm('Това ще реиндексира цялото съдържание. Продължи?')) return;
        try {
            await fetch('{{ route("ai.reindex") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            alert('Индексирането стартира на заден план.');
        } catch (error) {
            alert('Грешка: ' + error.message);
        }
    });
</script>
@stop