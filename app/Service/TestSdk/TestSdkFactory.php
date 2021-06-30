<?php
declare (strict_types=1);
/**
 * @copyright 安巽
 * @version   1.0.0
 * @link
 */

namespace App\Service\TestSdk;

use App\Service\TestSdk\Exception\InvalidTestException;
use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;

/**
 * TestSdkFactory
 *
 * @author  小琪(991010625.com)
 * @package App\Service\TestSdk
 */
class TestSdkFactory
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * RiskFactory constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->config = $container->get(ConfigInterface::class);
    }

    /**
     * @return TestSdkInterface
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getPayment(): TestSdkInterface
    {
        $code = getConfig('payment', 'razorpay');

        $config = $this->config->get('payment');

        if (!isset($config[$code])) {
            throw new InvalidTestException(sprintf('Payment config[%s] is not defined.', $code));
        }

        return $this->container->get($config[$code]['handler']);
    }
}