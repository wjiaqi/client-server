<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\Service\Dao;

use App\Common\Base;
use App\Model\User;
use Hyperf\Cache\Annotation\Cacheable;

/**
 * RoleDao
 *
 * @author  小琪(991010625.com)
 * @package App\Service\Dao
 */
class UserDao extends Base
{
    /**
     * 根据ID获取用户
     *
     * @Cacheable(prefix="user", ttl=5, listener="UserUpdate")
     * @param int $id
     * @return mixed
     */
    public function first(int $id): ?User
    {
        return User::query()->find($id, [
            'id',
            'mobile',
            'nickname',
            'avatar',
            'email',
            'status',
            'birthday',
            'sex'
        ]);
    }

    /**
     * 通过手机号码获取用户
     *
     * @Cacheable(prefix="userMobile", ttl=30)
     *
     * @param string $mobile
     * @return mixed
     */
    public function findUserByMobile(string $mobile): ?User
    {
        return User::query()->where('mobile', $mobile)->first([
            'id',
            'mobile',
            'nickname',
            'avatar',
            'email',
            'status',
            'password',
            'birthday',
            'sex'
        ]);
    }

    /**
     * 通过验证码直接登录(用户不存在自动创建)
     *
     * @Cacheable(prefix="userMobile", ttl=30)
     *
     * @param string $mobile
     *
     * @return mixed
     */
    public function findOrCreateUserByMobile(string $mobile): ?User
    {
        return User::query()->firstOrCreate([
            'mobile' => $mobile
        ],[
            'status' => 1,
        ]);
    }

    /**
     * 更新用户基本信息
     *
     * @param int $id
     * @param array $params
     */
    public function update(int $id, array $params): void
    {
        $model = User::query();
        $model = $model->where('id', $id);

        if ($model->update($params)) {
            $this->flushCache('UserUpdate', [$id]);
        }
    }
}