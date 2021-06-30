<?php
/**
 * @copyright 安巽
 * @version   1.0.0
 * @link      https://www.secxun.com
 */
return [
    'Auth' => [
        'LoginRequest'       => [
            'type'     => ['required' => '登陆失败'],
            'mobile'   => ['required_if' => '请输入手机号码', 'between' => '手机号码格式错误'],
            'password' => ['required_if' => '请输入登陆密码', 'alpha_dash' => '密码格式错误[仅支持字母和数字，以及破折号和下划线]', 'between' => '密码格式错误[6-30长度]'],
            'code'     => ['required_if' => '请输入短信验证码', 'digits' => '短信验证码格式错误']
        ],
        'SendSMSCodeRequest' => [
            'mobile' => ['required' => '请输入手机号码', 'between' => '手机号码格式错误']
        ],
        'RegisterRequest'    => [
            'mobile'     => ['required' => '请输入手机号码', 'between' => '手机号码格式错误'],
            'password'   => ['required' => '请输入密码', 'alpha_dash' => '密码格式错误[仅支持字母和数字，以及破折号和下划线]', 'between' => '密码格式错误[6-30长度]'],
            'code'       => ['required' => '请输入短信验证码', 'digits' => '短信验证码格式错误'],
            'randomCode' => ['required' => '请输入随机验证码', 'digits' => '随机验证码格式错误']
        ],
        'GetRandomCodeRequest' => [
            'mobile'     => ['required' => '请输入手机号码', 'between' => '手机号码格式错误']
        ]
    ],
    'User' => [
        'ChangePswRequest' => [
            'password'   => ['required' => '请输入密码', 'alpha_dash' => '密码格式错误[仅支持字母和数字，以及破折号和下划线]', 'between' => '密码格式错误[6-30长度]'],
            'code'       => ['required' => '请输入短信验证码', 'digits' => '短信验证码格式错误'],
        ]
    ],
];