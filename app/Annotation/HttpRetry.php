<?php
declare (strict_types=1);
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */

namespace App\Annotation;

use App\Exception\HttpException;
use Hyperf\Retry\Annotation\AbstractRetry;
use Hyperf\Retry\Policy\ClassifierRetryPolicy;
use Hyperf\Retry\Policy\MaxAttemptsRetryPolicy;

/**
 * Http重试注解
 *
 * @Annotation
 * @Target({"METHOD"})
 * @author  xiaoqi(991010625@qq.com)
 * @package App\Annotation
 */
class HttpRetry extends AbstractRetry
{
    /**
     * 重试策略
     *
     * @var array
     */
    public $policies = [
        MaxAttemptsRetryPolicy::class, // 最大尝试次数策略
        ClassifierRetryPolicy::class, // 错误分类策略
    ];

    /**
     * 最大重试次数
     *
     * @var int
     */
    public int $maxAttempts = 3;

    /**
     * 异常类列表
     *
     * @var array
     */
    public array $retryThrowables = [
        HttpException::class
    ];
}