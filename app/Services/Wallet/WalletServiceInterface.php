<?php
declare(strict_types=1);

namespace App\Services\Wallet;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface WalletServiceInterface
{
    /**
     * @param int $id
     *
     * @return Model
     */
    public function getById(int $id): Model;

    /**
     * @param Collection $attributes
     *
     * @return Model
     */
    public function create(Collection $attributes): Model;

    /**
     * @return ?Wallet
     */
    public function getStorageWallet(): ?Wallet;

    /**
     * @param Collection $filters
     *
     * @return Collection
     */
    public function all(Collection $filters): Collection;

    /**
     * @return mixed
     */
    public function generateUniqueWalletName(): mixed;

    /**
     * @param int $fromWalletId
     * @param int $toWalletId
     * @param float|int $amount
     *
     * @return mixed
     */
    public function hasAbilityForTransactionById(int $fromWalletId, int $toWalletId, float|int $amount): bool;

    /**
     * @param Wallet $fromWallet
     * @param Wallet $toWallet
     *
     * @return float|int
     */
    public static function getCommission(Wallet $fromWallet, Wallet $toWallet):float|int;
}
