<?php

declare (strict_types=1);
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */

namespace App\Kernel\Utils;

/**
 * Aes
 *
 * @author xiaoqi(991010625@qq.com)
 * @package App\Kernel\Utils
 */
class Aes
{
    public const KEY = 'YPCdGZrSz7sBbeTf323321opQI349KF0';
    public const METHOD = 'aes-256-ecb';


    //加密
    public function aesEncrypt(string $data): string
    {
        return base64_encode(openssl_encrypt($data, self::METHOD, self::KEY, OPENSSL_RAW_DATA));
    }

    //解密
    public function aesDecrypt(string $data)
    {
        return openssl_decrypt(base64_decode($data), self::METHOD, self::KEY, OPENSSL_RAW_DATA);
    }
}