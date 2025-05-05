<?php

namespace Models\Services;

use Models\Brokers\VaultBroker;
use Models\Entities\Vault;
use Models\Validators\VaultValidator;
use stdClass;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Form;

class VaultService
{
    public static function build_vault(stdClass $vault): Vault
    {
        return Vault::build($vault);
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
        Flash::success(
            sprintf("%s has been updated with success!", $vault->name)
        );
    }
}