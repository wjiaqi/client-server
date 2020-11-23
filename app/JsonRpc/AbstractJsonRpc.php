<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\JsonRpc;

use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;

/**
 * AbstractJsonRpc
 *
 * @author  小琪(991010625.com)
 * @package App\JsonRpc
 */
abstract class AbstractJsonRpc
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * 成功响应
     *
     * @param array $data
     * @return array
     */
    protected function success(array $data = []): array
    {
        return [
            'code'    => 200,
            'message' => 'success',
            'data'    => $data
        ];
    }

    /**
     * 成功响应
     *
     * @param string $message
     * @param int $code
     * @return array
     */
    protected function error(string $message, int $code = 400): array
    {
        return [
            'code'    => $code,
            'message' => $message
        ];
    }
}