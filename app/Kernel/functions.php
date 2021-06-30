<?php
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */

use Hyperf\Utils\ApplicationContext;
use Psr\SimpleCache\CacheInterface;

if (!function_exists('di')) {
    /**
     * di
     *
     * @param string $id
     * @return mixed
     */
    function di(string $id)
    {
        return ApplicationContext::getContainer()->get($id);
    }
}

if (!function_exists('getConfig')) {
    /**
     * 获取配置
     *
     * @param string $name
     * @param null $default
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    function getConfig(string $name, $default = null)
    {
        try {
            $configs = di(CacheInterface::class)->get('AppConfigs');
            return $configs[$name] ?? config($name, $default);
        }
        catch (InvalidArgumentException $e)
        {
            return $default;
        }
    }

}
