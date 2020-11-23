<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Constants\Constants;
use App\Exception\ResponseException;
use App\Kernel\Utils\JwtInstance;

use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $dispatched = $request->getAttribute(\Hyperf\HttpServer\Router\Dispatched::class);
        // 跳过资源白名单
        if (in_array($dispatched->handler->route, Constants::RESOURCE_WHITE_LIST)) {
            return $handler->handle($request);
        }
        // 获取token
        $token = $request->getHeaderLine(Constants::AUTHORIZATION);
        $channel = $request->getHeaderLine(Constants::CHANNEL_CODE);

        if (empty($token)) {
            throw new ResponseException('logic.NEED_LOGIN', 401);
        }

        $user = JwtInstance::instance()->decode($token)->getUser();

        // 判断用户状态
        if ($user->id > 0 && $user->status !== 1) {
            throw new ResponseException('logic.USER_STATUS_UNUSUAL', 401);
        }

        Context::set('channelCode', $channel);

        return $handler->handle($request);
    }
}