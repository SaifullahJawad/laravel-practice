<?php

namespace App\Services;

interface Newsletter
{
    //these methods HAS to be implemented
    public function subscribe(string $email, string $list = null);
}
