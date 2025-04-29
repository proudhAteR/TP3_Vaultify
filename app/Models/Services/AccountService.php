<?php

namespace Models\Services;

use Models\Brokers\AccountBroker;
use Models\Entities\Account;
use Models\Validators\LoginValidator;
use Models\Validators\RegistrationValidator;
use stdClass;
use Zephyrus\Application\Form;

class AccountService
{
    public static function authenticate(Form $form): ?Account
    {
        LoginValidator::assert($form);

        $submitted = self::build_account($form->buildObject());
        $account = self::build_account(
            new AccountBroker()->findByName(
                $submitted->username
            )
        );

        LoginValidator::verifyCredentials($submitted->password, $account->password, $form);

        return $account;
    }

    public static function register(Form $form): ?Account
    {
        RegistrationValidator::assert($form);

        $account = self::build_account(
            $form->buildObject()
        );

        new AccountBroker()->create($account);

        return self::build_account(
            new AccountBroker()->findByName($account->username)
        );
    }

    public static function build_account(?stdClass $object): ?Account
    {
        return $object ? Account::build($object) : null;
    }

    public static function getUser(): ?Account
    {
        return isAuth() ? self::build_user() : null;
    }

    private static function build_user(): Account
    {
        return AccountService::build_account(
            new AccountBroker()->findById($_SESSION["user"])
        );
    }
}