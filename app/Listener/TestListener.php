<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\Listener;

use App\Event\TestEvent;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * TestListener
 *
 * @Listener()
 * @author  小琪(991010625.com)
 * @package App\Listener
 */
class TestListener extends AbstractListener implements  ListenerInterface
{

    /**
     * @inheritDoc
     */
    public function listen(): array
    {
        return [
            TestEvent::class
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(object $event)
    {
        if (!$event instanceof TestEvent) {
            return;
        }
    }
}