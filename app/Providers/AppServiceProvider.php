<?php

namespace App\Providers;

use App\Services\Newsletter;
use App\Services\MailChimpNewsletter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use MailchimpMarketing\ApiClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind('foo', function () {
        //     return 'bar';
        // });

        app()->bind(Newsletter::class, function () {

            $client = new ApiClient();
            
            $client->setConfig([
                'apiKey' => config('services.mailchimp.key'),
                'server' => 'us17'
            ]);
            
            return new MailChimpNewsletter($client);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Model::unguard();
    }
}
