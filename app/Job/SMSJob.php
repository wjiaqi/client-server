<?php

declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Job;

use App\Exception\LogicException;
use App\Kernel\SMS\SMSFactory;
use Hyperf\AsyncQueue\Job;
use Hyperf\Logger\LoggerFactory;

/**
 * SMSJob
 *
 * @property int $type
 * @property string $mobile
 * @author 王佳其(991010625@qq.com)
 * @package App\Job
 */
class SMSJob extends Job
{
    /**
     * 手机号
     *
     * @var string
     */
    public $mobile;

    /**
     * 短信类型
     *
     * @var int
     */
    public $type;

    /**
     * 短信参数
     *
     * @var array
     */
    public $params;

    public function __construct(string $mobile, int $type, array $params)
    {
        $this->mobile = $mobile;
        $this->type = $type;
        $this->params = $params;
    }

    public function handle():void
    {
        try {
            di(SMSFactory::class)->getSMSCloud()->sendSMS($this->mobile, $this->type, $this->params);
        }
        catch (\Exception $e) {
            di(LoggerFactory::class)->get('log', 'request')->error($e->getMessage(), [
                'module' => 'ALI_ClOUD_SMS',
                'params' => [
                    'mobile'  => $this->mobile,
                    'type'    => $this->type,
                    'content' => $this->params
                ],
            ]);
            throw new LogicException('SMS SEND ERROR');
        }
    }
}