<?php

namespace Models\Validators;

use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

abstract class BaseAccountValidator extends BaseValidator
{
    protected static string $credentials_error_message = "The username or password you entered may not be valid.";
    protected static string $used_error_message = "The username you entered is already been used.";

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