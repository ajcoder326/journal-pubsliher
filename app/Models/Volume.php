<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volume extends Model
{
    protected $fillable = [
        'title', 'description', 'cover_image', 'year',
        'issue_number', 'status', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function papers(): HasMany
    {
        return $this->hasMany(Paper::class);
    }
}