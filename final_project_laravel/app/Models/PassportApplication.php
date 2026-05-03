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
        'pickup_branch_id',
        'serial_number',
        'national_id',
        'full_name',
        'mother_name',
        'date_of_birth',
        'gender',
        'address',
        'status',
        'photo_path',
        'tracking_number',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function pickupBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'pickup_branch_id');
    }

    public function statusUpdates(): HasMany
    {
        return $this->hasMany(StatusUpdate::class);
    }

    /**
     * Arabic labels for application statuses.
     *
     * @var array<string, string>
     */
    public const STATUS_LABELS = [
        'pending' => 'قيد الانتظار',
        'processing' => 'جاري المعالجة',
        'ready' => 'جاهز للاستلام',
        'collected' => 'تم التسليم',
        'cancelled' => 'ملغي',
        'archived' => 'مؤرشف',
    ];

    /**
     * Get the Arabic label for the current status.
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }
}
