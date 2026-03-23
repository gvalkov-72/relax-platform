<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statistic extends Model
{
    use HasFactory;

    protected $table = 'statistics';

    protected $fillable = [
        'user_id',
        'session_type',
        'duration',
        'frequency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}