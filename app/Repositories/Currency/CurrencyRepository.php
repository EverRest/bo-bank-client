<?php
declare(strict_types=1);

namespace App\Repositories\Currency;

use App\Repositories\Repository\Repository;
use App\Repositories\Repository\RepositoryInterface;

class CurrencyRepository extends Repository
{
    /**
     * @var string
     */
    protected string $model = "App\\Models\\Currency";
}
