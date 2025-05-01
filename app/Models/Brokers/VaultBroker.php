<?php

namespace Models\Brokers;

use Models\Entities\Vault;
use Models\Services\AccountService;
use Models\Services\EncryptionService;
use Zephyrus\Database\DatabaseBroker;

class VaultBroker extends DatabaseBroker
{
    public function find(): array
    {
        $user = AccountService::get_user()?->id;
        return $user ? $this->select("SELECT * FROM vault WHERE account_id = ?", [$user]) : [];
    }

    public function create(Vault $vault): void
    {
        $this->query("INSERT INTO vault(account_id, name, username, password) VALUES (?, ?, ?, ?)", [
            $vault->account_id,
            $vault->name,
            $vault->username,
            EncryptionService::encrypt(
                $vault->password,
                EncryptionService::get_key()
            )
        ]);
    }

}