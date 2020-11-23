<?php
declare (strict_types=1);
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version   1.0.0
 * @link      https://dayiguo.com
 */

namespace App\Kernel\Captcha;

use App\Common\Base;
use App\Constants\Constants;
use App\Exception\LogicException;
use App\Job\SMSJob;
use App\Kernel\Utils\Random;


use Psr\SimpleCache\InvalidArgumentException;

/**
 * 短信验证码逻辑
 *
 * @author  王佳其(991010625@qq.com)
 * @package App\Kernel\Captcha
 */
class SMSCaptcha extends Base
{
    /**
     * 登陆验证码缓存前缀
     *
     * @var string
     */
    public const LOGIN_CAPTCHA_PREFIX = 'LoginSMSCode:';

    /**
     * 修改密码验证码缓存前缀
     *
     * @var string
     */
    public const CHANGE_PSW_CAPTCHA_PREFIX = 'ChangePswSMSCode';

    /**
     * 设置验证码
     *
     * @param string $mobile
     * @param int    $type
     * @param int    $limitSecond
     *
     * @return bool
     */
    public function set(string $mobile, int $type, int $limitSecond): bool
    {
        $cachePrefix = $this->getSMSType($type);

        try {
            // 判断发送间隔
            $his = $this->cache()->get($cachePrefix . $mobile);
            if ($his && $his['setTime'] + $limitSecond > time()) {
                $this->error('logic.SMS_CODE_FREQUENTLY');
            }
            $code = Random::generatorCode6();
            // 投递短信队列
            $this->asyncQueue('SMS')->push(new SMSJob($mobile, $type, ['code' => $code]), 1);

            return $this->cache()->set($cachePrefix . $mobile, [
                'code'    => $code,
                'setTime' => time(),
            ], 1800);
        }
        catch (InvalidArgumentException $e) {
            return false;
        }
    }

    /**
     * 获取验证码
     *
     * @param string $mobile
     *
     * @param int    $type
     *
     * @return null|string
     */
    public function get(string $mobile, int $type): ?string
    {
        $cachePrefix = $this->getSMSType($type);

        try {
            $code = $this->cache()->get($cachePrefix . $mobile);

            return is_array($code) ? $code['code'] : null;
        }
        catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * 销毁验证码
     *
     * @param string $mobile
     *
     * @param int    $type
     *
     * @return bool
     */
    public function del(string $mobile, int $type): bool
    {
        $cachePrefix = $this->getSMSType($type);

        try {
            return (bool)$this->cache()->delete($cachePrefix . $mobile);
        }
        catch (InvalidArgumentException $e) {
            return false;
        }
    }

    /**
     * 获取短信验证码类型
     *
     * @param int $type
     *
     * @return string
     */
    public function getSMSType(int $type): string
    {
        switch ($type){
            case 1:
                return self::LOGIN_CAPTCHA_PREFIX;
            case 2:
                return self::CHANGE_PSW_CAPTCHA_PREFIX;
            default:
                return '';
        }
    }

}