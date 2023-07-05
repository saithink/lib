<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace saithink\lib;

/**
 * AES加密类
 */
class Aes
{
    /**
     * AES 加密
     * @param $encrypt_data
     * @param $key
     * @param $iv
     * @param $method
     * @return false|string
     */
    public static function opensslEncrypt($encrypt_data, $key = '', $iv = 'SAITHINKVIPFRAME', $method = 'AES-128-CBC')
    {
        $encrypt = openssl_encrypt($encrypt_data, $method, $key, 0, $iv);
        return $encrypt;
    }

    /**
     * AES 解密
     * @param $decrypt_data
     * @param $key
     * @param $iv
     * @param $method
     * @return false|string
     */
    public static function opensslDecrypt($decrypt_data, $key = '', $iv = 'SAITHINKVIPFRAME', $method = 'AES-128-CBC')
    {
        $decrypt = openssl_decrypt($decrypt_data, $method, $key, 0, $iv);
        return $decrypt;
    }

}