<?php

/**
 * UQ云商：    www.uqcms.com
 * 联系QQ：    2200631718
 * 可免费商用，需要留UQ云商链接作为交换，只首页底部留取即可，不影响使用。
 */
class sms_submail
{
    private static $uq0;

    public static function init()
    {
        if (is_null(self::$uq0)) {
            self::$uq0 = new self();
        }
        return self::$uq0;
    }

    function __construct($uq1)
    {
        $this->url = 'https://api.mysubmail.com/message/xsend.json';
        $this->app_id = $uq1['app_id'];
        $this->app_key = $uq1['app_key'];
        $this->sign = $uq1['sign'];
    }

    function send($uq2, $uq3, $uq4)
    {
        if (!$uq2) return array('error' => '1', 'msg' => 'number err');
        if (!$uq3) return array('error' => '1', 'msg' => 'project err');
        if (!$uq4) return array('error' => '1', 'msg' => 'code err');

        $data['appid'] = $this->app_id;
        $data['sign_type'] = 'sha1';
        $data['project'] = $uq3;
        $data['to'] = $uq2;
        $data['vars'] = json_encode($uq4);
        $data = array_merge($data, $this->remoteTimestamp());
        $data['signature'] = $this->computeSignature($data);
        $uq8 = curl::post($this->url, $data);
        $uq9 = json_decode($uq8);
        if ($uq9->status == 'success') {
            return ['error' => '0', 'msg' => '发送成功'];
        } else {
            return array('error' => '1', 'msg' => $uq9->msg);
        }
    }

    private function remoteTimestamp()
    {
        $output = @file_get_contents('https://api.mysubmail.com/service/timestamp');
        $output = trim($output, "\xEF\xBB\xBF");
        return json_decode($output, true);
    }

    private function computeSignature($request)
    {
        ksort($request);
        reset($request);
        $str = '';
        foreach ($request as $key => $value) {
            $str .= $key . "=" . $value . "&";
        }

        $str = substr($str, 0, -1);
        if (get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return sha1($this->app_id . $this->app_key . $str . $this->app_id . $this->app_key);
    }
}
