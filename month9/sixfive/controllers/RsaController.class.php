<?php
namespace controllers;

class RsaController
{

    public function Openssl()
    {
        $conf = [
            "config"=>"D:\phpStudy\Apache\conf\openssl.cnf",
            "private_key_bits"=>2048
        ];
        //生成资源
        $openssl = openssl_pkey_new($conf);
        //生成私钥
        openssl_pkey_export($openssl,$privatekey,null,$conf);
        //生成公钥
        $publickey = openssl_pkey_get_details($openssl)['key'];

        //使用私钥加密
        openssl_private_encrypt("12345",$encrypt,$privatekey);
        $privatedata = base64_encode($encrypt);

        //使用公钥解密
        openssl_public_decrypt($encrypt,$decrypt,$publickey);
        var_dump($decrypt);
    }
    public function Rsa()
    {
        list($publicKey,$privateKey) = $this->Rsas();

        var_dump($publicKey,$privateKey);die;

        $encrypt = $this->rsaEncrypt("3",$publicKey);
        var_dump("这是加密的数据  $encrypt");
        $decrypt = $this->rsaDecrypt($encrypt,$privateKey);
        var_dump("这是解密的数据  $decrypt");

    }
    //
    protected function Rsas(){
        //1.定义一个 p 、 q
        $p = $this->createPrime();
        $q = $this->createPrime();
        $N = $p * $q;

        $num = ($p-1)*($q-1);
        // 计算($p-1)*($q-1)
        while(true){
            $publicKey = mt_rand(2,$num-1);
            if($this->isPrimePair($publicKey,$num)){
                break;
            }
        }
        $privateKey = $this->getPrivateKey($num,$publicKey);

        return [[$N,$publicKey],[$N,$privateKey]];
    }

    //生成质数 p q
    public function createprime()
    {
        while(true){
            $key = mt_rand(2,10);
            if($this->isPrime($key)){
                break;
            }
        }
        return $key;
    }
    // 判断一个数字是否为质数
    protected function isPrime($value){
        $is = true;
        for($i=2;$i<=floor($value/2);$i++){
            if($value%$i == 0){
                $is = false;
                break;
            }
        }
        return $is;
    }

    //判断两个值是否都为质数
    protected function isPrimePair($value1,$value2){
        $is = true;
        $min = min($value1,$value2);
        for($i=2;$i<=$min;$i++){
            if($value1%$i == 0 && $value2%$i==0){
                $is = false;
                break;
            }
        }
        return $is;
    }

    //获取私钥
    protected function getPrivateKey($N,$publicKey){

        for($privateKey=2;;$privateKey++){
            $product = gmp_mul($privateKey,$publicKey);
            if( gmp_mod($product,$N) == 1){
                break;
            }
        }
        return $privateKey;
    }

    //生成私钥
    protected function rsaEncrypt($data,$key){
        $res = gmp_strval(gmp_pow($data,$key[1]));

        return gmp_strval(gmp_mod($res,$key[0]));
    }

    //生成公钥
    protected function rsaDecrypt($data,$key){
        $res = gmp_strval(gmp_pow($data,$key[1]));

        return gmp_strval(gmp_mod($res,$key[0]));
    }
}