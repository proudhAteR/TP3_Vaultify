<?php

namespace Models\Services;

use Models\Brokers\VaultBroker;
use Models\Entities\Vault;
use Models\Validators\Vault\VaultValidator;
use stdClass;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Form;
use Zephyrus\Core\Session;

class VaultService
{
    public static function build_vault(stdClass $vault): Vault
    {
        return Vault::build($vault);
    }

    public static function create(Form $form): void
    {
        VaultValidator::assert($form);

        $vault = self::build_vault(
            $form->buildObject()
        );

        new VaultBroker()->create($vault);
        self::find();

        Flash::success(
            sprintf("%s has been created with success!", $vault->name)
        );
    }

    public static function update(Vault $vault, Form $form): void
    {
        VaultValidator::assert($form);

        $submitted = self::build_vault(
            $form->buildObject()
        );

        VaultValidator::verify(
            $submitted,
            $vault,
            $form
        );

        new VaultBroker()->update($vault, $submitted);
        self::find();

        Flash::success(
            sprintf("%s has been updated with success!", $vault->name)
        );
    }

    public static function get_vaults(): array
    {
        return self::fetch() ?? self::find();
    }

    private static function find(): array
    {
        $vaults = new VaultBroker()->find() ?? [];

        foreach ($vaults as $vault) {
            $vault->password = EncryptionService::decrypt($vault->password);
        }

        self::store($vaults);
        return $vaults;
    }

    private static function store(array $vaults): void
    {
        Session::set('vaults', $vaults);
    }

    private static function fetch(): ?array
    {
        return Session::get('vaults');
    }

    public static function delete(int $id): void
    {
        new VaultBroker()->delete($id);
        self::find();
    }
}