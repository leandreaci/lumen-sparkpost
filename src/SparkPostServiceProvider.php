<?php

namespace Leandreaci\Lumen\SparkPost;

use GuzzleHttp\Client;
use Illuminate\Mail\MailManager;
use Illuminate\Support\ServiceProvider;
use Leandreaci\Lumen\SparkPost\Transport\SparkPostTransport;

/**
 * Class SparkPostServiceProvider.
 *
 * @package Leandreaci\Lumen\SparkPost
 */
class SparkPostServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
     */
    public function register(): void
    {
        $this->app->extend('mail.manager', function(MailManager $manager) {
            $manager->extend('sparkpost', function() {
                $config = config('mail.mailers.sparkpost', []);
                $sparkpostOptions = $config['mail.mailers.sparkpost.options'] ?? [];
                $guzzleOptions = $config['mail.mailers.sparkpost.guzzle'] ?? [];
                $client = $this->app->make(Client::class, $guzzleOptions);

                return new SparkPostTransport($client, $config['secret'], $sparkpostOptions);
            });

            return $manager;
        });
    }
}
