<?php

declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Request\User;

use App\Request\RequestAbstract;

/**
 * ChangeNameRequest
 *
 * @author 王佳其(991010625@qq.com)
 * @package App\Request\Auth
 */
class ChangeNameRequest extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * `name` 更改名字
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|between:2,15',
        ];
    }
}