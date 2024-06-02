<?php

namespace App\DTO;

class CreatePostDto
{
    public int $created_by;
    public string $title;
    public string $content;
    public string $post_number;
}
