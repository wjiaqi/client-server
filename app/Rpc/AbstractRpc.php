<?php

declare (strict_types=1);
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */

namespace App\Rpc;

use App\Common\Base;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;

/**
 * AbstractRpc
 *
 * @author xiaoqi(991010625@qq.com)
 * @package App\Rpc
 */
abstract class AbstractRpc extends Base
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected ContainerInterface $container;
}