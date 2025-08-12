<?php

namespace App\Enums\Task;


enum TaskStatus: string
{
    case PENDING = 'pending';

    case IN_PROGRESS = 'in_progress';

    case DONE = 'done';



    public function message(): string
    {
        return match ($this) {
            self::PENDING => __('Your Task is Pending'),
            self::IN_PROGRESS => __('Your Task In Progress'),
            self::DONE => __('Your Task Is Done'),
        };
    }



    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($item) => [$item->value => $item->message()])->toArray();
    }
}
