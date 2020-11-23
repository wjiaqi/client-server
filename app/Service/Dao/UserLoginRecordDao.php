<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\Service\Dao;


use App\Model\UserLoginRecord;

/**
 * UserLoginRecordDao
 *
 * @author  小琪(991010625.com)
 * @package App\Service\Dao
 */
class UserLoginRecordDao
{
    /**
     * 新增登录记录
     *
     * @param int $userId
     */
    public function insert(int $userId): void
    {
        UserLoginRecord::query()->create(
            [
                'user_id'   => $userId,
            ]
        );
    }
}