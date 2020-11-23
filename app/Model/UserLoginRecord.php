<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * @property int $id 
 * @property int $user_id 
 * @property int $login_time 
 * @property int $login_ip 
 * @property string $device 
 */
class UserLoginRecord extends Model
{
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_login_record';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'login_time' => 'integer', 'login_ip' => 'integer'];

    public function creating(): void
    {
        // 自动写入登录IP
        try {
            $ip = ip2long(di(RequestInterface::class)->getServerParams()['remote_addr']);
            $this->login_ip = $ip;
        } catch (\Throwable $e) {
            $this->login_ip = 0;
        }
        $this->login_time = time();
        $this->device = $this->getContainer()->get(RequestInterface::class)->getHeaderLine('User-Agent');
    }

    /**
     * 自动转换为IP
     *
     * @param $value
     * @return string|void
     */
    public function getLoginIpAttribute($value)
    {
        return long2ip($value);
    }
}