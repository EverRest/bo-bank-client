<?php
declare(strict_types=1);

namespace App\Services\Currency;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CurrencyServiceInterface
{
    /**
     * @param Collection $filters
     *
     * @return Collection
     */
    public function all(Collection $filters): Collection;

    /**
     * @return Builder|Model
     */
    public function getDefault(): Builder|Model;
}
