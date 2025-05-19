<?php

namespace Controllers\Profile;

use Controllers\AppController;
use Models\Services\AccountService;
use Models\Services\MfaService;
use Zephyrus\Application\Flash;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Post;
use Zephyrus\Network\Router\Root;

#[Root('/profile')]
class ProfileController extends AppController
{
    #[Get('/')]
    public function index(): Response
    {
        return $this->display(page: "profile", args: ["title" => "Profile", "enabled" => MfaService::enabled()]);
    }

    #[Post('/upload-avatar')]
    public function uploadAvatar(): Response
    {
        $avatar = $this->request->getFiles()['avatar'];
        AccountService::update_avatar($avatar);

        return $this->redirectBack($this->request);
    }

    #[Post('/mfa')]
    public function update_mfa(): Response
    {
        MfaService::handle(
            $this->buildForm()
        );

        return $this->redirectBack($this->request);
    }
}