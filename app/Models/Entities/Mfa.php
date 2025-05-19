<?php

namespace Models\Entities;

use Models\Core\Entity;

class Mfa extends Entity
{
    public int $account_id;
    public bool $enabled;
}