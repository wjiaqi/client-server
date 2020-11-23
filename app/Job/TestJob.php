<?php

declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Job;

use App\Service\OCRService;
use Hyperf\AsyncQueue\Job;

/**
 * TestJob
 *
 * @property int $type
 * @author 王佳其(991010625@qq.com)
 * @package App\Job
 */
class TestJob extends Job
{
    /**
     * 类型
     *
     * @var int
     */
    public $type;

    public function __construct(int $type)
    {
        $this->type = $type;
    }

    public function handle(): void
    {

    }
}