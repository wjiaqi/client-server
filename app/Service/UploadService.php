<?php
declare (strict_types=1);
/**
 * @copyright 安巽
 * @version 1.0.0
 * @link https://www.secxun.com
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
 * @author  xiaoqi(991010625@qq.com)
 * @package App\Service
 */
class UploadService extends Base
{
    /**
     * 图片保存路径
     *
     * @var string
     */
    const FILE_PREFIX_TEST = '/test/';

    /**
     * 文件上传处理
     * @param UploadedFile $file
     * @param string $prefix
     * @return array
     */
    public function handle(UploadedFile $file, string $prefix): array
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
}