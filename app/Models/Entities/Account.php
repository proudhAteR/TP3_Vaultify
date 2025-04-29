<?php

namespace Models\Entities;

use Models\Core\Entity;

class Account extends Entity
{
    public int $id;
    public string $username;
    public string $password;
    public string $mail;
}