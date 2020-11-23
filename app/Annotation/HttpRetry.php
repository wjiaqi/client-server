<?php
declare (strict_types=1);
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
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
 * @author  王佳其(991010625@qq.com)
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
    public $maxAttempts = 3;

    /**
     * 异常类列表
     *
     * @var array
     */
    public $retryThrowables = [
        HttpException::class
    ];
}