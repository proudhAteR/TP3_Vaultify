<?php

namespace Models\Entities;

use Models\Core\Entity;

class MFA extends Entity
{
    public int $id;
    public int $account_id;
    public string $type;
    public string $value;
}