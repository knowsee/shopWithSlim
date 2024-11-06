<?php

declare(strict_types=1);

namespace App\Application\Actions\Common;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class MissAction extends Action
{
    protected string $title = 'Miss Page';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->view('common/404.php');
    }
}
