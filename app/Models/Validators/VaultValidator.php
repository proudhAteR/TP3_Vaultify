<?php

namespace Models\Validators;

use Models\Core\Entity;
use Models\Entities\Account;
use Models\Entities\Vault;
use Models\Exceptions\FormException;
use Models\Services\EncryptionService;
use Zephyrus\Application\Form;
use Zephyrus\Application\Rule;

class VaultValidator extends BaseValidator
{
    public static function assert(Form $form): void
    {
        $form->field("password", [
            Rule::required(self::$required_message),
            Rule::passwordCompliant(self::$invalid_pwd_message)
        ]);

        $form->field("name", [
            Rule::required(self::$required_message)
        ]);

        $form->field("username", [
            Rule::required(self::$required_message)
        ]);

        if (!$form->verify()) {
            throw new FormException($form);
        }
    }


    public static function verify(Entity|Vault $submitted, Entity|Vault $stored, Form $form): void
    {
        if (!self::is_valid(class: Vault::class, v: $submitted) || !self::is_valid(class: Vault::class, v: $stored)) {
            $form->addError(
                '',
                "It seems to be an error, try again later. If the problem persists, contact an administrator."
            );
            throw new FormException($form);
        }

        $fieldsToCheck = [
            'name' => ['method' => 'compare', 'params' => [$submitted->name, $stored->name]],
            'username' => ['method' => 'compare', 'params' => [$submitted->username, $stored->username]],
            'password' => ['method' => 'compare', 'params' => [$submitted->password, EncryptionService::decrypt($stored->password)]]
        ];

        $changes = false;

        foreach ($fieldsToCheck as $field => $check) {
            $method = $check['method'];

            $same = self::$method(... $check['params']);

            if (!$same) {
                $changes = true;
                break;
            }
        }

        if (!$changes) {
            $form->addError('', "No changes detected. Please modify at least one field.");
            throw new FormException($form);
        }
    }

    private static function compare(string $submitted, string $stored): bool
    {
        return $submitted === $stored;
    }
}