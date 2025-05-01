<?php

namespace Models\Services;

use Models\Brokers\AccountBroker;
use Models\Entities\Account;
use Models\Validators\LoginValidator;
use Models\Validators\RegistrationValidator;
use stdClass;
use Zephyrus\Application\Form;
use Zephyrus\Core\Session;

class AccountService
{
    public static function authenticate(Form $form): ?Account
    {
        LoginValidator::assert($form);

        $submitted = self::build_account(
            $form->buildObject()
        );
        $account = self::build_account(
            new AccountBroker()->findByName(
                $submitted->username
            )
        );

        LoginValidator::verify(
            $submitted->password,
            $account->password,
            $form
        );

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

    public static function get_user(): ?Account
    {
        return self::build_user();
    }

    private static function build_user(): ?Account
    {
        $id = self::retrieve_user();

        return $id ? AccountService::build_account(
            new AccountBroker()->findById($id)
        ) : null;
    }

    public static function connect(Account $acc, Form $form): void
    {
        self::store_key(
            $form->getValue("password"),
            $acc->salt
        );
        self::store_user($acc->id);
    }

    private static function store_key(string $p, string $s): void
    {
        Session::set(
            "key",
            EncryptionService::generate_key($p, $s)
        );
    }

    private static function store_user(int $id): void
    {
        Session::set("user", $id);
    }

    private static function retrieve_user(): ?int
    {
        return Session::get("user");
    }
}