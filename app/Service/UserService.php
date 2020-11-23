<?php

declare (strict_types=1);
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Service;

use App\Common\Base;
use App\Kernel\Captcha\SMSCaptcha;
use App\Kernel\Utils\JwtInstance;
use App\Model\User;
use App\Service\Dao\UserDao;

use App\Service\Dao\UserLoginRecordDao;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;

/**
 * 用户服务
 *
 * @author  王佳其(991010625@qq.com)
 * @package App\Service
 */
class UserService extends Base
{
    /**
     * 用户DAO
     *
     * @Inject()
     * @var UserDao
     */
    public $userDao;

    /**
     * 通过密码登陆
     *
     * @param string $mobile
     * @param string $password
     * @return User|mixed|null
     */
    public function loginByPassword(string $mobile, string $password): ?User
    {
        // 获取用户
        $user = $this->userDao->findUserByMobile($mobile);
        if (!$user) {
            $this->error('logic.MOBILE_NOT_FOUND');
        }

        if (!password_verify($password, $user->password)) {
            $this->error('logic.LOGIN_PASSWORD_ERROR');
        }

        // 判断用户状态
        if ($user->status !== 1) {
            $this->error('logic.USER_STATUS_UNUSUAL');
        }
        // 登录记录
        di(UserLoginRecordDao::class)->insert($user->id);

        $user->login_time = time();
        $user->login_ip = ip2long(di(RequestInterface::class)->getServerParams()['remote_addr']);
        $user->save();

        return $user;
    }

    /**
     * 通过短信验证码登陆
     *
     * @param string $mobile
     * @param string $code
     * @return User
     */
    public function loginBySMSCode(string $mobile, string $code): ?User
    {
        // 校验验证码
        $cacheCode = di(SMSCaptcha::class)->get($mobile, 1);
        if ($code === null || $cacheCode !== $code) {
            $this->error('logic.SMS_CODE_ERROR');
        }

        // 获取用户
        $user = $this->userDao->findOrCreateUserByMobile($mobile);
        if (!$user) {
            $this->error('logic.MOBILE_NOT_FOUND');
        }

        $user->login_time = time();
        $user->login_ip = ip2long(di(RequestInterface::class)->getServerParams()['remote_addr']);
        $user->save();

        // 删除验证码缓存
        di(SMSCaptcha::class)->del($mobile, 1);

        // 登录记录
        di(UserLoginRecordDao::class)->insert($user->id);

        return $user;
    }

    /**
     * 发送短信验证码
     *
     * @param string $mobile
     */
    public function sendLoginCode(string $mobile): void
    {
        $result = di(SMSCaptcha::class)->set($mobile, 1,60);

        if (!$result) {
            $this->error('logic.SMS_SEND_ERROR');
        }
    }

    /**
     * 修改个人信息
     *
     * @param string $name
     * @param int    $sex
     * @param string $email
     * @param int    $birthday
     */
    public function changeInfo(string $name, int $sex, string $email, int $birthday): void
    {
        $user = JwtInstance::instance()->build()->getUser();
    }

    /**
     * 设置或者修改用户密码
     *
     * @param string $password
     * @param string $code
     */
    public function changePsw(string $password, string $code): void
    {
        $user = JwtInstance::instance()->build()->getUser();

        // 校验验证码
        $cacheCode = di(SMSCaptcha::class)->get($user->mobile, 2);
        if ($code === null || $cacheCode !== $code) {
            $this->error('logic.SMS_CODE_ERROR');
        }

        $user->password = $password;
        $user->save();

        $this->flushCache('UserUpdate', [$user->id]);
    }

}