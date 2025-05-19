<?php

namespace Models\Validators\Authentication;

use Models\Core\Entity;
use Models\Exceptions\FormException;
use Models\Rules\CustomRule;
use Models\Validators\BaseAccountValidator;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class RegistrationValidator extends BaseAccountValidator
{
    public static function assert(Form $form): void
    {
        parent::assert($form);

        $form->field("username", [
            CustomRule::notUsed(self::$used_error_message)
        ]);

        $form->field("mail", [
            Rule::required(self::$required_message),
        ]);

        $form->field("confirm_password", [
            Rule::required(self::$required_message),
            Rule::passwordCompliant(self::$invalid_pwd_message),
        ]);

        self::compare_password($form, fields: ["pwd" => 'password', "confirm" => 'confirm_password']);

        if (!$form->verify()) {
            throw new FormException($form);
        }
    }
}