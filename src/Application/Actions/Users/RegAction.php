<?php

declare(strict_types=1);

namespace App\Application\Actions\Users;

use App\Application\Actions\Action;
use App\Application\Settings\SettingsInterface;
use Exception;
use App\Model\User as UserModel;
use Psr\Http\Message\ResponseInterface as Response;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;

class RegAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $post = $this->request->getParsedBody();
        if (empty($post['password'])) {
            return $this->errorWithJson('password 不可为空');
        }
        if ($post['password'] !== $post['repassword']) {
            return $this->errorWithJson('两次密码输入不正确');
        }
        if (empty($post['email'])) {
            return $this->errorWithJson('EMAIL 不可为空');
        }
        if (empty($post['mobile'])) {
            return $this->errorWithJson('mobile 不可为空');
        }
        if (empty($post['firstname'])) {
            return $this->errorWithJson('firstname 不可为空');
        }
        if (empty($post['lastname'])) {
            return $this->errorWithJson('firstname 不可为空');
        }
        $post['email'] = strtolower($post['email']);
        try {
            $userId = UserModel::regUserByWeb($post['email'], $post['password'], $post['email'], $post['mobile'], $post['postalcode'], $post['firstname'], $post['lastname']);
            $token = UserModel::loginByUserId($userId);
            $_SESSION['token'] = $token;
            $setting = $this->container->get(SettingsInterface::class)->get();
            $this->response = FigResponseCookies::set($this->response, SetCookie::create('token')
                ->withValue($token)
                ->withDomain($setting['cookies']['domain'])
                ->withPath($setting['cookies']['path'])
                ->withSecure($setting['cookies']['safe'])
                ->withExpires(time()+86400)
            );
            return $this->rightWithJson([
                'token' => $token,
                'userInfo' => UserModel::getUserSession($token)
            ]);
        } catch (Exception $e) {
            return $this->errorWithJson($e->getMessage());
        }
    }
}
