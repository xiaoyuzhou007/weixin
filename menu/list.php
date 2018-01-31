<?php
/**
 * 功能：统一输出微信token值
 * 参数：	priAppId		系统分配
 * 	    priTimeStamp	系统当前时间
 * 		priSign			加密串，按照传递参数排序后加入系统分配的key值组合后md5
 * 返回：	status 			状态码，只有等于1时正确
 * 		token 			返回所需token值，目前一个半小时更新一次
 * 建议：	尽量对改文件加入权限后使用
 */

$accessToken = 'your accessToken';
$url = "https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token={$accessToken}";
$data = requestByGet($url);

include './list.html';

function requestByGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);

    !is_dir('./history') && mkdir('./history', '0777');
    $fileName = './history/' .time() . '.json';
    //file_put_contents($fileName, $data);
    $menu_json = json_decode($data,true);
    curl_close($ch);

    return $menu_json;
}