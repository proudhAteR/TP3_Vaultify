<?php

namespace Controllers\Authentication;

use Models\Services\MfaService;
use Zephyrus\Application\Flash;
use Zephyrus\Application\Form;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Post;
use Zephyrus\Network\Router\Root;

#[Root('/mfa')]
class MfaController extends AuthenticationController
{
    #[Post('/')]
    public function index(): Response
    {
        MfaService::update(
            $this->buildForm()
        );

        return $this->go_back();
    }

    #[Post('/verify')]
    public function verify(): Response
    {
        $form = $this->buildForm();
        $valid = MfaService::verify($form);

        return $valid ? $this->connect(MfaService::get_temp(), $form) : $this->failed();
    }

    private function failed(): Response
    {
        Flash::error("The given code must be invalid. Try again.");
        return $this->go_back();
    }
}