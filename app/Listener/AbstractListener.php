<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\Listener;

use Psr\Container\ContainerInterface;

/**
 * 监听器抽象类
 *
 * AbstractListener
 *
 * @author  小琪(991010625.com)
 * @package App\Listener
 */
abstract class AbstractListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * AbstractListener constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}