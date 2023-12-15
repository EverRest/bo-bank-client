<?php
declare(strict_types=1);

namespace App\Repositories\Transaction;

use App\Repositories\Repository\Repository;

class TransactionRepository extends Repository
{
    /**
     * @var string
     */
    protected string $model = "App\\Models\\Transaction";
}
