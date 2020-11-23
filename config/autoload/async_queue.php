<?php
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
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
    // 短信队列
    'SMS' => [
        'driver'         => Hyperf\AsyncQueue\Driver\RedisDriver::class,
        'channel'        => 'Test',
        'timeout'        => 10,
        'retry_seconds'  => [1, 3, 5, 10],
        'handle_timeout' => 20,
        'processes'      => 1,
        'concurrent'     => [
            'limit' => 1,
        ],
    ],
];