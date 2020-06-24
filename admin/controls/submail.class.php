<?php
/**
 * UQ云商：    www.uqcms.com
 * 联系QQ：    2200631718
 * 可免费商用，需要留UQ云商链接作为交换，只首页底部留取即可，不影响使用。
 */

defined('IN_UQ') or exit('Access Denied');

class submail_uqcms extends control
{
    function __construct()
    {
        $this->aid = $_SESSION['admin']['aid'];
        parent::__construct();
    }

    public  function index()
    {
        $res=$this->db->add(table('api'),["type"=>"sms","alias"=>"submail","name"=>"赛邮云计算","desc"=>"赛邮云计算有限公司","svg"=>"","param"=>"app_id,app_key,sign","pcon"=>"NULL","version"=>"1.1.1","status"=>1]);
        if($res){
            echo "安装成功";die;
        }else{
            echo "安装失败";die;
        }
    }
}
