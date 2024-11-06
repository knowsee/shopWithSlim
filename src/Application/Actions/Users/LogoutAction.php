<?php

declare(strict_types=1);

namespace App\Application\Actions\Users;

use App\Application\Actions\Action;
use App\Model\User as UserModel;
use Psr\Http\Message\ResponseInterface as Response;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;

class LogoutAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        unset($_SESSION['token']);
        UserModel::removeUsersession($this->token);
        $this->response = FigResponseCookies::remove(
            $this->response,
            'token'
        );
        return $this->rightWithJson([
            'result' => true
        ]);
    }
}
