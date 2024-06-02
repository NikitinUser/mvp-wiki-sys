<?php

namespace App\Services;

use App\DTO\CreatePostDto;
use App\DTO\UpdatePostDto;
use App\Repositories\PostRepository;

class PostServie
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->postRepository->findAll()->toArray();
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getById(int $id): array
    {
        $post = $this->postRepository->findById($id);
        return $post?->toArray() ?? [];
    }

    /**
     * @param string $postNumber
     *
     * @return int|null
     */
    public function getActiveIdByPostNumber(string $postNumber): ?int
    {
        $post = $this->postRepository->findActiveByPostNumber($postNumber);

        return $post?->id;
    }

    /**
     * @param CreatePostDto $dto
     *
     * @return int
     */
    public function create(CreatePostDto $dto): int
    {
        return $this->postRepository->create((array)$dto);
    }

    /**
     * @param CreatePostDto $dto
     *
     * @return int
     */
    public function update(UpdatePostDto $dto): int
    {
        return $this->postRepository->create((array)$dto);
    }

    /**
     * @param string $postNumber
     *
     * @return int
     */
    public function getActualVersion(string $postNumber): int
    {
        return $this->postRepository->findActualVersion($postNumber);
    }

    /**
     * @param int $idPost
     * @param bool $active
     *
     * @return void
     */
    public function setActiveStatus(int $idPost, bool $active = true): void
    {
        $this->postRepository->setActiveStatus($idPost, $active);
    }
}
