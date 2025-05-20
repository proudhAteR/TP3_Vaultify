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
        $user =  AccountService::get_user();
        $enabled = $user != null && MfaService::enabled($user->id);
        return $this->display(
            page: "profile",
            args: ["title" => "Profile", "enabled" => $enabled]
        );
    }

    #[Post('/upload-avatar')]
    public function upload_avatar(): Response
    {
        $avatar = $this->request->getFiles()['avatar'];
        AccountService::update_avatar($avatar);

        return $this->go_back();
    }

    #[Post('/update_username')]
    public function update(): Response
    {
        AccountService::update_username(
            $this->buildForm()
        );

        return $this->go_back();
    }

    #[Post('/update_password')]
    public function update_password(): Response
    {
        AccountService::update_password(
            $this->buildForm()
        );

        return $this->go_back();
    }
}