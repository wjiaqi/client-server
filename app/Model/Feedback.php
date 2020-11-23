<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\Database\Model\Events\Created;
use Hyperf\Database\Model\Events\Updated;
use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $user_id 
 * @property string $content 
 * @property int $status 
 * @property int $created_at
 * @property int $updated_at
 */
class Feedback extends Model
{
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedback';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    /**
     * 创建
     */
    public function creating(): void
    {
        $this->created_at = time();
    }

    /**
     * 更新
     *
     * @param Updated $event
     */
    public function updating(Updated $event): void
    {
        $this->updated_at = time();
    }

    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'status' => 'integer', 'created_at' => 'integer', 'updated_at' => 'integer'];
}