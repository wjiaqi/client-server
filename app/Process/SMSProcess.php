<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\Process;

use Hyperf\AsyncQueue\Process\ConsumerProcess;
use Hyperf\Process\Annotation\Process;

/**
 * SMSProcess
 *
 * @Process()
 * @author  小琪(991010625.com)
 * @package App\Process
 */
class SMSProcess extends ConsumerProcess
{
    /**
     * @var string
     */
    protected $queue = 'SMS';
}