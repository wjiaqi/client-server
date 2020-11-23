<?php

declare (strict_types=1);
/**
 * @copyright 深圳市易果网络科技有限公司
 * @version 1.0.0
 * @link https://dayiguo.com
 */

namespace App\Controller;

use App\Kernel\Utils\JwtInstance;
use App\Request\Auth\LoginRequest;
use App\Request\Auth\SendSMSCodeRequest;
use App\Service\UserService;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * 登陆控制器

 * @AutoController()
 * @author  王佳其(991010625@qq.com)
 * @package App\Controller
 */
class AuthController extends AbstractController
{
    /**
     * @Inject()
     * @var UserService
     */
    private $userService;

    /**
     * 登陆接口
     *
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request): void
    {
        // 登陆方式
        $type = (int)($request->input('type', 0));
        switch ($type) {
            case 1: // 手机+密码登陆
                $mobile = trim($request->input('mobile'));
                $password = trim($request->input('password'));
                $user = $this->userService->loginByPassword($mobile, $password);
                break;

            case 2: // 短信验证码登陆
                $mobile = trim($request->input('mobile'));
                $code = trim($request->input('code'));
                $user = $this->userService->loginBySMSCode($mobile, $code);
                break;

            default:
                $this->error('logic.SERVER_ERROR');
                return;
        }

        if (!$user instanceof \App\Model\User) {
            $this->error('logic.SERVER_ERROR');
        }

        // 生成token
        $token = JwtInstance::instance()->encode($user);

        $this->success([
            'token' => $token
        ]);
    }

    /**
     * todo 获取短信验证码接口
     *
     * @param SendSMSCodeRequest $request
     */
    public function sendSMSCode(SendSMSCodeRequest $request):void
    {
        $mobile = trim($request->input('mobile'));

        di(UserService::class)->sendLoginCode($mobile);

        // 发送成功
        $this->success(['status' => true]);
    }

    public function test()
    {
//        di(ALiDaYu::class)->sendSMS('13750249057', 1, ['code' => '999999']);
    }


}