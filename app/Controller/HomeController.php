<?php

namespace Hmos9c\PhpMvc\Controller;

use Hmos9c\PhpMvc\App\View;
use Hmos9c\PhpMvc\Config\Database;
use Hmos9c\PhpMvc\Repository\SessionRepository;
use Hmos9c\PhpMvc\Repository\UserRepository;
use Hmos9c\PhpMvc\Service\SessionService;

class HomeController
{

    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }


    function index()
    {
        $user = $this->sessionService->current();
        if ($user == null) {
            View::render('Home/index', [
                "title" => "PHP Login Management"
            ]);
        } else {
            View::render('Home/dashboard', [
                "title" => "Dashboard",
                "user" => [
                    "name" => $user->name
                ]
            ]);
        }
    }

}