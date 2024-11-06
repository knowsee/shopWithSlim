<?php

declare(strict_types=1);

namespace App\Application\Actions\Index;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class RegAction extends Action
{
    protected string $title = 'Reg';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        return $this->view('Reg.php');
    }
}
