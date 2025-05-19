<?php

namespace Models\Services;

use Models\Brokers\MfaBroker;
use Models\Entities\Mfa;
use stdClass;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Form;

class MfaService
{
    public static function handle(Form $form): void
    {
        $mfa = self::build_Mfa(
            $form->buildObject()
        );

        $mfa->enabled = filter_var($mfa->enabled ?? false, FILTER_VALIDATE_BOOLEAN);

        new MfaBroker()->update($mfa, AccountService::get_user()->id);
        Flash::success("MFA updated successfully");
    }

    public static function build_Mfa(stdClass $obj): Mfa
    {
        return Mfa::build($obj);
    }

    public static function enabled(): bool
    {
        $mfa = Mfa::build(
            new MfaBroker()->find(AccountService::get_user()->id)
        );

        return $mfa->enabled;
    }
}