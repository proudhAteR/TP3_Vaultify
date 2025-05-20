<?php

namespace Controllers\Authentication;

use Models\Entities\Account;
use Models\Services\AccountService;
use Models\Services\MfaService;
use Zephyrus\Application\Form;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Post;
use Zephyrus\Network\Router\Root;

#[Root('/login')]
class LoginController extends AuthenticationController
{
    #[Get('/')]
    public function index(): Response
    {
        return $this->display(page: 'login', args: ['title' => 'Login']);
    }

    #[Post('/')]
    public function authenticate(): Response
    {
        $form = $this->buildForm();
        $acc = AccountService::authenticate($form);

        return $this->verify($acc) ? $this->mfa($acc, $form) : $this->connect($acc, $form);
    }

    private function mfa(Account $acc, Form $form): Response
    {
        MfaService::generate_code($acc);
        return $this->display(page: 'mfa', args: ['title' => 'Mfa', 'p' => $form->getValue('password')]);
    }

    private function verify(Account $acc): bool
    {
        $lastVerified = MfaService::get_verification() ?? 0;

        if ($lastVerified <= 0) return true;

        $withinWindow = (time() - $lastVerified) < (20 * 24 * 60 * 60);
        return MfaService::enabled($acc->id) && !$withinWindow;
    }
}