<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\Kernel\SMS;

/**
 * SMSInterface
 *
 * @author  小琪(991010625.com)
 * @package App\Kernel\SMS
 */
interface SMSInterface
{
    /**
     * 发送短信
     *
     * @param string $phone_number  电话
     * @param int    $type  短信类型
     * @param array  $content  参数
     *
     */
    public function sendSMS(string $phone_number, int $type, array $content);
}