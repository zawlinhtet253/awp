<?php

namespace App\Models;

use App\Enums\EngagementStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Engagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'financial_year_end',
        'contact_name',
        'contact_email',
        'contact_phone',
        'status',
        'created_by',
    ];

    protected $casts = [
        'financial_year_end' => 'date',
        'status' => EngagementStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function engagementStaff(): HasMany
    {
        return $this->hasMany(EngagementStaff::class);
    }

    public function staff(): HasMany
    {
        return $this->hasMany(EngagementStaff::class);
    }
}
