<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\Kernel\SMS;

use AlibabaCloud\Client\AlibabaCloud;
use App\Common\Base;
use App\Exception\LogicException;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Logger\LoggerFactory;

/**
 * ALiDaYu
 *
 * @author  小琪(991010625.com)
 * @package App\Kernel\SMS
 */
class ALiDaYu extends Base implements SMSInterface
{

    /**
     * @inheritDoc
     */
    public function sendSMS(string $phone, int $type, array $content)
    {

        try {
            AlibabaCloud::accessKeyClient(
                env('ALI_CLOUD_ACCESS_KEY'),
                env('ALI_CLOUD_ACCESS_SECRET')
            )->regionId('cn-hangzhou')->asDefaultClient();

            $config = $this->container->get(ConfigInterface::class)->get('sms');

            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->scheme('https')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'PhoneNumbers' => $phone,
                        'SignName' => $config['ali_dy']['sign_name'],
                        'TemplateCode' => $config['ali_dy']['template_code'][$type],
                        'RegionId' => $config['ali_dy']['region_id'],
                        'TemplateParam' => json_encode($content)
                    ],
                ])
                ->request();
            $response = $result->toArray();

            if ($response['Code']  === 'isv.MOBILE_NUMBER_ILLEGAL') {
                return;
            }
            if ($response['Code'] !== 'OK') {
                throw new LogicException('SMS SEND ERROR');
            }
        }
        catch (\Exception $e) {
            throw new LogicException($e->getMessage());
        }

    }
}