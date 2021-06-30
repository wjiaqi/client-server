<?php

declare (strict_types=1);
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */

namespace App\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Logger\LoggerFactory;
use Hyperf\RpcServer\Annotation\RpcService;
use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;

/**
 * JsonRpcAspect
 *
 * @Aspect()
 * @author  xiaoqi(991010625@qq.com)
 * @package App\Aspect
 */
class JsonRpcAspect extends AbstractAspect
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @var array
     */
    public $annotations = [
        //        RpcService::class
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return array
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint): array
    {
        $method = $proceedingJoinPoint->className . '::' . $proceedingJoinPoint->methodName;
        try {
            $result = [
                'code'    => 0,
                'message' => 'success',
                'result'  => $proceedingJoinPoint->process()
            ];
            // 重置Token
            if (Context::has('ExchangeToken')) {
                $result['exchange-token'] = Context::get('ExchangeToken');
            }
            // 记录成功日志
            $this->container->get(LoggerFactory::class)->get('log', 'rpc')->info($method, [
                'actions' => $proceedingJoinPoint->getArguments(),
                'results' => $result
            ]);
        } catch (\Exception $e) {
            $result = [
                'code'    => $e->getCode(),
                'message' => $e->getMessage()
            ];
            // 记录错误日志
            $this->container->get(LoggerFactory::class)->get('log', 'rpc')->error($method, [
                'actions' => $proceedingJoinPoint->getArguments(),
                'results' => $result
            ]);
        }
        return $result;
    }
}