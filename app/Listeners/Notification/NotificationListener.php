<?php

namespace App\Listeners\Notification;

use App\Events\Notification\NotificationEvent;
use App\Notifications\User\NewUserNotification;
use App\Services\Log\LogService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Throwable;

class NotificationListener implements ShouldQueue
{
    use InteractsWithQueue;

    private $logService;

    /**
     * Create the event listener.
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationEvent $event): void
    {
        $this->logService->info('Notification listener');
        $event->user->notify(new NewUserNotification($event->user));
    }

    /**
     * Handle a job failure.
     */
    public function failed(NotificationEvent $event, Throwable $exception): void
    {
        $this->logService->error( json_encode($exception));
    }
}
