<?php

namespace Tests\Unit;

use App\Events\VideoCreated as VideoCreatedEvent;
use App\Listeners\SendVideoCreatedNotification;
use App\Notifications\VideoCreated as VideoCreatedNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;
/**
 * @covers SendVideoCreatedNotification::class
 */

class SendVideoCreatedNotificationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */

    public function handle_send_video_created_notification()
    {
        $sender = new SendVideoCreatedNotification();

        Notification::fake();

        $sender->handle(new VideoCreatedEvent($video=create_default_video()));

        $admins=config('casteaching.admins');

        Notification::assertSentTo(
            new AnonymousNotifiable, VideoCreatedNotification::class,
            function($notification,$channels,$notificable) use ($admins,$video){
                return in_array('mail',$channels)&&($notificable->routes['mail']=== $admins)&& Str::contains($notification->toMail($notificable)->render(),$video->title);
            }
        );
    }
}
