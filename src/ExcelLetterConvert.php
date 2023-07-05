<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace saithink\lib;

/**
 * Excel列转换
 * Class ExcelLetterConvert
 * @package saithink\lib
 */
class ExcelLetterConvert
{
    const BIN_DATA = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    const DEC_DATA = [
        'A' => 1,
        'B' => 2,
        'C' => 3,
        'D' => 4,
        'E' => 5,
        'F' => 6,
        'G' => 7,
        'H' => 8,
        'I' => 9,
        'J' => 10,
        'K' => 11,
        'L' => 12,
        'M' => 13,
        'N' => 14,
        'O' => 15,
        'P' => 16,
        'Q' => 17,
        'R' => 18,
        'S' => 19,
        'T' => 20,
        'U' => 21,
        'V' => 22,
        'W' => 23,
        'X' => 24,
        'Y' => 25,
        'Z' => 26,
    ];



    /***
     * 十进制转换字母 702 => (ZZ)
     * @param int $num 需要转换的数字
     * @param int $bin 进制(字母数组转化 26)
     * @return string
     */
    public static function decToChar($num, $bin = 26)
    {
        if ($num === 0) return $num;
        $arr = self::BIN_DATA;
        if ($bin == 10) return $num; //相同进制忽略
        $t = "";
        while ($num > 0) {
            if ($num % $bin === 0) {
                $t = $arr[$bin - 1] . $t;
                $num = $num / $bin - 1;
            } else {
                $t = $arr[$num % $bin - 1] . $t;
                $num = floor($num / $bin);
            }
        }
        return $t;
    }

    /***
     * 字母转换成十进制 (ZZ) => 702
     * @param string $char
     * @param int $bin 进制(字母数组转化 26)
     * @return int
     */
    public static function charToDec($char, $bin = 26)
    {
        $arr = self::DEC_DATA;
        if ($bin == 10) return $char; //为10进制不转换
        $atnum = str_split($char); //将字符串分割为单个字符数组
        $atlen = count($atnum);
        $total = 0;
        $i = 1;
        foreach ($atnum as $tv) {
            $tv = strtoupper($tv);
            if (array_key_exists($tv, $arr)) {
                if ($arr[$tv] == 0) continue;
                $total = $total + $arr[$tv] * pow($bin, $atlen - $i);
            }
            $i++;
        }
        return $total;
    }
}
