<?php

namespace Models\Rules;

use Models\Brokers\AccountBroker;
use Zephyrus\Application\Rule;

class CustomRule extends Rule
{
    public static function canFind(string $message): Rule
    {
        return new Rule(function (string $username) {
            return new AccountBroker()->findByName($username) != null;
        }, $message);
    }


}