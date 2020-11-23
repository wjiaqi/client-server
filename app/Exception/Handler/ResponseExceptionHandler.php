<?php

declare(strict_types=1);
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Exception\Handler;

use App\Exception\ResponseException;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Context;

use Psr\Http\Message\ResponseInterface;

use Throwable;
/**
 * 逻辑异常接管
 *
 * @author  王佳其(991010625@qq.com)
 * @package App\Model
 */
class ResponseExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $data = [
            'code' => $throwable->getCode(),
            'message' => __($throwable->getMessage()),
            'result' => Context::get('successful_data') // 从协程上下文获取返回数据
        ];
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);

        $this->stopPropagation();

        // 释放协程上下文
        Context::destroy('successful_data');

        $response = $response->withStatus(200)
            ->withBody(new SwooleStream($data))
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withHeader('Server', 'xiaoqi')
            ->withHeader('Author', 'xiaoqi')
            ->withHeader('Email', '99101025@qq.com')
            ->withHeader('Wechat', 'wjq72394')
            ->withHeader('Phone', '+8613750249057');

        // 交换token
        if (Context::has('ExchangeToken')) {
            $response = $response->withHeader('ExchangeToken', Context::get('ExchangeToken'));
        }

        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ResponseException;
    }
}
