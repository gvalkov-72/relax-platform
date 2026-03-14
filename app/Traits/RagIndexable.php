<?php

namespace App\Traits;

use App\Models\Document;
use App\Services\GeminiService;

trait RagIndexable
{
    protected static function bootRagIndexable()
    {
        static::saved(function ($model) {
            $gemini = app(GeminiService::class);
            $model->indexDocument($gemini);
        });

        static::deleted(function ($model) {
            Document::where('source_type', get_class($model))
                ->where('source_id', $model->id)
                ->delete();
        });
    }

    public function indexDocument(GeminiService $gemini)
    {
        // Изтриваме старите документи за този модел
        Document::where('source_type', get_class($this))
            ->where('source_id', $this->id)
            ->delete();

        // Индексираме всички преводи
        foreach ($this->translations as $translation) {
            $content = $this->prepareContent($translation);
            $embedding = $gemini->createEmbedding($content);

            if ($embedding) {
                Document::create([
                    'title' => $translation->title ?? $this->getDefaultTitle(),
                    'content' => $content,
                    'embedding' => $embedding,
                    'metadata' => [
                        'type' => (new \ReflectionClass($this))->getShortName(),
                        'id' => $this->id,
                        'language_id' => $translation->language_id,
                    ],
                    'source_type' => get_class($this),
                    'source_id' => $this->id,
                ]);
            }
        }
    }

    /**
     * Подготвя съдържанието за индексиране. Трябва да се имплементира в конкретния модел.
     *
     * @param mixed $translation
     * @return string
     */
    abstract protected function prepareContent($translation);

    /**
     * Връща заглавие по подразбиране. Може да се предефинира в конкретния модел.
     *
     * @return string
     */
    protected function getDefaultTitle()
    {
        return (new \ReflectionClass($this))->getShortName() . ' ' . $this->id;
    }
}