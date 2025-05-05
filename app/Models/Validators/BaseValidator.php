<?php

namespace Models\Validators;

use Zephyrus\Security\Cryptography;

abstract class BaseValidator implements ValidatorInterface
{
    protected static string $required_message = "This field is required";
    protected static string $invalid_pwd_message = "Your password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter and one number.";

    protected static function verify_cred(string $clear, string $hash): bool
    {
        return Cryptography::verifyHashedPassword($clear, $hash);
    }

    protected static function is_valid(string $class, mixed $v): bool
    {
        return $v instanceof $class;
    }

}