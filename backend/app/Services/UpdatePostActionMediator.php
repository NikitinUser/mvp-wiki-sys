<?php

namespace App\Services;

use App\DTO\UpdatePostDto;
use App\DTO\ResultUpdatingPostDto;
use App\Enums\UserPostAction;
use App\Services\PostServie;
use App\Services\UserPostActionService;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdatePostActionMediator
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

    public function updatePost(UpdatePostDto $dto): ResultUpdatingPostDto
    {
        $resultDto = new ResultUpdatingPostDto();

        DB::beginTransaction();

        try {
            $post = $this->postServie->getById($dto->id);
            $actualVersion = $this->postServie->getActualVersion($post['post_number']);
            $resultDto->idActive = $this->postServie->getActiveIdByPostNumber($post['post_number']);

            $dto->version = $actualVersion++;
            $dto->post_number = $post['post_number'];
            unset($dto->id);

            $resultDto->postId = $this
                ->postServie
                ->update($dto);

            $this
                ->postServie
                ->setActiveStatus($resultDto->idActive, false);

            $resultDto->actionIdCreate = $this
                ->userPostActionService
                ->create(
                    $dto->created_by,
                    $resultDto->postId,
                    UserPostAction::ACTION_CREATED
                );

            $resultDto->actionIdUpdate = $this
                ->userPostActionService
                ->create(
                    $dto->created_by,
                    $resultDto->idActive,
                    UserPostAction::ACTION_INACTIVATE
                );

            DB::commit();
        } catch (Throwable $t) {
            DB::rollBack();
            throw $t;
        }

        return $resultDto;
    }
}
