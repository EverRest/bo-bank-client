<?php
declare(strict_types=1);

namespace App\Services\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface TransactionServiceInterface
{
    /**
     * @param Collection $attributes
     *
     * @return Model
     */
    public function create(Collection $attributes): Model;

    /**
     * @param int $id
     *
     * @return Model
     */
    public function getById(int $id): Model;
}
