<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\Event;

/**
 * TestEvent
 *
 * @author  小琪(991010625.com)
 * @package App\Event
 */
class TestEvent
{
    /**
     * @var int
     */
    public $order_id;

    /**
     * TestEvent constructor.
     *
     * @param int $order_id
     * @param int $result
     */
    public function __construct(int $order_id)
    {
        $this->order_id = $order_id;
    }
}