<?php

namespace Models\Validators;

use Models\Exceptions\FormException;
use Models\Rules\CustomRule;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class AccountValidator
{
    public static function assert(Form $form): void
    {
        $required_message = "This field is required";
        $invalid_pwd_message = "Your password must be at least 8 characters " .
            "long and include at least one uppercase letter, one lowercase letter and one number.";
        $credentials_error_message = "The username or password you entered may not be valid.";

        $form->field("username", [
            Rule::required($required_message),
            CustomRule::canFind($credentials_error_message)
        ]);

        $form->field("password", [
            Rule::required($required_message),
            Rule::passwordCompliant($invalid_pwd_message),
        ]);

        if (!$form->verify()) {
            throw new FormException($form);
        }
    }
}