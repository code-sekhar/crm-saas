<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\LeadNote;

class Lead extends Model
{
    protected $fillable = [
        'tenant_id',
        'assigned_to',
        'name',
        'email',
        'phone',
        'source',
        'status',
        'notes'
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function leadNotes()
    {
        return $this->hasMany(LeadNote::class);
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }
}
