<?php

declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Rpc;

use App\Common\Base;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;

/**
 * AbstractRpc
 *
 * @author 王佳其(991010625@qq.com)
 * @package App\Rpc
 */
abstract class AbstractRpc extends Base
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;
}