<?php

use Random\RandomException;
use Zephyrus\Security\Cryptography;

function login(string $title) : bool {
    return strcasecmp($title, 'Login') === 0;
}

function generate_token(): string
{
    try {
        return bin2hex(random_bytes(32));
    } catch (RandomException) {
        return hash('sha256', uniqid(mt_rand(), true));
    }
}

function decode_json(string $data): mixed
{
    $decoded = json_decode($data, true);
    return json_last_error() === JSON_ERROR_NONE ? $decoded : $data;
}

function verify(string $clear, string $hash): bool
{
    return Cryptography::verifyHashedPassword($clear, $hash);
}