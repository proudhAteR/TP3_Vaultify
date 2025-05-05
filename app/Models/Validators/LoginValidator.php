<?php

namespace Models\Validators;

use Models\Core\Entity;
use Models\Entities\Account;
use Models\Exceptions\FormException;
use Models\Rules\CustomRule;
use Zephyrus\Application\Form;

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

    public static function verify(Account|Entity $submitted, Account|Entity $stored, Form $form): void
    {
        if (!self::is_valid(class: Account::class, v: $submitted) || !self::is_valid(class: Account::class, v: $stored)) {
            return;
        }

        if (!self::verify_cred($submitted->password, $stored->password)) {
            $form->addError('', self::$credentials_error_message);
            throw new FormException($form);
        }
    }


}