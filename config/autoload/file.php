<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\Filesystem\Adapter\AliyunOssAdapterFactory;
use Hyperf\Filesystem\Adapter\LocalAdapterFactory;

return [
    'default' => 'oss',
    'storage' => [
        'local' => [
            'driver' => LocalAdapterFactory::class,
            'root' => __DIR__ . '/../../runtime',
        ],
        'oss' => [
            'driver' => AliyunOssAdapterFactory::class,
            'accessId' => env('OSS_ACCESS_ID'),
            'accessSecret' => env('OSS_ACCESS_SECRET'),
            'bucket' => env('OSS_BUCKET'),
            'endpoint' => env('OSS_ENDPOINT'),
            'timeout' => 3600,
            'connectTimeout' => 10,
            'isCName' => false,
            'token' => '',
        ],
    ],
];
