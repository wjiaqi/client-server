<?php
declare (strict_types=1);
/**
 * @copyright 深圳市乐悠悠网络科技有限公司
 * @version   1.0.0
 * @link
 */

namespace App\Controller;

use App\Kernel\Captcha\SMSCaptcha;
use App\Kernel\Utils\JwtInstance;
use App\Request\User\ChangePswRequest;
use App\Service\UserService;
use App\Middleware\AuthMiddleware;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Annotation\Middleware;

/**
 * UserController
 *
 * @AutoController()
 * @Middleware(AuthMiddleware::class)
 *
 * @author  小琪(991010625.com)
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * 用户服务
     *
     * @Inject()
     * @var UserService
     */
    private $UserService;

    /**
     * 获取个人资料
     */
    public function info(): void
    {
        $user = JwtInstance::instance()->build()->getUser();

        $this->success([
            'userId' => $user->id,
            'mobile' => $user->mobile,
            'nickname' => $user->nickname,
            'email' => $user->email,
            'avatar' => empty($user->avatar) ? '' : env('QINIU_DOMAIN') . $user->avatar,
            'birthday' => empty($user->birthday) ?null : date('Y-m-d', $user->birthday),
            'sex'      => $user->sex
        ]);
    }

    /**
     * 发送修改密码验证码
     */
    public function sendChangePswCode(): void
    {
        $user = JwtInstance::instance()->build()->getUser();

        di(SMSCaptcha::class)->set($user->mobile, 2, 80);

        $this->success();
    }


    /**
     * 修改或者设置密码
     *
     * @param ChangePswRequest $request
     */
    public function changePassword(ChangePswRequest $request): void
    {
        $psw = trim($request->input('password'));
        $code = trim($request->input('code'));

        $this->UserService->changePsw($psw, $code);

        $this->success();
    }
}