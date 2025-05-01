<?php

namespace Models\Services;

use Models\Entities\Account;
use Zephyrus\Core\Session;
use Zephyrus\Security\Cryptography;

class EncryptionService
{
    public static function getKey()
    {
        return Session::get("key");
    }

    public static function createSalt(): string
    {
        return Cryptography::randomHex(32);
    }

    public static function deriveUserKey(Account $user): string
    {
        return Cryptography::deriveEncryptionKey($user->password, $user->salt);
    }

    public static function encrypt(string $clearText, ?string $key = null): string
    {
        $key ??= Session::get("key");
        return Cryptography::encrypt($clearText, $key);
    }

    public static function decrypt($clearText, ?string $key = null): string
    {
        $key ??= Session::get("key");
        return Cryptography::decrypt($clearText, $key) ?? self::createSalt();
    }
}