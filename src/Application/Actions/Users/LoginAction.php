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

class LoginAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $post = $this->request->getParsedBody();
        $post['username'] = strtolower($post['email']);
        if ($post['username'] && $post['password']) {
            try {
                $token = UserModel::loginUser($post['username'], $post['password']);
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
                ], '欢迎你的回来！');
            } catch (Exception $e) {
                return $this->errorWithJson($e->getMessage());
            }
        } else {
            return $this->errorWithJson('用户名与密码是必填项');
        }
    }
}
