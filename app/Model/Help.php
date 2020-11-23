<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $title 
 * @property string $content 
 * @property int $code 
 * @property int $sort 
 * @property int $status 
 */
class Help extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'help';
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
    protected $casts = ['id' => 'integer', 'code' => 'integer', 'sort' => 'integer', 'status' => 'integer'];
}