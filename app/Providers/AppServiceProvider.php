<?php

namespace App\Providers;

use App\Models\FollowUp;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->deleteExpiredFollowUps();
    }

    /**
     * Delete follow-up records that are older than 1 hour.
     *
     * @return void
     */
    public function deleteExpiredFollowUps()
    {
        $expiredFollowUps = FollowUp::where('created_at', '<', Carbon::now()->subHour())
            ->get();

        foreach ($expiredFollowUps as $followUp) {
            $followUp->delete();
        }
    }
}
