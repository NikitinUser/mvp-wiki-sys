<?php

namespace App\DTO;

class UpdatePostDto
{
    public int $id;
    public int $created_by;
    public string $title;
    public string $content;
    public ?int $version = null;
}
