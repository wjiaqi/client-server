<?php
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */

namespace App\Rpc\Client;

/**
 * 测试服务
 *
 * @author  xiaoqi(991010625@qq.com)
 * @package App\JsonRpc
 */
interface TestServiceInterface
{
    /**
     * 测试服务
     *
     * @param int $order_id 订单ID
     * @return array
     */
    public function riskApprove(int $order_id): array;

    /**
     * 结论(该接口会自动写入审批记录)
     *
     * @param int $task_id 任务ID
     * @param int $result 结论
     * @param int $admin_id 账号ID
     * @return array
     *  message:
     *      APPROVE_TASK_NOT_FOUND: 审批任务不存在
     *      APPROVED: 审批任务已经处理过，不允许重复处理
     *      ORDER_NOT_FOUND: 订单不存在
     *      ORDER_STATUS_ERROR: 订单状态错误
     *      APPROVE_RESULT_NOT_SUPPORT: 不支持该审批结论
     */
    public function approveResult(int $task_id, int $result, int $admin_id): array;
}