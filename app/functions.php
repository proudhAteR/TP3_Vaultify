<?php

use Controllers\AppController;
use Models\Services\AccountService;
use Models\Services\VaultService;

function authentication_view(string $title): bool
{
    return strcasecmp($title, 'Login') === 0 ||
        strcasecmp($title, 'Mfa') === 0
        || strcasecmp($title, 'Register') === 0;
}

function get_avatar(): string
{
    return AccountService::get_user()->avatar;
}

function is_profile(string $page): bool
{
    return strcasecmp($page, 'Profile') === 0;
}

function get_vaults(): array
{
    return AppController::isAuth() ? VaultService::get_vaults() : [];
}

function get_infos(): array
{
    $user = AccountService::get_user();
    return ['username' => $user->username, 'mail' => $user->mail];
}
