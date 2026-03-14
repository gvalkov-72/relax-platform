<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RagIndexable;

class Page extends Model
{
    use RagIndexable;

    protected $fillable = [
        'parent_id',
        'template',
        'show_in_menu',
        'is_home',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'show_in_menu' => 'boolean',
        'is_home' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('sort_order');
    }

    public function translations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function translation($languageId)
    {
        return $this->translations()->where('language_id', $languageId)->first();
    }

    /**
     * Подготвя съдържанието за индексиране в RAG системата.
     *
     * @param \App\Models\PageTranslation $translation
     * @return string
     */
    protected function prepareContent($translation)
    {
        $content = "Заглавие: {$translation->title}\n";
        if ($translation->subtitle) {
            $content .= "Подзаглавие: {$translation->subtitle}\n";
        }
        if ($translation->content) {
            $content .= "Съдържание: {$translation->content}\n";
        }
        // Можеш да добавиш и други полета, ако желаеш
        return $content;
    }

    /**
     * Връща заглавие по подразбиране, ако липсва такова.
     *
     * @return string
     */
    protected function getDefaultTitle()
    {
        return 'Page ' . $this->id;
    }
}