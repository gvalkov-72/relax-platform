<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany; // добавете този use

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'excerpt',
        'body',
        'created_by',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function shares()
    {
        return $this->hasMany(ContentShare::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function canView(User $user)
    {
        if ($this->created_by === $user->id) return true;
        return $this->shares()
            ->where('user_id', $user->id)
            ->whereIn('permission', ['view', 'edit'])
            ->exists();
    }

    public function canEdit(User $user)
    {
        if ($this->created_by === $user->id) return true;
        return $this->shares()
            ->where('user_id', $user->id)
            ->where('permission', 'edit')
            ->exists();
    }

    public function canDelete(User $user)
    {
        return $this->created_by === $user->id;
    }
}