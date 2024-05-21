<?php

namespace App\Providers;

use App\Events\BeforeValidate;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;

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
        BeforeValidate::class => [

        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $this->getListeners("BeforeUpdate");
        $this->getListeners("AfterUpdate");
        $this->getListeners("BeforeCreate");
        $this->getListeners("AfterCreate");
    }

    public function getListeners($event)
    {
        $listeners = File::allFiles(app_path("Listeners".DIRECTORY_SEPARATOR.$event));

        foreach ($listeners as $listener){
            $className = "App\Listeners\\$event\\".basename($listener, '.php');
            if(class_exists($className)){
                Event::listen("App\Events\\$event", $className);
            }
        }
    }
}
