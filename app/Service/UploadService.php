<?php
declare (strict_types=1);
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Service;

use App\Common\Base;
use App\Constants\Constants;
use App\Exception\LogicException;

use App\Kernel\Utils\JwtInstance;
use Hyperf\HttpMessage\Upload\UploadedFile;
use League\Flysystem\FileExistsException;

/**
 * 上传服务
 *
 * @author  王佳其(991010625@qq.com)
 * @package App\Service
 */
class UploadService extends Base
{
    /**
     * PAN卡图片
     *
     * @var string
     */
    const FILE_PREFIX_PAN = '/pan/';

    /**
     * 身份证图片
     *
     * @var string
     */
    const FILE_PREFIX_ID_CARD = '/aadhaar/';

    /**
     * 用户头像
     *
     * @var string
     */
    const FILE_PREFIX_AVATAR = '/avatar/';

    /**
     * 驾驶证
     *
     * @var string
     */
    const FILE_PREFIX_DL = '/driver_license/';

    /**
     * 通讯录
     *
     * @var string
     */
    const FILE_PREFIX_ADDRESS = '/address_book/';

    /**
     * 短信
     *
     * @var string
     */
    const FILE_PREFIX_MESSAGE = '/message/';

    /**
     * app安装列表
     *
     * @var string
     */
    const FILE_PREFIX_APP_INSTALL = '/app_install/';

    /**
     * 通话记录
     *
     * @var string
     */
    const FILE_PREFIX_CALL_RECORD = '/call_records/';

    /**
     * 活体数据储存路径
     *
     * @var string
     */
    const FILE_PREFIX_LIVE_ANTI_HACK = '/live_anti_hack/';
    /**
     * 文件上传处理
     * @param UploadedFile $file
     * @param string $prefix
     * @return bool|array
     */
    public function handle(UploadedFile $file, string $prefix)
    {
        try {
            // 判断文件类型
            $mime = strtolower($file->getMimeType());
            $directory = '';
            foreach (Constants::UPLOADS_CONFIG as $option) {
                if (in_array($mime, $option['mime'], true)) {
                    // 文件大小限制
                    if ($file->getSize() > $option['maxSize']) {
                        throw new LogicException('logic.IMAGE_SIZE_EXCEED');
                    }

                    // 目录
                    $directory = $option['directory'];
                }
            }

            // 如果没有取到目录，不支持的文件类型
            if ($directory === '') {
                throw new LogicException('logic.FILE_FORMAT_ERROR');
            }

            // 获取文件路径
            $tmp_file = (string)$file->getRealPath();
            $file_name = md5_file($tmp_file) . '.' . $file->getExtension();

            $uri = $directory . $prefix . $file_name;
            // 执行上传
            if (!$this->upload()->writeStream($uri, fopen($tmp_file, 'r+'))) {
                throw new LogicException('logic.UPLOAD_FAIL');
            }
        }
        catch (LogicException $e) {
            // 逻辑错误
            $this->error($e->getMessage());
        }
        catch (FileExistsException $e) {
            // 文件已存在，正常返回不需要抛异常
        }
        catch (\Exception $e) {
            // 未知错误
            $this->logger('upload')->error($e->getMessage());
            $this->error('logic.UPLOAD_FAIL');
        }

        // 若要带上文件域名，请在 uri 前面拼接 gConfig('ali_oss_domain')
        return [
            'filename' => $file->getClientFilename(),
            'status' => true,
            'uri' => $uri ?? null
        ];
    }

    /**
     * 资料文件上传处理
     *
     * @param array $content
     * @param string $prefix
     * @return array
     */
    public function informationHandler(array $content, string $prefix): array
    {
        try {
            $directory = Constants::USER_INFORMATION_PREFIX;

            // 根据用户id设置文件路径
            $uid = JwtInstance::instance()->build()->getId();
            $file_name =  $uid . '.' . 'json';

            // information/app_install/132.json
            $uri = $directory . $prefix . $file_name;

            $upload = $this->upload();

            //判断对应资料文件是否存在 存在对数据进行去重
            if ($upload->has($uri)) {
                $historyData = json_decode($upload->read($uri), true);
                $content = array_unique(array_merge($historyData, $content), SORT_REGULAR);

                //更新文件
                if (!$upload->update($uri, json_encode($content))) {
                    throw new LogicException('logic.UPLOAD_FAIL');
                }
            }else{
                // 执行上传
                if (!$upload->write($uri, json_encode($content))) {
                    throw new LogicException('logic.UPLOAD_FAIL');
                }
            }

        }
        catch (LogicException $e) {
            // 逻辑错误
            $this->error($e->getMessage());
        }
        catch (\Exception $e) {
            // 未知错误
            var_dump($e->getMessage());
            $this->logger('upload')->error($e->getMessage());
            $this->error('logic.UPLOAD_FAIL');
        }

        return [
            'status' => true,
        ];
    }


}