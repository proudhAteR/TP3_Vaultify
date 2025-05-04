<?php

namespace Models\Services;

use Models\Brokers\VaultBroker;
use Models\Entities\Vault;
use stdClass;
use Zephyrus\Application\Form;

class VaultService
{
    public static function build_vault(stdClass $vault): Vault
    {
        return Vault::build($vault);
    }

    public static function update(Vault $vault, Form $form): void
    {
        //TODO: ASSERT
        $submitted = self::build_vault(
            $form->buildObject()
        );

        new VaultBroker()->update($vault, $submitted);
    }
}