<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Model\User;
use Slim\Psr7\Response as callResponse;

class Logined implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $cookies = $request->getCookieParams();
        if (!isset($cookies['token']) || empty($cookies['token'])) {
            return $this->errorToLogin($request, $handler);
        } else {
            $checkUser = User::getUserSession($cookies['token']);
            if (empty($checkUser)) {
                return $this->errorToLogin($request, $handler);
            }
        }
        return $handler->handle($request);
    }

    private function errorToLogin(Request $request, RequestHandler $handler)
    {
        $contentType = $request->getHeaderLine('Content-Type');
        $response = new callResponse();
        if (strstr($contentType, 'application/json')) {
            $json = json_encode([
                'message' => 'Please Login',
                'code' => 403,
                'data' => null,
                'error' => null
            ], JSON_PRETTY_PRINT);
            $response->getBody()->write($json);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(403);
        } else {
            return $response->withHeader('Location', excUrl('Index/Login') . '?url=' . $request->getUri()->getPath() . '&query=' . $request->getUri()->getQuery())
                ->withStatus(302);
        }
    }
}
