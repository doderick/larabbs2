<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class BaiduTranslateHandler
{
    // 初始化配置信息
    private $api;
    private $appid;
    private $key;

    /**
     * 构造初始化配置信息
     */
    public function __construct()
    {
        $this->api   = 'https://fanyi-api.baidu.com/api/trans/vip/translate?';
        $this->appid = config('services.baidu_translate.appid');
        $this->key   = config('services.baidu_translate.key');
    }

    public function translate($text, $to = 'en', $from = 'auto')
    {
        // 如果没有配置百度翻译，自动使用兼容的拼音方案
        if (empty($this->appid) || empty($this->key)) {
            return $this->pinyin($text);
        }

        // 实例化 HTTP 客户端
        $http = app(Client::class);

        // 发送 HTTP Post 请求
        $response = $http->post($this->translateRequestToBaidu($text, $to, $from));

        $result = json_decode($response->getBody(), true);

        // 尝试获取翻译结果
        if (isset($result['trans_result'][0]['dst'])) {
            return str_slug($result['trans_result'][0]['dst'] . '-larabbs');
        } else {
            // 如果没有获得翻译结果，则使用拼音作为后备方案
            return $this->pinyin($text);
        }
    }

    public function pinyin($text)
    {
        return str_slug(app(Pinyin::class)->permalink($text) . '-larabbs');
    }

    private function translateRequestToBaidu($text, $to, $from)
    {
        $salt = time();
        // 生成sign，方法为 sign = md5(appid+q+salt+key)
        $sign = md5($this->appid . $text . $salt . $this->key);

        // 构建请求参数
        $query = http_build_query([
            'q'     => $text,
            'from'  => $from,
            'to'    => $to,
            'appid' => $this->appid,
            'salt'  => $salt,
            'sign'  => $sign,
        ]);

       return $this->api . $query;
    }
}