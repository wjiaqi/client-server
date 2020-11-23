<?php

declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Exception\Handler;

use App\Exception\LogicException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * LogicExceptionHandler
 *
 * @author 王佳其(991010625@qq.com)
 * @package App\Exception\Handler
 */
class LogicExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // TODO: Implement handle() method.

    }

    public function isValid(Throwable $throwable): bool
    {
        // TODO: Implement isValid() method.
        return $throwable instanceof LogicException;
    }
}