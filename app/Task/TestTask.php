<?php
declare (strict_types=1);
/**
 * @copyright 安巽
 * @version   1.0.0
 * @link
 */

namespace App\Task;

use Hyperf\Crontab\Annotation\Crontab;

/**
 * TestTask
 *
 * @Crontab(name="TestTask", rule="00 01 * * *", singleton=true, onOneServer=true, callback="run", memo="每天01点00分执行贷后数据计算任务")
 *
 * @author  小琪(991010625.com)
 * @package App\Task
 */
class TestTask
{
    public function run(): void
    {
        return;
    }
}