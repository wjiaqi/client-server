<?php

declare (strict_types=1);
/**
 * @copyright 安巽
 * @version   1.0.0
 * @link      https://www.secxun.com
 */

namespace App\Common;

use App\Exception\ResponseException;

use GuzzleHttp\Client;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;
use Hyperf\Cache\Listener\DeleteListenerEvent;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Filesystem\FilesystemFactory;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Redis\Redis;
use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\Context;
use League\Flysystem\Filesystem;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * 基类
 *
 * @author  xiaoqi(991010625@qq.com)
 * @package App\Common
 */
abstract class Base
{

    /**
     * @Inject
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    protected EventDispatcherInterface $eventDispatcher;

    /**
     * @Inject()
     * @var CacheInterface
     */
    protected CacheInterface $cache;

    /**
     * @Inject()
     * @var Redis
     */
    protected Redis $redis;

    /**
     * 错误响应
     *
     * @param string $message
     * @param int    $code
     *
     * @throws ResponseException
     */
    protected function error(string $message, int $code = 400): void
    {
        throw new ResponseException($message, $code);
    }

    /**
     * 成功响应
     *
     * @param array $data
     *
     * @throws ResponseException
     */
    protected function success(array $data = []): void
    {
        Context::set('successful_data', $data);

        throw new ResponseException('success', 200);
    }

    /**
     * Guzzle客户端
     *
     * @return Client
     */
    protected function guzzle(): Client
    {
        return $this->container->get(ClientFactory::class)->create();
    }

    /**
     * 消息队列投递
     *
     * @param string $channel
     * @return DriverInterface
     */
    protected function asyncQueue(string $channel = 'default'): DriverInterface
    {
        return $this->container->get(DriverFactory::class)->get($channel);
    }

    /**
     * 文件上传
     *
     * @param string $driver
     * @return Filesystem
     */
    protected function upload(string $driver = 'oss'): Filesystem
    {
        return $this->container->get(FilesystemFactory::class)->get($driver);
    }

    /**
     * 日志管理
     *
     * @param string $name
     * @param string $channel
     *
     * @return LoggerInterface
     */
    protected function logger(string $channel, string $name = 'log'): LoggerInterface
    {
        return $this->container->get(LoggerFactory::class)->get($name, $channel);
    }

    /**
     * 清理缓存
     *
     * @param string $listener
     * @param array  $args
     */
    protected function flushCache(string $listener, array $args): void
    {
        $this->eventDispatcher->dispatch(new DeleteListenerEvent($listener, $args));
    }
}