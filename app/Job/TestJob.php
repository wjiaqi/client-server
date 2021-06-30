<?php

declare (strict_types=1);
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
 */

namespace App\Job;

use App\Service\OCRService;
use Hyperf\AsyncQueue\Job;

/**
 * TestJob
 *
 * @property int $type
 * @author xiaoqi(991010625@qq.com)
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