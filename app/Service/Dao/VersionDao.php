<?php

declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Service\Dao;

use App\Model\Version;
use Hyperf\Cache\Annotation\Cacheable;

/**
 * VersionDao
 *
 * @author 王佳其(991010625@qq.com)
 * @package App\Service\Dao
 */
class VersionDao
{
    /**
     * 获取当前版本
     *
     *
     * @param int $channel
     * @param int $market
     * @param int $number
     * @return mixed
     */
    public function get(int $channel, int $market, int $number): ?Version
    {
        $model = Version::query();

        $model = $model->where('app_market', $market);
        $model = $model->where('package_channel', $channel);
        $model = $model->where('status', 1);
        $model = $model->where('number', '>', $number);

        return $model->first(['version_number', 'number', 'type', 'release_time', 'update_content', 'download_url', 'is_approve']);
    }
}