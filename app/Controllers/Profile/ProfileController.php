<?php

namespace Controllers\Profile;

use Controllers\AppController;
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
        return $this->display(page: "profile", args: ["title" => "Profile"]);
    }

    #[Post('/upload-avatar')]
    public function uploadAvatar(): Response
    {
        $avatar = $this->request->getBody()->getParameter("avatar");
        return $this->abortNotImplemented();
    }
}