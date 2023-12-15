<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'to_wallet_id',
        'from_wallet_id',
        'hash',
        'amount',
        'commission',
        'finished_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'finished_at' => 'timestamp',
    ];

    /**
     * @return BelongsTo
     */
    public function walletFrom(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'from_wallet_id');
    }

    /**
     * @return BelongsTo
     */
    public function walletTo(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }

    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            $base64String = base64_encode(random_bytes(18));
            $model->hash = serialize($base64String);
        });
    }
}
