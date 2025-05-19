<?php
namespace Models\Validators;

use Zephyrus\Application\Form;

interface ValidatorInterface
{
    public static function assert(Form $form): void;
}