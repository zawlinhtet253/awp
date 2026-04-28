<?php

namespace App\Models;

use App\Enums\EngagementRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EngagementStaff extends Model
{
    protected $fillable = [
        'engagement_id',
        'user_id',
        'role_on_engagement',
        'assigned_by',
    ];

    protected $casts = [
        'role_on_engagement' => EngagementRole::class,
        'assigned_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function engagement(): BelongsTo
    {
        return $this->belongsTo(Engagement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
