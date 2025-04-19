<?php

namespace Models\Brokers;

use Models\Entities\Account;
use stdClass;
use Zephyrus\Database\DatabaseBroker;

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

}