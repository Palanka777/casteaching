<?php

namespace App\Listeners;

use App\Events\VideoCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Tests\Unit\SendVideoCreatedNotificationTest;


class SendVideoCreatedNotification implements ShouldQueue
{
public static function testedby(){
    return SendVideoCreatedNotificationTest::class;
}

    /**
     * Handle the event.
     *
     * @param  VideoCreated  $event
     * @return void
     */
    public function handle(VideoCreated $event)
    {
        Notification::route('mail', 'dpont@iesebre.com')->notify(new \App\Notifications\VideoCreated($event->video));

    }
}
