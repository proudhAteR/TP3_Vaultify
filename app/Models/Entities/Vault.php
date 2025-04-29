<?php

namespace Models\Entities;

use DateTime;
use Models\Core\Entity;

class Vault extends Entity
{
    public int $id;
    public int $account_id;
    public string $name;
    public string $username;
    public string $password;
    public DateTime $created_at;
}