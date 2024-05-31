<?php

namespace App\Enums;

class UserPostAction
{
    public const ACTION_CREATED = 'created';
    public const ACTION_ACTIVATE = 'activate';
    public const ACTION_INACTIVATE = 'inactivate';

    public static function all(): array
    {
        return [
            self::ACTION_CREATED,
            self::ACTION_ACTIVATE,
            self::ACTION_INACTIVATE
        ];
    }
}
