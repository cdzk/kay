<?php
define('SOFT_NAME', 'SiYi Fast Develop Framework'); // 软件名称
define('SOFT_VERSION', '1.0.1');                    // 软件版本
define('ADMIN_TITLE', 'SYFDF管理中心');              // 管理后台页面标题

define('PATH_STATIC', '/static/');                  // 静态资源目录
define('PATH_ADMIN_STATIC', '/static/admin/');      // 管理后台静态资源目录
define('PATH_COMMON_STATIC', '/static/common/');    // 公共静态资源目录
define('ADMIN_SKIN', 'skin-purple');                // 管理后台配色风格

if (!function_exists('scan_dir')) {
    /**
     * scan_dir
     * 遍历指定的目录，返回所有目录名称与文件名称
     *
     * @param string $dir 指定要遍历的目录
     * @return array
     */
    function scan_dir($dir)
    {
        $files=array();
        if(is_dir($dir))
        {
            if($handle=opendir($dir))
            {
                while(($file=readdir($handle))!==false)
                {
                    if($file!="." && $file!="..")
                    {
                        if(is_dir($dir."/".$file))
                        {
                            $files[$file]=scan_dir($dir."/".$file);
                        }
                        else
                        {
                            $files[]=$dir."/".$file;
                        }
                    }
                }
                closedir($handle);
                return $files;
            }
        }
    }
}

if (!function_exists('getip')) {
    function getip(){
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        }
        else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else if(!empty($_SERVER["REMOTE_ADDR"])){
            $cip = $_SERVER["REMOTE_ADDR"];
        }
        else{
            $cip = '';
        }
        preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = isset($cips[0]) ? $cips[0] : 'unknown';
        unset($cips);
        return $cip;
    }
}

if (!function_exists('verifyCode')) {
    /**
     * verify_code
     * 图形验证码
     *
     * @param int $width
     * @param int $height
     */
    function verifyCode($width=150, $height=44)
    {
        $captch = new \Minho\Captcha\CaptchaBuilder();

        $captch->initialize([
            'width' => $width,      // 宽度
            'height' => $height,    // 高度
            'line' => false,        // 直线
            'curve' => true,        // 曲线
            'noise' => 1,           // 噪点背景
            'fonts' => []           // 字体
        ]);
        $captch->create();

        $captch->output(1);

        \think\Session::set('verifyCode', $captch->getText(), 'common');
    }
}