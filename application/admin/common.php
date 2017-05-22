<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-17
 * @Time: 16:13
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： common.php
 */
if (!function_exists('get_used_status'))
{
    /**
     * get_used_status
     * 获取服务器CPU使用率、内存使用情况、进行数等信息
     *
     * @return array
     */
    function get_used_status()
    {
        // 获取某一时刻系统cpu和内存使用情况
        $fp = popen('top -b -n 2 | grep -E "^(Cpu|Mem|Tasks)"',"r");
        $rs = "";
        while(!feof($fp)){
            $rs .= fread($fp,1024);
        }
        pclose($fp);
        $sys_info = explode("\n",$rs);
        $tast_info = explode(",",$sys_info[3]); // 进程 数组
        $cpu_info = explode(",",$sys_info[4]);  // CPU占有量  数组
        $mem_info = explode(",",$sys_info[5]);  // 内存占有量 数组
        //正在运行的进程数
        $tast_running = trim(trim($tast_info[1],'running'));


        //CPU占有量
        $cpu_usage = trim(trim($cpu_info[0],'Cpu(s): '),'%us');  //百分比

        //内存占有量
        $mem_total = trim(trim($mem_info[0],'Mem: '),'k total');
        $mem_used = trim($mem_info[1],'k used');
        $mem_usage = round(100*intval($mem_used)/intval($mem_total),2);  //百分比

        /*硬盘使用率 begin*/
        $fp = popen('df -lh | grep -E "^(/)"',"r");
        $rs = fread($fp,1024);
        pclose($fp);
        $rs = preg_replace("/\s{2,}/",' ',$rs);  //把多个空格换成 “_”
        $hd = explode(" ",$rs);
        $hd_avail = trim($hd[3],'G'); //磁盘可用空间大小 单位G
        $hd_usage = trim($hd[4],'%'); //挂载点 百分比
        //print_r($hd);
        /*硬盘使用率 end*/

        //检测时间
        $fp = popen("date +\"%Y-%m-%d %H:%M\"","r");
        $rs = fread($fp,1024);
        pclose($fp);
        $detection_time = trim($rs);

        /*获取IP地址  begin*/
        /*
        $fp = popen('ifconfig eth0 | grep -E "(inet addr)"','r');
        $rs = fread($fp,1024);
        pclose($fp);
        $rs = preg_replace("/\s{2,}/",' ',trim($rs));  //把多个空格换成 “_”
        $rs = explode(" ",$rs);
        $ip = trim($rs[1],'addr:');
        */
        /*获取IP地址 end*/
        /*
        $file_name = "/tmp/data.txt"; // 绝对路径: homedata.dat
        $file_pointer = fopen($file_name, "a+"); // "w"是一种模式，详见后面
        fwrite($file_pointer,$ip); // 先把文件剪切为0字节大小， 然后写入
        fclose($file_pointer); // 结束
        */

        return array('cpu_usage'=>$cpu_usage,'mem_usage'=>$mem_usage,'hd_avail'=>$hd_avail,'hd_usage'=>$hd_usage,'tast_running'=>$tast_running,'detection_time'=>$detection_time);
    }
}