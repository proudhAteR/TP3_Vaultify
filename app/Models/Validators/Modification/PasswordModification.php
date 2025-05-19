<?php

namespace Models\Validators\Modification;

use Models\Validators\BaseAccountValidator;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class PasswordModification extends BaseAccountValidator
{
    public static function assert(Form $form): void
    {
        $form->field("password", [
            Rule::required(self::$required_message),
            Rule::passwordCompliant(self::$invalid_pwd_message),
        ]);

        $form->field("new_password", [
            Rule::required(self::$required_message),
            Rule::passwordCompliant(self::$invalid_pwd_message),
        ]);

        $form->field("confirm_password", [
            Rule::required(self::$required_message),
            Rule::passwordCompliant(self::$invalid_pwd_message)
        ]);

        self::compare_password($form, fields: ["pwd" => 'new_password', "confirm" => 'confirm_password']);

    }
}