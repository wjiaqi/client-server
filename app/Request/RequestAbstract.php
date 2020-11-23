<?php

declare(strict_types=1);
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */
namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

/**
 * 验证器基类
 *
 * @author  王佳其(991010625@qq.com)
 * @package App\Controller
 */
abstract class RequestAbstract extends FormRequest
{
    public function messages(): array
    {
        $deep = str_replace('\\', '.', get_called_class());
        $deep = str_replace('App.Request.', '', $deep);

        $messages = [];

        foreach ($this->rules() as $name => $rules) {
            $rule_map = is_array($rules) ? $rules : explode('|', $rules);
            foreach ($rule_map as $map) {
                $map = explode(':', $map)[0];
                // 驼峰转小写
                $map = strtolower(preg_replace('/([A-Z])/','_$1', $map));
                $key = $name . '.' . $map;
                $messages[$key] = "{$deep}.{$name}.{$map}";
            }
        }

        return $messages;
    }
}
