<?php

declare(strict_types=1);
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */

namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;
/**
 * 验证器异常接管
 *
 * @author  xiaoqi(991010625@qq.com)
 * @package App\Model
 */
class ValidationExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        /** @var \Hyperf\Validation\ValidationException $throwable */
        $error = $throwable->validator->errors()->first();

        $data = [
            'code' => 400,
            'message' => str_replace('validation.', '', __('validation.' . $error)),
            'result' => []
        ];
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);

        $this->stopPropagation();

        return $response->withStatus(200)->withBody(new SwooleStream($data))->withHeader('Content-Type', 'application/json;charset=utf-8');
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}
