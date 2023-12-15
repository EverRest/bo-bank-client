<?php
declare(strict_types=1);

namespace App\Services\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    /**
     * @param Collection $filters
     *
     * @return Collection
     */
    public function all(Collection $filters): Collection;

    /**
     * @param int $id
     *
     * @return Model
     */
    public function getById(int $id): Model;
}
