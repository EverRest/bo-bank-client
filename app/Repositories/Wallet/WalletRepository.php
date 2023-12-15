<?php
declare(strict_types=1);

namespace App\Repositories\Wallet;

use App\Repositories\Repository\Repository;
use Illuminate\Support\Collection;

class WalletRepository extends Repository
{
    /**
     * @var string
     */
    protected string $model = "App\\Models\\Wallet";

    /**
     * @param int $userId
     * @return Collection
     */
    public function getWalletsByUserId(int $userId): Collection
    {
        return $this->query()
            ->where('user_id', $userId)
            ->get();
    }
}
