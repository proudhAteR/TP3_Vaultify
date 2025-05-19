<?php

namespace Models\Brokers;

use Models\Entities\Mfa;
use stdClass;
use Zephyrus\Database\DatabaseBroker;

class MfaBroker extends DatabaseBroker
{
    public function find(int $accountId): ?stdClass
    {
        return $this->selectSingle("SELECT * FROM mfa WHERE account_id = ?", [$accountId]);
    }

    public function update(Mfa $mfa, int $accountId): void
    {
        $this->query("UPDATE mfa SET enabled  =  ? WHERE account_id = ?", [$mfa->enabled, $accountId]);
    }
}