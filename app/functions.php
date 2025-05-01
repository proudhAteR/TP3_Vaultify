<?php

use Models\Services\AccountService;
use Zephyrus\Security\Cryptography;

function can_display(string $title): bool
{
    return strcasecmp($title, 'Login') !== 0
        && strcasecmp($title, 'Register') !== 0;
}

function verify(string $clear, string $hash): bool
{
    return Cryptography::verifyHashedPassword($clear, $hash);
}

function get_profile(): string
{
    return AccountService::get_user()->profile;
}