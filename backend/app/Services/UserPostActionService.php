<?php

namespace App\Services;

use App\Repositories\UserPostActionRepository;

class UserPostActionService
{
    private UserPostActionRepository $userPostActionRepository;

    public function __construct(UserPostActionRepository $userPostActionRepository)
    {
        $this->userPostActionRepository = $userPostActionRepository;
    }

    /**
     * @param int $idUser
     * @param int $idPost
     * @param string $action
     *
     * @return int
     */
    public function create(int $idUser, int $idPost, string $action): int
    {
        return $this->userPostActionRepository->create([
            'id_user' => $idUser,
            'id_post' => $idPost,
            'action' => $action
        ]);
    }
}
