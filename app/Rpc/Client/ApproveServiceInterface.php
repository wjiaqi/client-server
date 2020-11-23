<?php
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Rpc\Client;

/**
 * 审批服务
 *
 * @author  王佳其(991010625@qq.com)
 * @package App\JsonRpc
 */
interface ApproveServiceInterface
{
    /**
     * 风控审批服务
     *
     * @param int $order_id 订单ID
     * @return array
     */
    public function riskApprove(int $order_id): array;

    /**
     * 审批结论(该接口会自动写入审批记录，调用时请勿重复插入审批记录; 非审批结论时需要自行创建审批记录)
     *
     * @param int $task_id 审批任务ID
     * @param int $result 审批结论 [0=审批通过; 1=审批拒接; 2=贷款取消]
     * @param int $admin_id 后台账号ID
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