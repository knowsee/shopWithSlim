<?php

declare(strict_types=1);

use App\Application\Actions\Pay\{
    IndexAction,
    DoneAction
};
use App\Application\Actions\Index\{
    HomeAction as IndexHomeAction,
    TypesAction,
    HotListAction,
    ListAction,
    GoodsAction,
    CheckOutAction,
    LoginAction,
    RegAction,
    CartAction,
    CartAjaxAction,
    SearchAction
};
use App\Application\Actions\Users\{
    LoginAction as UsersLoginAction,
    LogoutAction as UsersLogoutAction,
    RegAction as UsersRegAction,
    OinfoAction as UsersOinfoAction,
    OrderListAction as UsersOrderListAction,
    ProfileAction as UsersProfileAction,
    ProfileUpdateAction as UsersProfileUpdateAction,
    PasswordAction as UsersPasswordAction,
    PasswordUpdateAction as UsersPasswordUpdateAction
};
use App\Application\Actions\Cart\{
    ListAction as CartListAction,
    PutAction,
    TakeAction,
    GoodsNumUpdateAction,
    GetNumAction,
    DeleteAction
};
use App\Application\Actions\Order\{
    InfoAction as OrderInfoAction,
    CreateAction as OrderCreateAction,
    PaymentAction as OrderPaymentAction,
    PaymentUpdateAction as OrderPaymentUpdateAction
};
use App\Application\Actions\Common\{
    MissAction as CommonMissAction
};
use App\Application\Middleware\Logined as LoginedMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    
    $app->get('/', IndexHomeAction::class);
    $app->group('/Index', function (Group $group) {
        $group->get('/Index', IndexHomeAction::class);
        $group->get('/Types', TypesAction::class);
        $group->get('/Goods', GoodsAction::class);
        $group->get('/Login', LoginAction::class);
        $group->get('/Reg', RegAction::class);
        $group->get('/Search', SearchAction::class);
        $group->post('/CheckOut', CheckOutAction::class)->addMiddleware(new LoginedMiddleware());
        $group->get('/HotList', HotListAction::class);
        $group->get('/List', ListAction::class);
        $group->get('/Cart', CartAction::class)->addMiddleware(new LoginedMiddleware());
        $group->get('/CartAjax', CartAjaxAction::class)->addMiddleware(new LoginedMiddleware());
    });
    $app->group('/Order', function (Group $group) {
        $group->get('/Info/{orderSn}', OrderInfoAction::class)->addMiddleware(new LoginedMiddleware());
        $group->get('/Info', OrderInfoAction::class)->addMiddleware(new LoginedMiddleware());
        $group->get('/Payment/{orderSn}', OrderPaymentAction::class)->addMiddleware(new LoginedMiddleware());
        $group->post('/Create', OrderCreateAction::class)->addMiddleware(new LoginedMiddleware());
        $group->post('/Update', OrderPaymentUpdateAction::class)->addMiddleware(new LoginedMiddleware());
    });
    $app->group('/Users', function(Group $group) {
        $group->get('/OInfo', UsersOinfoAction::class);
        $group->get('/OrderList', UsersOrderListAction::class);
        $group->get('/Profile', UsersProfileAction::class);
        $group->post('/ProfileUpdate', UsersProfileUpdateAction::class);
        $group->get('/Password', UsersPasswordAction::class);
        $group->post('/Password', UsersPasswordUpdateAction::class);
    })->addMiddleware(new LoginedMiddleware());
    $app->group('/ApiUser', function (Group $group) {
        $group->post('/Login', UsersLoginAction::class);
        $group->post('/Logout', UsersLogoutAction::class);
        $group->post('/Reg', UsersRegAction::class);
    });
    $app->group('/ApiCart', function (Group $group) {
        $group->get('/List', CartListAction::class)->addMiddleware(new LoginedMiddleware());
        $group->post('/Put', PutAction::class)->addMiddleware(new LoginedMiddleware());
        $group->post('/Take', TakeAction::class)->addMiddleware(new LoginedMiddleware());
        $group->post('/Delete', DeleteAction::class)->addMiddleware(new LoginedMiddleware());
        $group->get('/GetNum', GetNumAction::class)->addMiddleware(new LoginedMiddleware());
        $group->post('/GoodsNumUpdate', GoodsNumUpdateAction::class)->addMiddleware(new LoginedMiddleware());
    });
    $app->group('/payment', function (Group $group) {
        $group->get('/index', IndexAction::class);
        $group->get('/paypal', PayPalAction::class);
        $group->get('/done/{method}/{orderSn}', DoneAction::class);
    });
    /**
     * $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });
     */
    //$app->any('/', CommonMissAction::class);
};
