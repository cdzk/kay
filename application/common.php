<?php
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