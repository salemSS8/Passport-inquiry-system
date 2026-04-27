<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PassportApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'branch_id',
        'serial_number',
        'national_id',
        'full_name',
        'status',
        'photo_path',
        'tracking_number'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function statusUpdates(): HasMany
    {
        return $this->hasMany(StatusUpdate::class);
    }
}
