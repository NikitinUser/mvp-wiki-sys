<?php

namespace App\Repositories;

use App\Models\UserPostAction;
use Illuminate\Database\Eloquent\Collection;

class UserPostActionRepository
{
    /**
     * @param array $actionData
     *
     * @return int
     */
    public function create(array $actionData): int
    {
        return UserPostAction::insertGetId($actionData);
    }
}
