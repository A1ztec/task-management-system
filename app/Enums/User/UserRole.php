<?php


namespace App\Enums\User;


enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';




    public function title(): string
    {
        return match ($this) {
            self::ADMIN => __('Admin'),
            self::USER => __('User')
        };
    }


    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($item) => [$item->value => $item->title()])->toArray();
    }
}
