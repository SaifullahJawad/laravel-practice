<?php

namespace App\Services;

use MailchimpMarketing\ApiClient;

class MailChimpNewsletter implements Newsletter
{
    protected $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function subscribe(string $email, string $list = null)
    {
        $list ??= config('services.mailchimp.lists.subscribers'); //?? is the nullsafe operator; ??= implies if list is null, assign the config value

        return $this->client->lists->addListMember($list, [
            'email_address' => $email,
            'status' => 'subscribed'
        ]);
    }

}
