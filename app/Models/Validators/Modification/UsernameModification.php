<?php

namespace Models\Validators\Modification;

use Models\Rules\CustomRule;
use Models\Validators\BaseAccountValidator;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class UsernameModification extends BaseAccountValidator
{
    public static function assert(Form $form): void
    {
        $form->field("username", [
            Rule::required(self::$required_message),
            CustomRule::notUsed(self::$used_error_message)
        ]);

    }
}