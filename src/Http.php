<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace saithink\lib;

/**
 * Http操作类
 * Class Json
 * @package saithink\lib
 */
class Http
{
	/**
     * HTTP请求（支持HTTP/HTTPS，支持GET/POST）
     * 默认post
     * @return mixed
     **/
    public static function httpRequest($url, $data = null, $type=null)
    {
        $curl = curl_init();
        if ($type == 'json') {
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);
            curl_setopt($curl, CURLOPT_HEADER, false);
        } elseif ($type=='get') {
            $url .= '?';
            foreach ($data as $k=>$v) {
                $url.= \sprintf("%s=%s&", $k, $v);
            }
            $data = null;
            $url = rtrim($url, "?");
        }
        // 当遇到location跳转时，直接抓取跳转的页面，防止出现301
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($curl);
        curl_close($curl);
        $rt = json_decode($output, true);
        if (empty($rt)) {
            $rt = $output;
        }
        return $rt;
    }
}
