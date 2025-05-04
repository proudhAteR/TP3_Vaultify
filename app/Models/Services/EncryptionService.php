<?php

namespace Models\Services;

use Zephyrus\Core\Session;
use Zephyrus\Security\Cryptography;

class EncryptionService
{
    public static function get_key() : ?string
    {
        return Session::get("key") ?? Cryptography::getEncryptionDefaultKey();
    }

    public static function generate_salt(): string
    {
        return Cryptography::randomHex(32);
    }

    public static function generate_key(string $password, string $salt): string
    {
        return Cryptography::deriveEncryptionKey($password, $salt);
    }

    public static function encrypt(string $clearText, ?string $key = null): string
    {
        $key ??= self::get_key();
        return Cryptography::encrypt($clearText, $key);
    }

    public static function decrypt(string $clearText, ?string $key = null): string
    {
        $key ??= self::get_key();
        return Cryptography::decrypt($clearText, $key) ?? "U cannot decrypt this u silly banana :3";
    }
}