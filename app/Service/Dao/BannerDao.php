<?php

declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Service\Dao;

use App\Model\Banner;
use Hyperf\Cache\Annotation\Cacheable;

/**
 * BannerDao
 *
 * @author 王佳其(991010625@qq.com)
 * @package App\Service\Dao
 */
class BannerDao
{
    /**
     * 获取轮播图列表
     *
     * @Cacheable(prefix="bannerList", ttl=1800)
     *
     * @return mixed
     */
    public function getBannerLists()
    {
        $model = Banner::query();
        $model = $model->where('status', 1);
        $model = $model->orderByDesc('sort');
        $model = $model->limit(3);
        return $model->get([
            'id',
            'title',
            'pic'
        ]);
    }

    /**
     * 轮播图详情
     *
     * @Cacheable(prefix="bannerInfo", value="_#{id}", ttl=300)
     *
     * @param int $id
     * @return mixed
     */
    public function getInfo(int $id): ?Banner
    {
        $model = Banner::query();
        $model = $model->where('id', $id);
        $model = $model->where('status', 1);
        return $model->first([
            'id',
            'title',
            'content'
        ]);
    }
}