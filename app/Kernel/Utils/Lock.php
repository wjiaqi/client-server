<?php

declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link      https://dayiguo.com
 */

namespace App\Kernel\Utils;

use App\Common\Base;
use App\Constants\Constants;

/**
 * Lock
 *
 * @author  王佳其(991010625@qq.com)
 * @package App\Kernel\Utils
 */
class Lock extends Base
{

    /**
     * 获取锁
     *
     * @param string $key
     *
     * @return bool
     */
    public function get(string $key): bool
    {
        $isLock = $this->redis->setnx($key, 1);
        if (!$isLock) {
            if ($this->redis->ttl($key) === -1) {
                $this->redis->del($key);
                $isLock = $this->redis->setnx($key, 1);
                if ($isLock) {
                    $this->redis->expire($key, Constants::CACHE_LOCK_EXPIRE_TIME);
                }
            }
        }
        else {
            $this->redis->expire($key, Constants::CACHE_LOCK_EXPIRE_TIME);
        }
        return $isLock ? true : false;
    }

    /**
     * 删除锁
     *
     * @param string $key
     */
    public function release(string $key): void
    {
        $this->redis->del($key);
    }
}