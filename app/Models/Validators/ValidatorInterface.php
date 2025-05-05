<?php
namespace Models\Validators;

use Zephyrus\Application\Form;
use Models\Core\Entity;

interface ValidatorInterface
{
    public static function assert(Form $form): void;
    public static function verify(Entity $submitted, Entity $stored, Form $form): void;
}