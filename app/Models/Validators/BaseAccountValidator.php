<?php

namespace Models\Validators;

use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

abstract class BaseAccountValidator implements ValidatorInterface
{
    protected static string $required_message = "This field is required";
    protected static string $invalid_pwd_message = "Your password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter and one number.";
    protected static string $credentials_error_message = "The username or password you entered may not be valid.";
    protected static string $used_error_message = "The username or is already been used.";

    public static function assert(Form $form): void
    {
        $form->field("username", [
            Rule::required(self::$required_message),
        ]);

        $form->field("password", [
            Rule::required(self::$required_message),
            Rule::passwordCompliant(self::$invalid_pwd_message),
        ]);
    }
}