<?php
declare(strict_types=1);

namespace App\Repositories\User;

use App\Repositories\Repository\Repository;

class UserRepository extends Repository
{
    /**
     * @var string
     */
    protected string $model = "App\\Models\\User";

    /**
     * @var array
     */
    protected array $searchable_attributes = [
        'name',
        'email'
    ];
}
