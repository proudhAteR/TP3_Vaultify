<?php

namespace Models\Services;

use Models\Brokers\AccountBroker;
use Models\Entities\Account;
use Models\Exceptions\FormException;
use Models\Validators\AccountValidator;
use stdClass;
use Zephyrus\Application\Form;

class AccountService
{
    public static function authenticate(Form $form): ?Account
    {
        AccountValidator::assert($form);

        $submitted = self::build_account($form->buildObject());
        $account = self::build_account(
            new AccountBroker()->findByName(
                $submitted->username
            )
        );

        if (!verify(
            $submitted->password,
            $account->password
        )) self::handle_error($form);

        return $account;
    }

    public static function build_account(?stdClass $object): ?Account
    {
        return $object ? Account::build($object) : null;
    }

    private static function handle_error(Form $f)
    {
        $f->addError('not good', 'The username or password you entered may not be valid.');
        throw new FormException($f);
    }
}