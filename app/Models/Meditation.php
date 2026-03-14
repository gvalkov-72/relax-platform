<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meditation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'is_active'
    ];

    public function items()
    {
        return $this->hasMany(MeditationItem::class);
    }

    public function tracks()
    {
        return $this->hasMany(MeditationTrack::class)
            ->orderBy('position');
    }
}
