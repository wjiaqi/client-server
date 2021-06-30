<?php
declare (strict_types=1);
/**
 * @copyright 安巽
 * @version   1.0.0
 * @link
 */

namespace App\Service\TestSdk\Request;

use Psr\Container\ContainerInterface;

/**
 * TestSdkRequest
 *
 * @author  小琪(991010625.com)
 * @package App\Service\TestSdk\Request
 */
class TestSdkRequest
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $partnerId;

    /**
     * @var ContainerInterface
     */
    private $container;

}