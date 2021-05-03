<?php

namespace App\Providers;

use App\Events\ProjectReviewedEvent;
use App\Events\UserCreated;
use App\Listeners\SendNewUserNotification;
use App\Listeners\SendNotificationToOwnerOfProjectReviewed;
use App\Models\Project;
use App\Notifications\NotifyOwnerOfProjectReviewed;
use App\Notifications\SendEmailToNewUserNotification;
use App\Observers\ProjectObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SocialiteWasCalled::class => [
//            'SocialiteProviders\\Discord\\DiscordExtendSocialite@handle',
//            'SocialiteProviders\\Discord\\GoogleExtendSocialite@handle',
        ],
        UserCreated::class => [
            SendNewUserNotification::class,
        ],
        ProjectReviewedEvent::class => [
            SendNotificationToOwnerOfProjectReviewed::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
