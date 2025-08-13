<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Request;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status->value,
                'priority' => $this->priority->value,
                'due_date' => $this->due_date,
                'user' => UserResource::make($this->whenLoaded('user'))
            ];
    }
}
