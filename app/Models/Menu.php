<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'title', 'url', 'route_name', 'location', 'parent_id',
        'sort_order', 'is_active', 'icon', 'target',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Get the resolved URL for this menu item
     */
    public function getResolvedUrlAttribute(): string
    {
        if ($this->url) {
            return $this->url;
        }
        if ($this->route_name && \Route::has($this->route_name)) {
            return route($this->route_name);
        }
        return '#';
    }

    /**
     * Scope to get only top-level (no parent) menu items
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get menu items by location
     */
    public function scopeLocation($query, string $location)
    {
        return $query->where('location', $location);
    }
}
