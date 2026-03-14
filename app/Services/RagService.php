<?php

namespace App\Services;

use App\Models\Document;

class RagService
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function ask($question)
    {
        // Взема всички документи
        $docs = Document::all();
        
        if ($docs->isEmpty()) {
            // Ако няма документи, питаме директно
            $answer = $this->gemini->generateContent($question);
            return $answer ?? 'Няма индексирани страници. Пусни php artisan rag:index';
        }

        // Изграждаме контекст от документите
        $context = "Ето информация от базата знания:\n\n";
        foreach ($docs as $doc) {
            $context .= $doc->content . "\n---\n";
        }
        $context .= "\nВъпрос: " . $question;

        // Изпращаме към Gemini
        $answer = $this->gemini->generateContent($context);

        return $answer ?? 'Няма отговор от AI.';
    }
}