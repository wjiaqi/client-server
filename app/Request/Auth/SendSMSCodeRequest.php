<?php

declare(strict_types=1);
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */
namespace App\Request\Auth;

use App\Request\RequestAbstract;

/**
 * 登陆验证器
 *
 * @author  王佳其(991010625@qq.com)
 * @package App\Controller
 */
class SendSMSCodeRequest extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mobile' => ['required', 'between:8,13']
        ];
    }
}
