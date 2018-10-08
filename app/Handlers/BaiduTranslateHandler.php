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

    /**
     * 进行文本翻译的方法
     *
     * @param string $text 需要翻译的文本
     * @param string $to   目标语言，默认为英语，除非特殊需要，不建议改成其它语言
     * @param string $from 源语言，支持自动识别，如果可以确认源语言，可以设定一个固定的值
     * @return void        翻译结果
     */
    public function translate($text, $to = 'en', $from = 'auto')
    {
        // 检查百度翻译的配置，如果没有配置 appid 或者 key 使用 pinyin 作为替代方案
        if (empty($this->appid) || empty($this->key)) {
            return $this->pinyin($text);
        }

        // 实例化 HTTP 客户端
        $http = app(Client::class);

        // 发送 HTTP POST 翻译请求
        $response = $http->post($this->translateRequestToBaidu($text, $to, $from));

        // 尝试 decode 返回的 json
        $result = json_decode($response->getBody(), true);

        // 尝试获取翻译结果，如果无法获得翻译结果，切换到 pinyin 方案
        // 建议在翻译结果前（后）拼接前（后）缀，以免和路由发生冲突
        if (isset($result['trans_result'][0]['dst'])) {
            return str_slug($result['trans_result'][0]['dst'] . '-larabbs');
        } else {
            // 没有获得结果时，使用备选的 pinyin 方案
            return $this->pinyin($text);
        }
    }

    /**
     * 翻译的备选方案 pinyin
     *
     * @param string $text 需要翻译的文本
     * @return void        翻译的结果，加前（后）缀，以免和路由发生冲突
     */
    public function pinyin($text)
    {
        // 实例化 pinyin 客户端
        $pinyin = app(Pinyin::class);

        // 返回结果
        return str_slug($pinyin->permalink($text) . '-larabbs');
    }

    /**
     * 获得百度翻译请求链接的方法
     *
     * @param string $text 需要翻译的文本
     * @param string $to   目标语言
     * @param string $from 源语言
     * @return void        百度翻译的请求链接
     */
    public function translateRequestToBaidu($text, $to, $from)
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