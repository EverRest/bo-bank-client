<?php
declare(strict_types=1);

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use App\Services\Service\ServiceWithRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class UserService extends ServiceWithRepository implements UserServiceInterface
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * @param string $apiKey
     *
     * @return Builder|Model|null
     */
    public function getUserByApiKey(string $apiKey): null|Builder|Model
    {
        return $this->repository->query()->where(['api_key' => $apiKey])->first();
    }
}
