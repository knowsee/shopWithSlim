<?php

declare(strict_types=1);

namespace App\Application\Actions\Users;

use App\Application\Actions\Action;
use App\Model\User as UserModel;
use Psr\Http\Message\ResponseInterface as Response;

class PasswordUpdateAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $post = $this->request->getParsedBody();
        $post['password'] = strip_tags($post['password']);
        if (empty($post['password'])) {
            return $this->errorWithJson('Please write on your password');
        }
        if (empty($post['repassword'])) {
            return $this->errorWithJson('Your secound password is not the same');
        }
        if (UserModel::checkPassword($post['password']) == false) {
            return $this->errorWithJson('Your password is too easy');
        }
        UserModel::UpdateById($this->userInfo['userId'], [
            UserModel::TABLE_PASSWORD => password_hash($post['password'], PASSWORD_DEFAULT)
        ]);
        return $this->rightWithJson();
    }
}
