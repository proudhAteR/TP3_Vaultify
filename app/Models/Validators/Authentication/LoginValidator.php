<?php

namespace Models\Validators\Authentication;

use Models\Core\Entity;
use Models\Entities\Account;
use Models\Exceptions\FormException;
use Models\Rules\CustomRule;
use Models\Validators\BaseAccountValidator;
use Zephyrus\Application\Form;

class LoginValidator extends BaseAccountValidator
{
    public static function assert(Form $form): void
    {
        parent::assert($form);

        $form->field("username", [
            CustomRule::canFind(self::$credentials_error_message)
        ]);

        if (!$form->verify()) {
            throw new FormException($form);
        }
    }


}