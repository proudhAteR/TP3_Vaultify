<?php

namespace Models\Services;

use Exception;
use Models\Brokers\AccountBroker;
use Models\Brokers\MfaBroker;
use Models\Entities\Account;
use Models\Entities\Mfa;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;
use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\TwoFactorAuthException;
use stdClass;
use Zephyrus\Application\Configuration;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Form;
use Zephyrus\Application\Mailer\Mailer;
use Zephyrus\Application\Mailer\MailerSmtpConfiguration;
use Zephyrus\Core\Session;

class MfaService
{
    private static ?Mailer $mailer = null;
    private static ?TwoFactorAuth $tfa = null;

    private static function getMailer(): Mailer
    {
        if (self::$mailer === null) {
            try {
                $config = new MailerSmtpConfiguration(Configuration::getMailer('smtp'));
                self::$mailer = new Mailer($config);
                self::$mailer->setFrom(
                    config('mailer', 'from_address'), config('mailer', 'from_name')
                );

            } catch (Exception $e) {
                Flash::error($e->getMessage());
            }
        }

        return self::$mailer;
    }

    private static function getTfa(): TwoFactorAuth
    {
        if (self::$tfa === null) {
            try {
                self::$tfa = new TwoFactorAuth(new BaconQrCodeProvider());
            } catch (TwoFactorAuthException $e) {
                Flash::error($e->getMessage());
            }
        }

        return self::$tfa;
    }

    public static function update(Form $form): void
    {
        $mfa = self::build_Mfa(
            $form->buildObject()
        );
        self::sanitize($mfa);

        new MfaBroker()->update($mfa, AccountService::get_user()->id);
        Flash::success("MFA updated successfully.");
    }

    public static function build_Mfa(stdClass $obj): Mfa
    {
        return Mfa::build($obj);
    }

    public static function enabled(int $id): bool
    {
        $mfa = Mfa::build(
            new MfaBroker()->find($id)
        );

        return $mfa->enabled;
    }

    private static function sanitize(Mfa $mfa): void
    {
        $mfa->enabled = filter_var($mfa->enabled ?? false, FILTER_VALIDATE_BOOLEAN);
    }


    public static function verify(Form $form): bool
    {
        $code = $form->getValue("code");
        $v = self::getTfa()->verifyCode(self::get_secret(), $code);

        if ($v === true) {
            self::store_verification();
        }

        return $v;
    }


    public static function generate_code(Account $account): void
    {
        $secret = self::getTfa()->createSecret();

        self::send($account, $secret);

        self::store_secret($secret);
        self::store_temp($account);
    }

    private static function send(Account $account, string $secret): void
    {
        $code = self::getTfa()->getCode($secret);
        $body = "
                <p>Hello,</p>
                <p>Your 2FA secret key is: <strong>$code</strong></p>
                <p>– The Vaultify Team</p>
            ";
        try {
            self::getMailer()->addRecipient($account->mail);
            self::getMailer()->setSubject("Vaultify 2FA Secret");
            self::getMailer()->setBody($body, $body);

            self::getMailer()->send();

        } catch (Exception $e) {
            Flash::error($e->getMessage());
        }
    }

    private static function store_secret(string $secret): void
    {
        Session::set("secret", $secret);
    }

    private static function get_secret(): ?string
    {
        return Session::get("secret");
    }

    private static function store_temp(Account $account): void
    {
        Session::set("temp", $account);
    }

    public static function get_temp(): Account
    {
        return Session::get("temp");
    }

    public static function delete_temp(): void
    {
        Session::remove("temp");
    }

    private static function store_verification(): void
    {
        Session::set("verified_at", time());
    }

    public static function get_verification(): ?int
    {
        return Session::get("verified_at");
    }
}