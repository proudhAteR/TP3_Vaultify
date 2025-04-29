<?php

namespace Models\Validators;

use Models\Exceptions\FormException;
use Models\Rules\CustomRule;
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

        self::compare_password($form);

        if (!$form->verify()) {
            throw new FormException($form);
        }
    }

    private static function compare_password(Form $form): void
    {
        $same  = $form->getValue("confirm_password") === $form->getValue("password");

        if (!$same) {
            $form->addError('not good', 'The entered passwords do not match.');
            throw new FormException($form);
        }
    }
}