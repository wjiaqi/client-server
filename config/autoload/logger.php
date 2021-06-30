<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

$logChannel = [
    'request',  // 请求日志
    'upload',  // 上传日志
    'sql'     // sql 日志
];

$result = [];

foreach ($logChannel as $log) {
    $result[$log]['handlers'] = [
        [
            'class' => RotatingFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . "/runtime/logs/{$log}/{$log}.log",
                'level' => Logger::INFO,
            ],
            'formatter' => [
                'class' => LineFormatter::class,
                'constructor' => [
                    'format' => null,
                    'dateFormat' => null,
                    'allowInlineLineBreaks' => true,
                ],
            ],
        ]
    ];
}

return array_merge([
    'default' => [
        'handler' => [
            'class' => Monolog\Handler\StreamHandler::class,
            'constructor' => [
                'stream' => BASE_PATH . '/runtime/logs/hyperf.log',
                'level' => Monolog\Logger::DEBUG,
            ],
        ],
        'formatter' => [
            'class' => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format' => null,
                'dateFormat' => 'Y-m-d H:i:s',
                'allowInlineLineBreaks' => true,
            ],
        ],
    ]
], $result);
