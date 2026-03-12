<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrainwavePreset extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'base_frequency',
        'beat_frequency',
        'duration',
        'is_active'

    ];
}