<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

/**
 * @property int $user_id
 * @property int $currency_id
 * @property float $balance
 * @property string $name
 */
class Wallet extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'currency_id',
        'balance',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
      'created_at' => 'timestamp'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * @return HasMany
     */
    public function transactionsFrom(): HasMany
    {
        return $this->hasMany(Transaction::class, 'from_wallet_id');
    }

    /**
     * @return HasMany
     */
    public function transactionsTo(): HasMany
    {
        return $this->hasMany(Transaction::class, 'to_wallet_id');
    }

    /**
     * Get all transactions associated with the wallet (both from and to transactions) and order by created_at.
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'from_wallet_id')
            ->orWhere('to_wallet_id', $this->id)
            ->orderBy('created_at');
    }

    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            $model->name = Str::uuid()->toString();
        });
    }
}
