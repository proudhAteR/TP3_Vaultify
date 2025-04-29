<?php

namespace Models\Brokers;

use Models\Entities\Vault;
use Models\Services\AccountService;
use stdClass;
use Zephyrus\Database\DatabaseBroker;
use Zephyrus\Security\Cryptography;

class VaultBroker extends DatabaseBroker
{
    public function find(): array
    {
        return $this->select("SELECT * FROM vault WHERE account_id = ?", [AccountService::getUser()->id]);
    }

    public function create(Vault $vault): void
    {
        $this->query("INSERT INTO vault(account_id, name, username, password) VALUES (?, ?, ?, ?)", [
            $vault->account_id,
            $vault->name,
            $vault->username,
            Cryptography::encrypt(
                $vault->password,
            )
        ]);
    }

}