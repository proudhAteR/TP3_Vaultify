<?php

namespace Models\Brokers;

use Models\Entities\Account;
use Models\Services\AccountService;
use Models\Services\EncryptionService;
use stdClass;
use Zephyrus\Database\DatabaseBroker;
use Zephyrus\Security\Cryptography;

class AccountBroker extends DatabaseBroker
{
    public function findById(int $accountId): ?stdClass
    {
        return $this->selectSingle("SELECT * FROM account WHERE id = ?", [$accountId]);
    }

    public function findByName(string $username): ?stdClass
    {

        return $this->selectSingle("SELECT * FROM account WHERE username = ?", [$username]);
    }

    public function update(Account $old, Account $new): void
    {
        $this->query("UPDATE account SET username = ?, mail = ?  WHERE id = ?", [
            $new->username,
            $new->mail,
            $old->id
        ]);
    }

    public function create(Account $account): void
    {
        $this->query("INSERT INTO account (username, mail, salt, password) VALUES (?, ?, ?, ?)", [
            $account->username,
            $account->mail,
            EncryptionService::generate_salt(),
            Cryptography::hashPassword(
                $account->password
            )
        ]);
    }

    public function update_avatar(string $new, int $id): void
    {
        $this->query("UPDATE account SET avatar = ? WHERE id = ?", [$new, $id]);
    }

}