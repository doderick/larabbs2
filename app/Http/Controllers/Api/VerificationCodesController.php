<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Api\VerificationCodeRequest;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $phone = $request->phone;

        // 对于非生产环境并不需要发送真实的验证码
        // if (! app()->environment('production')) {
        //    $code = '1234';
        // } else {
            // 生成随机 4 位数，左侧补零
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            $min = 10;

            try {
                $result = $easySms->send($phone, [
                    'content' => "{$code}为您的登录验证码，请于{$min}分钟内填写。如非本人操作，请忽略本短信。"
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException('qcloud')->getMessage();
                return $this->response->errorInternal($message ?? '短信发送异常');
            }

            $key = 'verificationCode_' . str_random(15);
            $expiredAt = now()->addMinutes(10);
            // 缓存验证码， 5分钟过期
            \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

            return $this->response->array([
                'key' => $key,
                'expired_at' => $expiredAt->toDateTimeString(),
            ])->setStatusCode(201);
        }
    // }
}
