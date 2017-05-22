<?php
define('SOFT_NAME', 'YC-EMIS');                     // 软件名称
define('SOFT_VERSION', '1.0.0');                    // 软件版本
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