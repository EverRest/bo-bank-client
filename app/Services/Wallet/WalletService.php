<?php
declare(strict_types=1);

namespace App\Services\Wallet;

use App\Models\Wallet;
use App\Repositories\Wallet\WalletRepository;
use App\Services\Service\ServiceWithRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

final class WalletService extends ServiceWithRepository implements WalletServiceInterface
{
    /**
     * @param WalletRepository $walletRepository
     */
    public function __construct(WalletRepository $walletRepository)
    {
        $this->repository = $walletRepository;
    }

    /**
     * @param int $fromWalletId
     * @param int $toWalletId
     * @param int|float $amount
     *
     * @return mixed
     */
    public function hasAbilityForTransactionById(int $fromWalletId, int $toWalletId, float|int $amount): bool
    {
        /**
         * @var Wallet $fromWallet
         */
        $fromWallet = $this->getById($fromWalletId);
        /**
         * @var Wallet $toWallet
         */
        $toWallet = $this->getById($toWalletId);
        $operationCostInPercents = self::getCommission($fromWallet, $toWallet);
        $operationCost = $operationCostInPercents * $amount;

        return $fromWallet->balance >= $amount + $operationCost;
    }

    /**
     * @param Wallet $fromWallet
     * @param Wallet $toWallet
     *
     * @return float|int
     */
    public static function getCommission(Wallet $fromWallet, Wallet $toWallet):float|int
    {
        $transferCost = Config::get('admin.transfer_commission');
        $exchangeCost = Config::get('admin.exchange_commission');
        $commission = $transferCost;
        if($fromWallet->currency_id !== $toWallet->currency_id) {
            $commission+=$exchangeCost;
        }

        return $commission/100;
    }

    /**
     * @return mixed
     */
    public function generateUniqueWalletName(): mixed
    {
        return Str::uuid();
    }

    /**
     * @return ?Wallet
     */
    public function getStorageWallet(): ?Wallet
    {
        /**
         * @var Wallet|null $model
         */
        $model =  $this->repository->query()->firstWhere(['is_storage' => 1]);

        return $model;
    }
}
