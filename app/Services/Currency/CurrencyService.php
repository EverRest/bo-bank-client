<?php
declare(strict_types=1);

namespace App\Services\Currency;

use App\Repositories\Currency\CurrencyRepository;
use App\Services\Service\ServiceWithRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

final class CurrencyService extends ServiceWithRepository implements CurrencyServiceInterface
{
    private const DEFAULT_CURRENCY_CODE = 'USD';

    /**
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(private readonly CurrencyRepository $currencyRepository)
    {
        $this->repository = $currencyRepository;
    }

    /**
     * @return Builder|Model
     */
    public function getDefault(): Builder|Model
    {
        return $this->currencyRepository->query()->firstWhere(['code' => self::DEFAULT_CURRENCY_CODE]);
    }

    /**
     * @param Collection $filters
     *
     * @return Collection
     */
    public function all(Collection $filters): Collection
    {
        return $this->repository->all($filters);
    }
}
