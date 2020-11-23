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

switch (env('APP_ENV', 'dev')) {
    case 'dev':
    case 'trial':
        $config = [
            'default' => [
                'host'    => env('REDIS_HOST', 'localhost'),
                'db'      => (int)env('REDIS_DB', 0),
                'auth'    => env('REDIS_AUTH', null),
                'cluster' => [],
                'pool'    => [
                    'min_connections' => 1,
                    'max_connections' => 10,
                    'connect_timeout' => 10.0,
                    'wait_timeout'    => 3.0,
                    'heartbeat'       => -1,
                    'max_idle_time'   => (float)env('REDIS_MAX_IDLE_TIME', 60),
                ],
            ],
        ];
        break;
    case 'formal':
        $config = [
            'default' => [
                'auth'    => env('REDIS_AUTH', null),
                'cluster' => [
                    'enable'       => true,
                    'name'         => null,
                    'seeds'        => empty(env('REDIS_HOST')) ? '' : explode(',', env('REDIS_HOST')),
                    'read_timeout' => 0.0
                ],
                'db'      => (int)env('REDIS_DB', 0),
                'pool'    => [
                    'min_connections' => 1,
                    'max_connections' => 10,
                    'connect_timeout' => 10.0,
                    'wait_timeout'    => 3.0,
                    'heartbeat'       => -1,
                    'max_idle_time'   => (float)env('REDIS_MAX_IDLE_TIME', 60),
                ],
            ],
        ];
        break;

}
return $config;

