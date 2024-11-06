<?php

declare(strict_types=1);

namespace App\Application\Actions\Users;

use App\Application\Actions\Action;
use App\Model\User as UserModel;
use Psr\Http\Message\ResponseInterface as Response;

class ProfileAction extends Action
{
    protected string $title = 'Profile';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->view('Users/Profile.php', [
            'users' => UserModel::getById($this->userInfo['userId'])
        ]);
    }
}
