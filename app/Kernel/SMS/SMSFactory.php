<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\Kernel\SMS;

use Psr\Container\ContainerInterface;

/**
 * SMSFactory
 *
 * @author  小琪(991010625.com)
 * @package App\Kernel\SMS
 */
class SMSFactory
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * SMSFactory constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * 创蓝短信
     *
     * @return SMSInterface
     */
    public function getSMSCloud(): SMSInterface
    {
        return $this->container->get(ALiDaYu::class);
    }
}