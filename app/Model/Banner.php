<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\Database\Model\Events\Retrieved;
use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $title 
 * @property string content
 * @property int $sort 
 * @property string $pic 
 * @property int $status 
 */
class Banner extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banner';
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
    protected $casts = ['id' => 'integer', 'sort' => 'integer', 'status' => 'integer'];

    /**
     * 配置图片链接
     *
     * @param Retrieved $event
     */
    public function retrieved(Retrieved $event): void
    {
        $pic = $event->getModel()->getAttribute('pic');
        $pic = env('OSS_REQUIRE_PREFIX').$pic;
        $event->getModel()->setAttribute('pic', $pic);
    }

}