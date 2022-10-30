<?php

namespace Hmos9c\PhpMvc\Middleware;

use Hmos9c\PhpMvc\App\View;
use Hmos9c\PhpMvc\Config\Database;
use Hmos9c\PhpMvc\Repository\SessionRepository;
use Hmos9c\PhpMvc\Repository\UserRepository;
use Hmos9c\PhpMvc\Service\SessionService;

class MustLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        if ($user == null) {
            View::redirect('/users/login');
        }
    }
}