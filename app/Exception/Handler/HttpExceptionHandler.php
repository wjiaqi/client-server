<?php

declare (strict_types=1);
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */

namespace App\Exception\Handler;

use App\Exception\HttpException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * HttpExceptionHandler
 *
 * @author xiaoqi(991010625@qq.com)
 * @package App\Exception\Handler
 */
class HttpExceptionHandler extends ExceptionHandler
{

    /**
     * @inheritDoc
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // TODO: Implement handle() method.
        $data = [
            'code' => 400,
            'result' => []
        ];
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);

        $this->stopPropagation();

        return $response->withStatus(200)->withBody(new SwooleStream($data))->withHeader('Content-Type', 'application/json;charset=utf-8');
    }

    /**
     * @inheritDoc
     */
    public function isValid(Throwable $throwable): bool
    {
        // TODO: Implement isValid() method.
        return $throwable instanceof HttpException;
    }
}