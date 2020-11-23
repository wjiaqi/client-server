<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\Request\Auth;

use App\Request\RequestAbstract;

/**
 * RegisterRequest
 *
 * @author  小琪(991010625.com)
 * @package App\Request\Auth
 */
class RegisterRequest extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * mobile 手机号
     * password  密码
     * code   验证码
     * verifyCode  随机验证码
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'mobile' => ['required', 'between:8,13'],
            'password' => ['required', 'alpha_dash', 'between:6,30'],
            'code' => ['required', 'digits:6'],
            'randomCode' => ['required', 'digits:6']
        ];
    }
}