<?php
declare(strict_types=1);

namespace App\Repositories\Repository;

use App\Enums\IndexRequestEnum;
use Closure;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Throwable;

class Repository implements RepositoryInterface
{
    /**
     * @var string
     */
    protected string $model;

    /**
     * @var array
     */
    protected array $searchable_attributes = [
    ];

    /**
     * @var int
     */
    protected int $default_limit = 10;

    /**
     * @var string
     */
    protected string $default_direction = 'DESC';

    /**
     * @var string
     */
    protected string $default_sort_column = 'id';

    /**
     * Get a list of models
     *
     * @param Collection $data
     *
     * @return Paginator
     */
    public function index(Collection $data): Paginator
    {
        $query = $this->search($data);
        $this->filter(
            $query,
            $data->except(IndexRequestEnum::values())
        );
        $this->sort(
            $query,
            $data,
        );
        return $this->paginate($query, $data);
    }

    /**
     * @param int $id
     *
     * @return Model
     */
    public function find(int $id): Model
    {
        return $this->model::findOrFail($id);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->query()->count();
    }

    /**
     * @param Collection $filters
     *
     * @return Collection
     */
    public function all(Collection $filters): Collection
    {
        $q = $this->query();
        $filters->whenNotEmpty(fn (Collection $filters) => $filters->each(fn($value, $key) => $q->where($key, $value)));

        return $q->get();
    }

    /**
     * @param Collection $data
     *
     * @return Model
     */
    public function store(Collection $data): Model
    {
        return $this->model::create($data->toArray());
    }

    /**
     * @param Collection $data
     *
     * @return Model
     */
    public function firstOrCreate(Collection $data): Model
    {
        return $this->model::firstOrCreate($data->toArray());
    }

    /**
     * Update and refresh model
     *
     * @param Model $model
     * @param Collection $data
     *
     * @return Model
     */
    public function update(Model $model, Collection $data): Model
    {
        $model->fill($data->toArray())->save();
        return $model->refresh();
    }

    /**
     * Delete the model from the database within a transaction.
     *
     * @param Model $model
     * @param bool $force
     *
     * @return Model
     * @throws Throwable
     */
    public function destroy(Model $model, bool $force = false): Model
    {
        if ($force) {
            $model->forceDelete();
        } else {
            $model->deleteOrFail();
        }
        return $model;
    }

    /**
     * @return EloquentBuilder
     */
    public function query(): EloquentBuilder
    {
        /**
         * @var Model $model
         */
        $model = App::make($this->model);

        return $model::query();
    }

    /**
     * @param $query
     * @param Collection $data
     *
     * @return EloquentBuilder
     */
    protected function sort($query, Collection $data): EloquentBuilder
    {
        $sort = $this->getSortColumn($data);
        $order = $this->getDirectionColumn($data);
        $query->when($sort, function ($query) use ($sort, $order) {
            return $query->orderBy($sort, $order);
        });

        return $query;
    }

    /**
     * @param Collection $data
     *
     * @return string|Closure|null
     */
    protected function getSortColumn(Collection $data): string|Closure|null
    {
        return $data->has(IndexRequestEnum::sortKey->value) ? $data->get(IndexRequestEnum::sortKey->value) : $this->default_sort_column;
    }

    /**
     * @param Collection $data
     *
     * @return string|Closure|null
     */
    protected function getDirectionColumn(Collection $data): string|Closure|null
    {
        return $data->has(IndexRequestEnum::sortKey->value) ?
            $data->get(IndexRequestEnum::sortKey->value) : $this->default_direction;
    }

    /**
     * @param Collection $data
     *
     * @return EloquentBuilder
     */
    protected function search(Collection $data): EloquentBuilder
    {
        $query = $this->query();
        if ($data->has(IndexRequestEnum::searchKey->value)) {
            $searchQuery = $data->get(IndexRequestEnum::searchKey->value);
            $columns = $this->searchable_attributes;
            if(empty($searchable_attributes)) {
                $columns = $this->model::getFillable();
            }
            foreach ($columns as $column) {
                $query->where($column, 'like', "%$searchQuery%");
            }
        }

        return $this->query();
    }

    /**
     * @param $query
     * @param Collection $filter
     *
     * @return EloquentBuilder
     */
    protected function filter($query, Collection $filter): EloquentBuilder
    {
        $query->when($filter, fn($query) => $this->applyFilter($query, $filter));

        return $query;
    }

    /**
     * @param mixed $query
     * @param Collection $filter
     *
     * @return mixed
     */
    protected function applyFilter(mixed $query, Collection $filter): mixed
    {
        foreach ($filter as $filterKey => $filterValue) {
            if (!is_string($filterKey)) {
                continue;
            }
            if (is_array($filterValue)) {
                $query->whereIn($filterKey, $filterValue);
            } else {
                $query->where($filterKey, $filterValue);
            }
        }

        return $query;
    }

    /**
     * @param $query
     * @param Collection $data
     *
     * @return Paginator
     */
    protected function paginate($query, Collection $data): Paginator
    {
        $limit = $data->has(IndexRequestEnum::limitKey->value) ? intval($data->get(IndexRequestEnum::limitKey->value))
            : $this->default_limit;

        return $query->paginate($limit);
    }

    /**
     * @return Model
     */
    protected function model(): Model
    {
        return new $this->model();
    }
}
