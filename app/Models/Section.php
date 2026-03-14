<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RagIndexable;

class Section extends Model
{
    use RagIndexable;

    protected $fillable = [
        'type',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function translations()
    {
        return $this->hasMany(SectionTranslation::class);
    }

    public function translation($languageId)
    {
        return $this->translations()->where('language_id', $languageId)->first();
    }

    /**
     * Подготвя съдържанието за индексиране в RAG системата.
     *
     * @param \App\Models\SectionTranslation $translation
     * @return string
     */
    protected function prepareContent($translation)
    {
        $content = "Тип секция: {$this->type}\n";
        $content .= "Заглавие: {$translation->title}\n";
        if ($translation->subtitle) {
            $content .= "Подзаглавие: {$translation->subtitle}\n";
        }
        if ($translation->data) {
            $content .= "Данни: " . json_encode($translation->data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
        }
        return $content;
    }

    /**
     * Връща заглавие по подразбиране, ако липсва такова.
     *
     * @return string
     */
    protected function getDefaultTitle()
    {
        return 'Section ' . $this->id . ' (' . $this->type . ')';
    }
}