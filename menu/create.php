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
$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$accessToken}";
$data = requestByPost($url, $_POST['menu'], true);
if($data['errcode'] == "0"){
    echo "创建成功";
    header('Location: list.php');
}else{
    echo "创建失败";
}

function requestByPost($url, $post_data, $isJson = false)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!$isJson){
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    } else {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($post_data)));
    }

    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
    $data = json_decode(curl_exec($ch),true);
    curl_close($ch);
    return $data;
}
