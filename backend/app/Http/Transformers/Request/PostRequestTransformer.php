<?php

namespace App\Http\Transformers\Request;

use App\DTO\CreatePostDto;
use App\DTO\UpdatePostDto;
use App\Http\Transformers\BaseTransformer;
use Ramsey\Uuid\Uuid;

class PostRequestTransformer extends BaseTransformer
{
    /**
     * @param array $requestData
     *
     * @return CreatePostDto
     */
    public function createPostTrasform(array $requestData): CreatePostDto
    {
        $dto = $this->arrayToDto($requestData, CreatePostDto::class);

        $dto->created_by = auth()->user()->id;
        $dto->post_number = Uuid::uuid4()->toString();

        return $dto;
    }

    /**
     * @param array $requestData
     *
     * @return UpdatePostDto
     */
    public function updatePostTrasform(array $requestData): UpdatePostDto
    {
        $dto = $this->arrayToDto($requestData, UpdatePostDto::class);

        $dto->created_by = auth()->user()->id;

        return $dto;
    }
}
