<?php
declare(strict_types=1);

namespace App\Repositories\Repository;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    /**
     * Get a list of models
     *
     * @param Collection $data
     *
     * @return Paginator
     */
    public function index(Collection $data): Paginator;

    /**
     * @param int $id
     *
     * @return Model
     */
    public function find(int $id): Model;

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @param Collection $filters
     *
     * @return Collection
     */
    public function all(Collection $filters): Collection;

    /**
     * @param Collection $data
     *
     * @return Model
     */
    public function store(Collection $data): Model;

    /**
     * Update and refresh model
     *
     * @param Model $model
     * @param Collection $data
     *
     * @return Model
     */
    public function update(Model $model, Collection $data): Model;

    /**
     * Delete the model from the database within a transaction.
     *
     * @param Model $model
     * @param bool $force
     *
     * @return Model
     */
    public function destroy(Model $model, bool $force = false): Model;

    /**
     * @return EloquentBuilder
     */
    public function query(): EloquentBuilder;
}
