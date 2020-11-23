<?php
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

/**
 * 短信配置
 */
return [
    'ali_dy' => [
        'sign_name' => '乐呗娱乐',
        'template_code' => [
            1 => 'SMS_153830039',  // 登录短信
            2 => 'SMS_153830040'   // 忘记密码
        ],
        'region_id' => [
            'cn-hangzhou'
        ]
    ]
];