<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace saithink\lib;

class Rsa
{
    private $publicKey  = '';

    private $privateKey = '';

    /**
     * 构造函数
     */
    public function __construct($publicKey, $privateKey)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    /**
     * 获取私钥
     * @return bool|resource
     */
    private function getPrivateKey()
    {
        return openssl_pkey_get_private($this->privateKey);
    }

    /**
     * 获取公钥
     * @return bool|resource
     */
    private function getPublicKey()
    {
        return openssl_pkey_get_public($this->publicKey);
    }

    /**
     * 解密【私钥解密】
     */
    public function privateDecrypt($encrypted = '')
    {
        $privateKey = $this->getPrivateKey(); // 获取私钥
        $key = openssl_pkey_get_private($privateKey); //解析私钥
        $encrypted = base64_decode($encrypted);
        //解密
        $mydata = openssl_private_decrypt($encrypted, $decrypted, $key) ? $decrypted : null;
        return $mydata;
    }

    /**
     * 加密【公钥加密】
     */
    public function publicEncrypt($data = '')
    {
        $publicKey = $this->getPublicKey(); // 获取公钥
        $key = openssl_pkey_get_public($publicKey); //解析公钥
        $rs = openssl_public_encrypt($data, $encrypted, $key) ? base64_encode($encrypted) : null;
        return $rs;
    }
}
