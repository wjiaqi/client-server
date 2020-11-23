<?php

declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Exception\Handler;

use App\Exception\BusinessException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * BusinessExceptionHandler
 *
 * @author 王佳其(991010625@qq.com)
 * @package App\Exception\Handler
 */
class BusinessExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $data = [
            'code' => 400,
            'message' => __($throwable->getMessage()),
            'result' => []
        ];
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);

        $this->stopPropagation();

        return $response->withStatus(200)->withBody(new SwooleStream($data))->withHeader('Content-Type', 'application/json;charset=utf-8');
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof BusinessException;
    }
}