<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paper extends Model
{
    protected $fillable = [
        'user_id', 'volume_id', 'title', 'abstract', 'authors',
        'keywords', 'doi', 'document_path', 'final_document_path', 'status', 'submitted_at', 'published_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function volume(): BelongsTo
    {
        return $this->belongsTo(Volume::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function assignedReviewers(): HasMany
    {
        return $this->hasMany(Reviewer::class);
    }
}