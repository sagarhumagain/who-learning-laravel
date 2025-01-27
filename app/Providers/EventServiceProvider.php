<?php

namespace App\Providers;

use App\Events\CertificateApproveEvent;
use App\Events\CertificateUpdateEvent;
use App\Events\CourseApprovalEvent;
use App\Events\CourseAssignedEvent;
use App\Events\CourseCreatedEvent;
use App\Events\CourseUpdateEvent;
use App\Events\Welcome;
use App\Listeners\CertificateApprovalListener;
use App\Listeners\CertificateUpdateListener;
use App\Listeners\CourseApprovalListener;
use App\Listeners\CourseAssignedListener;
use App\Listeners\CourseCreatedListener;
use App\Listeners\CourseUpdateListener;
use App\Listeners\SendWelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use phpseclib3\File\ASN1\Maps\Certificate;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendWelcomeNotification::class,
        ],
        CourseCreatedEvent::class => [
            CourseCreatedListener::class,
        ],
        CourseUpdateEvent::class => [
            CourseUpdateListener::class,
        ],
        CourseAssignedEvent::class => [
            CourseAssignedListener::class,
        ],
        CertificateUpdateEvent::class => [
            CertificateUpdateListener::class,
        ],
        CourseApprovalEvent::class => [
            CourseApprovalListener::class,
        ],
        CertificateApproveEvent::class => [
            CertificateApprovalListener::class,
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

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
