<?php

namespace Models\Entities;

use Models\Core\Entity;

class Person extends Entity
{
    public int $id;
    public string $firstname;
    public string $lastname;
}