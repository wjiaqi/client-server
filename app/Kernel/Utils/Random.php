<?php
declare (strict_types=1);
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Kernel\Utils;

use Hyperf\Snowflake\IdGenerator\SnowflakeIdGenerator;

/**
 * 随机码生成
 *
 * @author  王佳其(991010625@qq.com)
 * @package App\Kernel\Utils
 */
class Random
{
    /**
     * 生成六位随机码
     *
     * @return string
     */
    public static function generatorCode6(): string
    {
        mt_srand();

        return (string)mt_rand(100000,999999);
    }

    /**
     * 生成两位随机码
     *
     * @return string
     */
    public static function generatorCode2(): string
    {
        mt_srand();

        return (string)mt_rand(1, 99);
    }

    /**
     * 生成雪花id
     *
     * @return int
     */
    public static function generatorSnowFlakeId():int
    {
        return di(SnowflakeIdGenerator::class)->generate();
    }
}