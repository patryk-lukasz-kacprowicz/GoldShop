<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Policies\ActivityPolicy;
use App\Policies\ExceptionPolicy;
use App\Policies\QueuePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Spatie\Activitylog\Models\Activity as ActivityModel;
use BezhanSalleh\FilamentExceptions\Models\Exception as ExceptionModel;
use \Croustibat\FilamentJobsMonitor\Models\QueueMonitor as QueueModel;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ActivityModel::class => ActivityPolicy::class,
        ExceptionModel::class => ExceptionPolicy::class,
        QueueModel::class => QueuePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
