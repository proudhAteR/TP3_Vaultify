<?php

namespace Models\Services;

use Models\Brokers\AccountBroker;
use Models\Entities\Account;
use Models\Validators\LoginValidator;
use Models\Validators\RegistrationValidator;
use stdClass;
use Zephyrus\Application\Flash;
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
            $submitted,
            $account,
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

    public static function disconnect(): void
    {
        Session::remove("user");
        Session::remove("vaults");
    }

    public static function update_avatar($avatar): void
    {
        if (!self::is_valid_avatar($avatar)) {
            Flash::error("Unable to upload avatar");
            return;
        }

        $filename = self::generate_filename($avatar['name']);
        $upload_path = self::get_upload_path();


        $dest = $upload_path . "/" . $filename;

        if (!move_uploaded_file($avatar['tmp_name'], $dest)) {
            Flash::error("Failed to move uploaded file.");
            return;
        }

        self::delete_old_avatar($upload_path);
        new AccountBroker()->update_avatar($filename, self::get_user()->id);

        Flash::success("Your avatar has been updated with success!");
    }

    private static function is_valid_avatar($avatar): bool
    {
        return $avatar && $avatar['error'] === UPLOAD_ERR_OK;
    }

    private static function generate_filename(string $originalName): string
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return uniqid('avatar_', true) . "." . $extension;
    }

    private static function get_upload_path(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/assets/images/users";
    }

    private static function delete_old_avatar(string $upload_path): void
    {
        $avatar = $upload_path . "/" . self::get_user()->avatar;

        if (file_exists($avatar)) {
            unlink($avatar);
        }
    }

}