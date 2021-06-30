<?php
declare (strict_types=1);
/**
 * @copyright 安巽
 * @version   1.0.0
 * @link
 */

namespace App\JsonRpc\Provider;

use App\JsonRpc\AbstractJsonRpc;
use App\JsonRpc\Contract\TestServiceInterface;
use Hyperf\RpcServer\Annotation\RpcService;

/**
 * TestService
 *
 * @RpcService(name="TestService", protocol="jsonrpc", server="jsonrpc", publishTo="consul")
 * @author  小琪(991010625.com)
 * @package App\JsonRpc\Provider
 */
class TestService extends AbstractJsonRpc implements TestServiceInterface
{
    // 检测服务
    public function check(int $id, int $num): int
    {
        return $num + $id;
    }
}