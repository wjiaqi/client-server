<?php

declare(strict_types=1);
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */

namespace App\Constants;

/**
 * 常量合集
 *
 * @author  xiaoqi(991010625@qq.com)
 * @package App\Constants
 */
class Constants
{
    // token header name
    public const AUTHORIZATION = 'Authorization';

    // token 有效期
    public const AUTHORIZATION_EXPIRE = 86400;

    // token 提前续期时间
    public const AUTHORIZATION_RENEW = 3600;

    // 文件类型白名单
    public const UPLOADS_CONFIG = [
        [
            'directory' => 'images',
            'mime' => ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/bmp'],
            'maxSize' => 2097152
        ],
        [
            'directory' => 'videos',
            'mime' => ['video/mpeg', 'video/x-msvideo', 'video/mp4', 'application/mp4', 'video/x-flv', 'video/x-m4v', 'video/ogg', 'application/octet-stream', 'application/octet-stream'],
            'maxSize' => 10485760
        ],
    ];

    public const RESOURCE_WHITE_LIST = [
    ];


}
