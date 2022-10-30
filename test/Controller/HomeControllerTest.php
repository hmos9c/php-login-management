<?php

namespace Hmos9c\PhpMvc\Controller;

use PHPUnit\Framework\TestCase;
use Hmos9c\PhpMvc\Config\Database;
use Hmos9c\PhpMvc\Domain\Session;
use Hmos9c\PhpMvc\Domain\User;
use Hmos9c\PhpMvc\Repository\SessionRepository;
use Hmos9c\PhpMvc\Repository\UserRepository;
use Hmos9c\PhpMvc\Service\SessionService;

class HomeControllerTest extends TestCase
{
    private HomeController $homeController;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp():void
    {
        $this->homeController = new HomeController();
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testGuest()
    {
        $this->homeController->index();

        $this->expectOutputRegex("[Login Management]");
    }

    public function testUserLogin()
    {
        $user = new User();
        $user->id = "sanas";
        $user->name = "Sanas";
        $user->password = "rahasia";
        $this->userRepository->save($user);

        $session = new Session();
        $session->id = uniqid();
        $session->userId = $user->id;
        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $this->homeController->index();

        $this->expectOutputRegex("[Hello Sanas]");
    }

}
