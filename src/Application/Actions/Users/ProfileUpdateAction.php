<?php

declare(strict_types=1);

namespace App\Application\Actions\Users;

use App\Application\Actions\Action;
use App\Model\User as UserModel;
use Psr\Http\Message\ResponseInterface as Response;

class ProfileUpdateAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $post = $this->request->getParsedBody();
        if (empty($post['userFirstName'])) {
            return $this->errorWithJson('Please write on your firstName');
        }
        if (empty($post['userLastName'])) {
            return $this->errorWithJson('Please write on your last Name');
        }
        if (empty($post['userAddress'])) {
            return $this->errorWithJson('Please write on your address');
        }
        if (empty($post['userPostcode'])) {
            return $this->errorWithJson('Please write on your postcode');
        }
        if (empty($post['userMobile'])) {
            return $this->errorWithJson('Please write on your mobile');
        }
        UserModel::UpdateById($this->userInfo['userId'], [
            UserModel::TABLE_FIRSTNAME => htmlspecialchars(trim($post['userFirstName'])),
            UserModel::TABLE_LASTNAME => htmlspecialchars(trim($post['userLastName'])),
            UserModel::TABLE_USER_ADDRESS => htmlspecialchars(trim($post['userAddress'])),
            UserModel::TABLE_POSTCODE => intval($post['userPostcode']),
            UserModel::TABLE_MOBILE => strip_tags(trim($post['userMobile']))
        ]);
        return $this->rightWithJson();
    }
}
