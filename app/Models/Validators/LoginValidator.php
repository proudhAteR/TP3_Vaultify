<?php

namespace Models\Validators;

use Models\Exceptions\FormException;
use Models\Rules\CustomRule;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;
use Zephyrus\Security\Cryptography;

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

    public static function verify(string $submitted, string $stored, Form $form): void
    {
        if (!self::verify_cred($submitted, $stored)) {
            $form->addError('', self::$credentials_error_message);
            throw new FormException($form);
        }
    }

    private static function verify_cred(string $clear, string $hash): bool
    {
        return Cryptography::verifyHashedPassword($clear, $hash);
    }
}