<?php

namespace Tests\Unit;



use App\Events\VideoCreated;
use App\Listeners\SendVideoCreatedNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\AnonymousNotifiable;

use Illuminate\Support\Facades\Notification;
use Psy\Util\Str;
use Tests\TestCase;

/**
 * @covers SendVideoCreatedNotification::class
 */

class SendVideoCreatedNotificationTest extends TestCase
{
    use DatabaseMigrations;

    /**@test*/

    public function handle_send_video_created_notification()
    {
        $sender = new SendVideoCreatedNotification();

        Notification::fake();

        $sender->handle(new VideoCreated($video=create_default_video()));

        $admins=config('casteaching.admins');

        Notification::assertSentTo(
            new AnonymousNotifiable, SendVideoCreatedNotification::class,
            function($notification,$channels,$notificable) use ($admins,$video){
                return in_array('mail',$channels)&&($notificable->routes['mail']=== $admins)&& Str::contains($notification->toMail($notificable)->render(),$video->title);
            }
        );
    }
}
