<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionTranslation extends Model
{
    protected $fillable = [
        'section_id',
        'language_id',
        'title',
        'subtitle',
        'data'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}