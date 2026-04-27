<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class IndustryType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
    ];

    /**
     * Get the clients for the industry type.
     */
    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'client_industry', 'industry_id', 'client_id');
    }
}