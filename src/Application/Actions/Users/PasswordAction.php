<?php

declare(strict_types=1);

namespace App\Application\Actions\Users;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class PasswordAction extends Action
{
    protected string $title = 'Password';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->view('Users/Password.php');
    }
}
