<?php

namespace App\Services;

use App\DTO\CreatePostDto;
use App\DTO\ResultCreatingPostDto;
use App\Enums\UserPostAction;
use App\Services\PostServie;
use App\Services\UserPostActionService;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreatePostActionMediator
{
    private PostServie $postServie;
    private UserPostActionService $userPostActionService;

    public function __construct(
        PostServie $postServie,
        UserPostActionService $userPostActionService
    ) {
        $this->postServie = $postServie;
        $this->userPostActionService = $userPostActionService;
    }

    public function createPost(CreatePostDto $dto): ResultCreatingPostDto
    {
        $resultDto = new ResultCreatingPostDto();

        DB::beginTransaction();

        try {
            $resultDto->postId = $this
                ->postServie
                ->create($dto);

            $resultDto->actionId = $this
                ->userPostActionService
                ->create(
                    $dto->created_by,
                    $resultDto->postId,
                    UserPostAction::ACTION_CREATED
                );

            DB::commit();
        } catch (Throwable $t) {
            DB::rollBack();
            throw $t;
        }

        return $resultDto;
    }
}
