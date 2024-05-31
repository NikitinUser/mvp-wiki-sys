<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPostAction extends Model
{
    use HasFactory;

    protected $table = 'user_post_actions';

    protected $fillable = [
        'id',
        'id_user',
        'id_post',
        'action'
    ];
}
