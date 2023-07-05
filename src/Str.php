<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace saithink\lib;

/**
 * String操作类
 * Class Str
 * @package saithink\lib
 */
class Str
{
    /**
     * 下划线转小驼峰
     * @param string $uncamelized_words
     * @param string $separator
     * @return string
     */
    public static function Camelize($uncamelized_words, $separator = '_')
    {
        $uncamelized_words = $separator . str_replace($separator, " ", strtolower($uncamelized_words));
        return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator);
    }

    /**
     * 下划线转大驼峰
     * @param string $uncamelized_words
     * @param string $separator
     * @return string
     */
    public static function CamelizeBig($uncamelized_words, $separator = '_')
    {
        $uncamelized_words = str_replace($separator, " ", strtolower($uncamelized_words));
        return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator);
    }

    /**
     * 驼峰转下划线
     * @param string $camelCaps
     * @param string $separator
     * @return string
     */
    public static function UnCamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }

    /**
     * 只替换一次字符串
     * @param string $needle
     * @param string $replace
     * @param string $haystack
     * @return string
     */
    public static function StrReplaceOnce($needle, $replace, $haystack) {
        $pos = strpos($haystack, $needle);
        if ($pos === false) {
            return $haystack;
        }
        return substr_replace($haystack, $replace, $pos, strlen($needle));
    }

    /**
     * sql参数过滤
     * @param string $str
     * @return string
     */
    public static function SqlFilter(string $str)
    {
        $filter = ['select ', 'insert ', 'update ', 'delete ', 'drop', 'truncate ', 'declare', 'xp_cmdshell', '/add', ' or ', 'exec', 'create', 'chr', 'mid', ' and ', 'execute'];
        $toupper = array_map(function ($str) {
            return strtoupper($str);
        }, $filter);
        return str_replace(array_merge($filter, $toupper, ['%20']), '', $str);
    }

    /**
     * 替换字符串中间内容
     * @param string $string 需要替换的字符串
     * @param int $start 开始的保留几位
     * @param int $end 最后保留几位
     * @return string
     */
    public static function MiddleReplace($string, $start, $end, $char = '*')
    {
        $strlen = mb_strlen($string, 'UTF-8');//获取字符串长度
        $firstStr = mb_substr($string, 0, $start, 'UTF-8');//获取第一位
        $lastStr = mb_substr($string, -$end, $end, 'UTF-8');//获取最后一位
        return $strlen == 2 ? $firstStr . str_repeat($char, mb_strlen($string, 'utf-8') - 1) : $firstStr . str_repeat($char, $strlen - 2) . $lastStr;
    }

    /**
     * 匿名处理处理字符串
     * @param $name
     * @return string
     */
    public static function Anonymity($name)
    {
        $strLen = mb_strlen($name, 'UTF-8');
        $min = 3;
        if ($strLen <= 1)
            return '*';
        if ($strLen <= $min)
            return mb_substr($name, 0, 1, 'UTF-8') . str_repeat('*', $min - 1);
        else
            return mb_substr($name, 0, 1, 'UTF-8') . str_repeat('*', $strLen - 1) . mb_substr($name, -1, 1, 'UTF-8');
    }

    /**
     * 身份证号码验证
     * @param $card
     * @return bool
     */
    public static function CheckID($card)
    {
        $city = [11 => "北京", 12 => "天津", 13 => "河北", 14 => "山西", 15 => "内蒙古", 21 => "辽宁", 22 => "吉林", 23 => "黑龙江 ", 31 => "上海", 32 => "江苏", 33 => "浙江", 34 => "安徽", 35 => "福建", 36 => "江西", 37 => "山东", 41 => "河南", 42 => "湖北 ", 43 => "湖南", 44 => "广东", 45 => "广西", 46 => "海南", 50 => "重庆", 51 => "四川", 52 => "贵州", 53 => "云南", 54 => "西藏 ", 61 => "陕西", 62 => "甘肃", 63 => "青海", 64 => "宁夏", 65 => "新疆", 71 => "台湾", 81 => "香港", 82 => "澳门", 91 => "国外 "];
        $tip = "";
        $match = "/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/";
        $pass = true;
        if (!$card || !preg_match($match, $card)) {
            //身份证格式错误
            $pass = false;
        } else if (!$city[substr($card, 0, 2)]) {
            //地址错误
            $pass = false;
        } else {
            //18位身份证需要验证最后一位校验位
            if (strlen($card) == 18) {
                $card = str_split($card);
                //∑(ai×Wi)(mod 11)
                //加权因子
                $factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
                //校验位
                $parity = [1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2];
                $sum = 0;
                $ai = 0;
                $wi = 0;
                for ($i = 0; $i < 17; $i++) {
                    $ai = $card[$i];
                    $wi = $factor[$i];
                    $sum += $ai * $wi;
                }
                $last = $parity[$sum % 11];
                if ($parity[$sum % 11] != $card[17]) {
                    //$tip = "校验位错误";
                    $pass = false;
                }
            } else {
                $pass = false;
            }
        }
        if (!$pass) return false;/* 身份证格式错误*/
        return true;/* 身份证格式正确*/
    }

    /**
     * URL地址验证
     * @param string $link
     * @return false|int
     */
    public static function CheckURL(string $link)
    {
        return preg_match("/^(http|https|ftp):\/\/[A-Za-z0-9\-]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\’:+!]*([^<>\”])*$/", $link);
    }

    /**
     * 邮箱地址验证
     * @param $email
     * @return false|int
     */
    public static function CheckEmail($email)
    {
        return preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $email);
    }

    /**
     * 手机号验证
     * @param $phone
     * @return false|int
     */
    public static function CheckPhone($phone)
    {
        return preg_match("/^1[3456789]\d{9}$/", $phone);
    }

}
