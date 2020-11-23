<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\Request\User;

use App\Request\RequestAbstract;

/**
 * ChangePswRequest
 *
 * @author  小琪(991010625.com)
 * @package App\Request\User
 */
class ChangePswRequest extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * password  新的密码
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'alpha_dash', 'between:6,30'],
            'code' => ['required', 'digits:6'],
        ];
    }
}