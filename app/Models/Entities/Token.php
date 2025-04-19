<?php

namespace Models\Entities;

use Models\Core\Entity;

class Token extends Entity
{
    public string $hash;
    public int $account_id;
    public string $created_at;
}