<?php

namespace Models\Validators;

use Models\Core\Entity;
use Models\Entities\Account;
use Models\Exceptions\FormException;
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
    protected static function compare_password(Form $form, array $fields): void
    {
        $same = $form->getValue($fields["pwd"]) === $form->getValue($fields['confirm']);

        if (!$same) {
            $form->addError('confirm_password', 'The entered passwords do not match.');
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