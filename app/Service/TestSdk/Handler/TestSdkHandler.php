<?php
declare (strict_types=1);
/**
 * @copyright 安巽
 * @version   1.0.0
 * @link
 */

namespace App\Service\TestSdk\Handler;

use App\Service\Payment\Request\MPurseRequest;
use App\Service\TestSdk\Request\TestSdkRequest;
use App\Service\TestSdk\TestSdkInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;

/**
 * TestSdkHandler
 *
 * @author  小琪(991010625.com)
 * @package App\Service\TestSdk\Handler
 */
class TestSdkHandler implements TestSdkInterface
{
    /**
     * @Inject()
     * @var TestSdkRequest
     */
    private $request;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     *  constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}