<?php

declare(strict_types=1);
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */

namespace App\Middleware;

use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
/**
 * 跨域中间件
 *
 * @author  xiaoqi(991010625@qq.com)
 * @package App\Model
 */
class CorsMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = Context::get(ResponseInterface::class);
        $response = $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Max-Age', 86400)
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Headers', 'Referer,Accept,DNT,Keep-Alive,User-Agent,Cache-Control,Content-Type,Authorization,Locale,Sec-Fetch-Dest');

        Context::set(ResponseInterface::class, $response);

        if ($request->getMethod() == 'OPTIONS') {
            return $response->withStatus(204);
        }

        return $handler->handle($request);
    }
}
