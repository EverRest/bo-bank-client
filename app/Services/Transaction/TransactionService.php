<?php
declare(strict_types=1);

namespace App\Services\Transaction;

use App\Jobs\Transfer;
use App\Repositories\Transaction\TransactionRepository;
use App\Services\Service\ServiceWithRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

final class TransactionService extends ServiceWithRepository implements TransactionServiceInterface
{
    /**
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->repository = $transactionRepository;
    }

    /**
     * @param Collection $attributes
     *
     * @return Model
     */
    public function create(Collection $attributes): Model
    {
        $transaction = $this->repository->store($attributes);
        Transfer::dispatch($transaction->id);

        return $transaction;
    }
}
