<?php

declare(strict_types=1);

namespace App\Application\Actions\Index;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends Action
{
    protected string $title = 'Login';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $get = $this->request->getQueryParams();
        if (!empty($get['query'])) {
            $get['url'] = $get['url'] . '?' . $get['query'];
        }
        return $this->view('Login.php', [
            'url' => $get['url'] ?? ''
        ]);
    }
}
