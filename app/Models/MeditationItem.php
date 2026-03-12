<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeditationItem extends Model
{
    protected $fillable = [
        'meditation_id',
        'item_type',
        'item_id',
        'volume',
        'start_time',
        'duration'
    ];

    public function meditation()
    {
        return $this->belongsTo(Meditation::class);
    }

    public function audio()
    {
        return $this->belongsTo(AudioFile::class, 'item_id');
    }

    public function brainwave()
    {
        return $this->belongsTo(BrainwavePreset::class, 'item_id');
    }
}