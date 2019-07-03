<?php
namespace controllers;

class CryptController
{
    public function Hash()
    {
        //散列 hash 单向  【 md5 】
        //第二参数为true时 加密后的字符串长度为16的原格式   string(16) "�|��plL4�h��N{"
        $md5 = md5('12345',true);
        //第二参数为false时 加密后的字符串长度为32的字符串   string(32) "827ccb0eea8a706c4c34a16891f84e7b"
        $md52 = md5('12345',false);
        // md5_file   计算指定文件的 MD5 散列值
        $md5_file = md5_file('./322368.jpg',true);//16位原始值
        $md5_file2 = md5_file('./322368.jpg',false);//32位字符串
        var_dump($md5,$md52,$md5_file,$md5_file2);
        var_dump("----------------------------------------------------------------------------------------------------");

        //【 sha1 】 加密  true时为20位原始值 false为40位的字符串
        $sha1_1 = sha1("12345",true);
        $sha1_2 = sha1("12345",false);
        $sha1_file_1 = sha1_file("./322368.jpg",true);
        $sha1_file_2 = sha1_file("./322368.jpg",false);

        var_dump($sha1_1,$sha1_2,$sha1_file_1,$sha1_file_2);
        var_dump("----------------------------------------------------------------------------------------------------");

        //【 hash 】 hash_hmac 生成带有密钥的哈希值
        $hash_hmac = hash_hmac('sha256','12345','1810b');
        var_dump($hash_hmac);
        //支持的哈希算法列表
//        var_dump(hash_hmac_algos());

        //单向字符串散列  最多13个字符
        $crypt = crypt('12345','abcdefghigklmnopqrstuvwxyz');
        var_dump($crypt);

        //验证密文是否是明文加密后的
        $res = hash_equals($crypt,crypt('12345',$crypt));
        var_dump($res);

        //生成随机的加密安全的伪加密字节
        $rand = random_bytes(10);
        var_dump($rand);

        //生成随机的整数
        $rand2 = random_int(1,10);
        var_dump($rand2);

        //使用异或加密
        $key = "1810b";
        $arr = "sll";
        $res = $arr ^ $key;
        var_dump($res);
        //解密
        $sss = $res ^ $key;
        //获取可用的密码方法
//        var_dump(openssl_get_cipher_methods());

//        var_dump("－－－这是对称加密DES-ECB模式演示－－－");
//
//        $encrypt = $this->encryptECB('12345','this is a dog');
//        var_dump($encrypt);
//
//        var_dump("－－－这是对称解密DES-ECB模式演示－－－");
//        $decrypt = $this->decryptECB($encrypt,'this is a dog');
//        var_dump($decrypt);

        $iv = bin2hex(createRendstring(8));

//        var_dump("－－－这是对称加密DES-CBC模式演示－－－");
//
//        $encrypt = $this->encryptCBC('12345','this is a dog',$iv);
//        var_dump($encrypt);
//
//        var_dump("－－－这是对称解密DES-CBC模式演示－－－");
//        $decrypt = $this->decryptCBC($encrypt,'this is a dog',$iv);
//        var_dump($decrypt);

        var_dump("－－－这是对称加密AES-ECB模式演示－－－");

        $encrypt = $this->encryptAESEBC('1234567','this is a dog');
        var_dump($encrypt);

        var_dump("－－－这是对称解密AES-ECB模式演示－－－");
        $decrypt = $this->decryptAESEBC($encrypt,'this is a dog');
        var_dump($decrypt);

        var_dump("－－－这是对称加密AES-CBC模式演示－－－");

        $encrypt = $this->encryptAES('123456','this is a dog',$iv);
        var_dump($encrypt);

        var_dump("－－－这是对称解密AES-CBC模式演示－－－");
        $decrypt = $this->decryptAES($encrypt,'this is a dog',$iv);
        var_dump($decrypt);

        var_dump("－－－这是对称加密3DES-CBC模式演示－－－");
        $encrypt = $this->encrypt3DES('123456','this is a dog',$iv);
        var_dump($encrypt);

        var_dump("－－－这是对称解密3DES-CBC模式演示－－－");
        $decrypt = $this->decrypt3DES($encrypt,'this is a dog',$iv);
        var_dump($decrypt);


    }
    //对称加密DES-ECB模式
    public function encryptECB($data='',$key='')
    {
        return openssl_encrypt($data,'DES-CBC',$key);
    }
    //对称解密DES-ECB模式
    public function decryptECB($data='',$key='')
    {
        return openssl_decrypt($data,'DES-CBC',$key);
    }

    //对称加密DES-CBC模式
    public function encryptCBC($data='',$key='',$iv='')
    {
        return openssl_encrypt($data,'DES-CBC',$key,0,$iv);
    }
    //对称解密DES-CBC模式
    public function decryptCBC($data='',$key='',$iv='')
    {
        return openssl_decrypt($data,'DES-CBC',$key,0,$iv);
    }

    //对称加密AES-ECB模式
    public function encryptAESEBC($data='',$key='')
    {
        return openssl_encrypt($data,'AES-128-ECB',$key);
    }
    //对称解密AES-ECB模式
    public function decryptAESEBC($data='',$key='')
    {
        return openssl_decrypt($data,'AES-128-ECB',$key);
    }

    //对称加密AES-CBC模式
    public function encryptAES($data='',$key='',$iv='')
    {
        return openssl_encrypt($data,'AES-128-CBC',$key,0,$iv);
    }
    //对称解密AES-CBC模式
    public function decryptAES($data='',$key='',$iv='')
    {
        return openssl_decrypt($data,'AES-128-CBC',$key,0,$iv);
    }

    //对称加密3DES-CBC模式
    public function encrypt3DES($data='',$key='',$iv='')
    {
        return openssl_encrypt($data,'AES-128-CBC',$key,0,$iv);
    }
    //对称解密3DES-CBC模式
    public function decrypt3DES($data='',$key='',$iv='')
    {
        return openssl_decrypt($data,'AES-128-CBC',$key,0,$iv);
    }
}