<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Psr\Container\ContainerInterface;
use App\Model\GoodsType as GoodsTypeModel;
use App\Model\User;
use App\Model\Cart;

abstract class Action
{
    protected LoggerInterface $logger;
    protected ContainerInterface $container;
    protected Request $request;
    protected Response $response;
    protected array $args;
    protected array $viewArgs;
    protected string $title = 'Home';
    protected int $page = 1;
    protected int $pageNum = 25;
    protected string $pageName = 'page';
    protected string $limitName = 'getNum';
    protected string $token;
    protected array $userInfo = [
        'userId' => 0
    ];
    protected string $cartId = '';

    public function __construct(LoggerInterface $logger, ContainerInterface $container)
    {
        $this->logger = $logger;
        $this->container = $container;
        $this->viewArgs = [
            'user' => [
                'userName' => '',
                'cartNum' => '',
            ]
        ];
        $this->getTypeList();
    }

    private function init()
    {
        $this->pageLimitInit();
        $cookies = $this->request->getCookieParams();
        if (isset($cookies['token']) && $cookies['token']) {
            $this->token = $cookies['token'];
            if ($this->token) {
                $checkUser = User::getUserFeild($this->token);
                if (!empty($checkUser)) {
                    $this->userInfo = User::getUserSession($this->token);
                    $this->cartId = Cart::getCart(User::getUserFeild($this->token));
                    $this->userInfo['cartNum'] = Cart::getCartGoodsNum($this->cartId);
                    $this->viewArgs['user'] = $this->userInfo;
                }
            }
        }
    }

    private function pageLimitInit()
    {
        $get = $this->request->getQueryParams();
        $page = $get[$this->pageName] ?? 1;
        if ($page < 1) {
            $page = 1;
        }
        $limit = $get[$this->limitName] ?? $this->pageNum;
        if ($limit < 1) {
            $limit = 1;
        }
        return [intval($page), intval($limit)];
    }

    public function getTypeList()
    {
        $list = GoodsTypeModel::getList(1, 100, function ($value) use (&$typeList) {
            $typeList[$value[GoodsTypeModel::TABLE_PY]] = $value[GoodsTypeModel::TABLE_TYPENAME];
            return $value;
        });
        $listbigtype = $listsmalltype = [];
        foreach ($list as $val) {
            if ($val[GoodsTypeModel::TABLE_TYPE_MAINID] > 0) {
                $listsmalltype[$val[GoodsTypeModel::TABLE_TYPE_MAINID]][] = $val;
            } else {
                $listbigtype[$val[GoodsTypeModel::TABLE_PY]] = $val[GoodsTypeModel::TABLE_TYPENAME];
            }
        }
        $this->viewArgs['type_system'] = ['stype' => $listsmalltype, 'btype' => $listbigtype];
    }

    /**
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
        $this->init();
        try {
            return $this->action();
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    /**
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    abstract protected function action(): Response;

    /**
     * @return array|object
     */
    protected function getFormData()
    {
        return $this->request->getParsedBody();
    }

    /**
     * @return mixed
     * @throws HttpBadRequestException
     */
    protected function resolveArg(string $name)
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }

    /**
     * Json 常规提示输出
     * @param array $data
     * @param string $message
     * @param int $status
     */
    public function rightWithJson(array $data = array(), string $message = 'Request Success', int $status = 200)
    {
        $payload = new ActionPayload($status, $data, null, $message);
        return $this->respond($payload);
    }

    /**
     * Json 错误提示输出
     * @param array $errorDetail
     * @param string $message
     * @param int $status
     */
    public function errorWithJson(string $message = 'Message Error', array $errorDetail = array(), int $status = 500)
    {
        $payload = new ActionPayload($status, $errorDetail, null, $message);
        return $this->respond($payload);
    }

    public function errorShow(string $message, $url = 'javascript:history.go(-1);') {
        return $this->view('ShowMsg.php', [
            'message' => $message,
            'url' => $url
        ]);
    }

    /**
     * @param array|object|null $data
     */
    protected function respondWithData($data = null, int $statusCode = 200): Response
    {
        $payload = new ActionPayload($statusCode, $data);
        return $this->respond($payload);
    }

    protected function respond(ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        $this->response->getBody()->write($json);
        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($payload->getStatusCode());
    }

    protected function view($tmpName, ?array $args = [])
    {
        $this->viewArgs['title'] = $this->title;
        $this->viewArgs['page'] = $this->page;
        $this->container->get('view')->setAttributes($this->viewArgs);
        return $this->container->get('view')->render($this->response, $tmpName, $args);
    }
}
