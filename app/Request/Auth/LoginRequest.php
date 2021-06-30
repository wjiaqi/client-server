<?php

declare(strict_types=1);
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */
namespace App\Request\Auth;

use App\Request\RequestAbstract;

/**
 * 登陆验证器
 *
 * @author  xiaoqi(991010625@qq.com)
 * @package App\Controller
 */
class LoginRequest extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * `type=1` 手机+密码登陆
     * `type=2` 手机+验证码登陆
     */
    public function rules(): array
    {
        return [
            'type' => 'required',
            'mobile' => ['required', 'between:8,13'],
            'password' => ['required_if:type,1', 'alpha_dash', 'between:6,30'],
            'code' => ['required_if:type,2', 'digits:6']
        ];
    }
}
