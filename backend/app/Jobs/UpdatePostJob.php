<?php

namespace App\Jobs;

use App\DTO\UpdatePostDto;
use App\Services\UpdatePostActionMediator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdatePostJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private UpdatePostDto $dto;

    public function __construct(
        UpdatePostDto $dto
    ) {
        $this->dto = $dto;
    }

    /**
     * @param UpdatePostActionMediator $updatePostActionMediator
     *
     * @return void
     */
    public function handle(UpdatePostActionMediator $updatePostActionMediator): void
    {
        $resultDto = $updatePostActionMediator->updatePost($this->dto);

        $data = serialize($resultDto);

        Queue::connection('rabbitmq')->push(env('WS_UPDATE_POST_QUEUE'), $data, env('WS_UPDATE_POST_QUEUE'));
    }
}
