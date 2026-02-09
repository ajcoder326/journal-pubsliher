<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'address', 'bio', 'avatar', 'affiliation',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function papers()
    {
        return $this->hasMany(Paper::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reviewerAssignments()
    {
        return $this->hasMany(Reviewer::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return in_array($this->role, ['admin', 'editor', 'editor_in_chief']);
    }

    public function canManage(): bool
    {
        return in_array($this->role, ['admin', 'editor', 'editor_in_chief']);
    }
}