<?php
declare(strict_types=1);

namespace App\Services\Service;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class ServiceWithRepository
{
    protected $repository;

    /**
     * @param Collection $attributes
     *
     * @return Paginator
     */
    public function index(Collection $attributes): Paginator
    {
        return $this->repository->index($attributes);
    }

    /**
     * @param int $id
     *
     * @return Model
     */
    public function getById(int $id): Model
    {
        return $this->repository->find($id);
    }

    /**
     * @param Collection $attributes
     *
     * @return Model
     */
    public function create(Collection $attributes): Model
    {
        return $this->repository->store($attributes);
    }

    /**
     * @param Model $model
     * @param Collection $attributes
     *
     * @return Model
     */
    public function update(Model $model, Collection $attributes): Model
    {
        return $this->repository->update($model, $attributes);
    }

    /**
     * @param Model $model
     *
     * @return Model
     */
    public function delete(Model $model): Model
    {
        return $this->repository->destroy($model);
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
