<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'content_id',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}