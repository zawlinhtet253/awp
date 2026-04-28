<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function createdEngagements(): HasMany
    {
        return $this->hasMany(Engagement::class, 'created_by');
    }

    public function engagementStaff(): HasMany
    {
        return $this->hasMany(EngagementStaff::class, 'user_id');
    }

    public function assignedEngagementStaff(): HasMany
    {
        return $this->hasMany(EngagementStaff::class, 'assigned_by');
    }
}
