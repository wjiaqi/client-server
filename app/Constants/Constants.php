<?php

declare(strict_types=1);
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Constants;

/**
 * 常量合集
 *
 * @author  王佳其(991010625@qq.com)
 * @package App\Constants
 */
class Constants
{
    // token header name
    public const AUTHORIZATION = 'Authorization';

    // channel header name
    public const CHANNEL_CODE = 'ChannelCode';

    // token 有效期
    public const AUTHORIZATION_EXPIRE = 86400;

    // token 提前续期时间
    public const AUTHORIZATION_RENEW = 3600;

    //获取资方过期时间
    public const CACHE_LOCK_EXPIRE_TIME = 10;



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
