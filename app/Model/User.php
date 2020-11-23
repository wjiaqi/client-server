<?php

declare (strict_types=1);
namespace App\Model;

use App\Constants\Constants;
use Hyperf\DbConnection\Model\Model;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;

/**
 * @property int $id 
 * @property string $mobile 
 * @property string $password 
 * @property string $nickname 
 * @property string $avatar 
 * @property string $email 
 * @property int $sex 
 * @property int $birthday 
 * @property int $reg_time 
 * @property int $reg_ip 
 * @property int $status 
 * @property int $channel_id
 * @property int $login_time
 * @property int $login_ip
 */
class User extends Model
{
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['mobile'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'sex' => 'integer', 'birthday' => 'integer', 'reg_time' => 'integer', 'reg_ip' => 'integer', 'status' => 'integer', 'channel_id' => 'integer'];

    /**
     * 隐藏重要的字段
     *
     * @var array
     */
    protected $hidden = ['reg_time', 'reg_ip', 'password'];

    /**
     * 创建数据时触发的操作
     */
    public function creating()
    {
        // 自动写入注册IP
        try {
            $ip = ip2long(di(RequestInterface::class)->getServerParams()['remote_addr']);
            $this->reg_ip = $ip;
        } catch (\Throwable $e) {
            $this->reg_ip = 0;
        }
        $this->channel_id = (int)$this->getContainer()->get(RequestInterface::class)->getHeaderLine(Constants::CHANNEL_CODE);
        $this->status = 1;
        $this->reg_time = time();
    }
    /**
     * 自动转换为IP
     *
     * @param $value
     * @return string|void
     */
    public function getRegIpAttribute($value)
    {
        return long2ip($value);
    }

    /**
     * 密码修改器
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if ($value !== '') {
            $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
        }
    }
}