<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Page;
use App\Models\Section;
use App\Models\Document;
use App\Services\GeminiService;

class IndexContent extends Command
{
    protected $signature = 'rag:index';
    protected $description = 'Индексира всички страници и секции в RAG системата';

    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        parent::__construct();
        $this->gemini = $gemini;
    }

    public function handle()
    {
        $this->info('Започва индексиране...');

        if ($this->confirm('Изтриване на старите индекси?', true)) {
            Document::truncate();
        }

        // Индексиране на страници
        $this->info('Индексиране на страници...');
        $pages = Page::with('translations')->where('is_active', true)->get();
        $bar = $this->output->createProgressBar(count($pages));
        $bar->start();

        foreach ($pages as $page) {
            foreach ($page->translations as $translation) {
                $content = "Заглавие: {$translation->title}\n";
                if ($translation->subtitle) {
                    $content .= "Подзаглавие: {$translation->subtitle}\n";
                }
                if ($translation->content) {
                    $content .= "Съдържание: {$translation->content}\n";
                }

                $embedding = $this->gemini->createEmbedding($content);
                
                // Дори embedding да е null, записваме документа (за тест)
                Document::create([
                    'title' => $translation->title,
                    'content' => $content,
                    'embedding' => $embedding, // може да е null
                    'metadata' => [
                        'type' => 'page',
                        'page_id' => $page->id,
                        'language_id' => $translation->language_id,
                    ],
                    'source_type' => Page::class,
                    'source_id' => $page->id,
                ]);
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();

        // Индексиране на секции
        $this->info('Индексиране на секции...');
        $sections = Section::with('translations')->where('is_active', true)->get();
        $bar = $this->output->createProgressBar(count($sections));
        $bar->start();

        foreach ($sections as $section) {
            foreach ($section->translations as $translation) {
                $content = "Тип секция: {$section->type}\n";
                $content .= "Заглавие: {$translation->title}\n";
                if ($translation->subtitle) {
                    $content .= "Подзаглавие: {$translation->subtitle}\n";
                }
                if ($translation->data) {
                    $content .= "Данни: " . json_encode($translation->data, JSON_UNESCAPED_UNICODE) . "\n";
                }

                $embedding = $this->gemini->createEmbedding($content);

                Document::create([
                    'title' => $translation->title ?? "Секция {$section->type}",
                    'content' => $content,
                    'embedding' => $embedding,
                    'metadata' => [
                        'type' => 'section',
                        'section_id' => $section->id,
                        'section_type' => $section->type,
                        'language_id' => $translation->language_id,
                    ],
                    'source_type' => Section::class,
                    'source_id' => $section->id,
                ]);
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();

        $this->info('Индексирането завърши успешно!');
    }
}