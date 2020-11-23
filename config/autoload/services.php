<?php
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */


return [
    'consumers' => value(function () {
        $consumers = [];
        $services = [
        ];
        foreach ($services as $name => $interface) {
            $consumers[] = [
                'name' => $name,
                'service' => $interface,
                'protocol' => 'jsonrpc',
                'load_balancer' => 'random',
                'registry' => [
                    'protocol' => 'consul',
                    'address' => env('CONSUL', 'http://127.0.0.1:8500'),
                ],
                'options' => [
                    'connect_timeout' => 5.0,
                    'recv_timeout' => 5.0,
                    'settings' => [
                        'open_eof_split' => true,
                        'package_eof' => "\r\n",
                        // 'open_length_check' => true,
                        // 'package_length_type' => 'N',
                        // 'package_length_offset' => 0,
                        // 'package_body_offset' => 4,
                    ],
                    'pool' => [
                        'min_connections' => 1,
                        'max_connections' => 32,
                        'connect_timeout' => 10.0,
                        'wait_timeout' => 3.0,
                        'heartbeat' => -1,
                        'max_idle_time' => 60.0,
                    ],
                ]
            ];
        }
        return $consumers;
    })
];
