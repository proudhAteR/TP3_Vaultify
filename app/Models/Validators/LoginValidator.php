<?php

namespace Models\Validators;

use Models\Exceptions\FormException;
use Models\Rules\CustomRule;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class LoginValidator extends BaseAccountValidator
{
    public static function assert(Form $form): void
    {
        parent::assert($form);

        $form->field("username", [
            CustomRule::canFind(self::$credentials_error_message)
        ]);

        if (!$form->verify()) {
            throw new FormException($form);
        }
    }

    public static function verifyCredentials(string $submitted, string $stored, Form $form): void
    {
        if (!verify($submitted, $stored)) {
            $form->addError('not good', self::$credentials_error_message);
            throw new FormException($form);
        }
    }
}