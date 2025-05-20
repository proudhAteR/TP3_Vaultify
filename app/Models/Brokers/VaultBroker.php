<?php

namespace Models\Brokers;

use Models\Entities\Account;
use Models\Entities\Vault;
use Models\Services\AccountService;
use Models\Services\EncryptionService;
use stdClass;
use Zephyrus\Database\DatabaseBroker;

class VaultBroker extends DatabaseBroker
{
    private ?Account $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = AccountService::get_user();
    }

    public function find(): array
    {
        return $this->user ? $this->select("SELECT * FROM vault WHERE account_id = ?", [$this->user->id]) : [];
    }

    public function create(Vault $vault): void
    {
        $this->query("INSERT INTO vault(account_id, name, username, password) VALUES (?, ?, ?, ?)", [
            $this->user->id,
            $vault->name,
            $vault->username,
            EncryptionService::encrypt($vault->password)
        ]);
    }

    public function find_by_id(int $id): ?StdClass
    {
        return $this->selectSingle("SELECT * FROM vault WHERE account_id = ? AND id = ?", [$this->user->id, $id]);
    }

    public function update(Vault $vault, Vault $submitted): void
    {
        $this->query("UPDATE vault SET name=?, username=?, password=?, date=? WHERE id=?", [
            $submitted->name,
            $submitted->username,
            EncryptionService::encrypt($submitted->password),
            date('Y-m-d'),
            $vault->id
        ]);
    }

    public function delete(int $id): void
    {
        $this->query("DELETE FROM vault WHERE account_id = ? AND id = ?", [$this->user->id, $id]);
    }
}