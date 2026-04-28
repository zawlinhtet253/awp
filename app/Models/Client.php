<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'registration_number',
        'address',
        'phone',
        'email',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the industry types for the client.
     */
    public function industryTypes(): BelongsToMany
    {
        return $this->belongsToMany(IndustryType::class, 'client_industry', 'client_id', 'industry_id');
    }

    /**
     * Get the engagements for the client.
     */
    public function engagements(): HasMany
    {
        return $this->hasMany(Engagement::class);
    }
}
