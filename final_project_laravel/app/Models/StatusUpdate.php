<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'passport_application_id',
        'status',
        'comment',
        'updated_by'
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(PassportApplication::class, 'passport_application_id');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
