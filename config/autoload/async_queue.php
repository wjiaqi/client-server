<?php
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */

return [
    'default'     => [
        'driver'         => Hyperf\AsyncQueue\Driver\RedisDriver::class,
        'redis'          => [
            'pool' => 'default'
        ],
        'channel'        => 'queue',
        'timeout'        => 2,
        'retry_seconds'  => 5,
        'handle_timeout' => 10,
        'processes'      => 1,
        'concurrent'     => [
            'limit' => 5,
        ],
    ],
];