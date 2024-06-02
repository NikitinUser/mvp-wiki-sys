<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository
{
    /**
     * @param int $id
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return Post::get();
    }

    /**
     * @param int $id
     *
     * @return Post|null
     */
    public function findById(int $id): ?Post
    {
        return Post::where('id', $id)
            ->first();
    }

    /**
     * @param string $postNumber
     *
     * @return Post|null
     */
    public function findActiveByPostNumber(string $postNumber): ?Post
    {
        return Post::where('post_number', $postNumber)
            ->where('is_active', true)
            ->first();
    }

    /**
     * @param string $postNumber
     *
     * @return int
     */
    public function findActualVersion(string $postNumber): int
    {
        return Post::select('version')
            ->where('post_number', $postNumber)
            ->max('version');
    }

    /**
     * @param array $postData
     *
     * @return int
     */
    public function create(array $postData): int
    {
        return Post::insertGetId($postData);
    }

    /**
     * @param int $idPost
     * @param bool $active
     *
     * @return void
     */
    public function setActiveStatus(int $idPost, bool $active): void
    {
        Post::where('id', $idPost)
            ->update([
                'is_active' => $active
            ]);
    }
}
