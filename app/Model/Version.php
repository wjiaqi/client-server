<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\Database\Model\Events\Retrieved;
use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $app_market 
 * @property int $package_channel 
 * @property string $version_number 
 * @property int $number 
 * @property int $type 
 * @property string $update_content 
 * @property int $release_time 
 * @property string $download_url 
 * @property int $is_approve 
 * @property int $status 
 */
class Version extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'version';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'app_market' => 'integer', 'package_channel' => 'integer', 'number' => 'integer', 'type' => 'integer', 'release_time' => 'integer', 'is_approve' => 'integer', 'status' => 'integer'];

    /**
     * 配置图片链接
     *
     * @param Retrieved $event
     */
    public function retrieved(Retrieved $event): void
    {
        $pic = $event->getModel()->getAttribute('download_url');
        $pic = env('OSS_REQUIRE_PREFIX').$pic;
        $event->getModel()->setAttribute('download_url', $pic);
    }
}