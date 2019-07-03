<?php
namespace controllers;
use sixfive\Http;
use libs\Log;
class FontController
{
    public function Display(){
        if(request()->header("Referer") !== "http://www.1810b.com/index.php?c=front&a=header"){
            exit("deny access");
        }
        var_dump($this->user);
    }

    public function Header()
    {
        require_once "../views/header.html";
    }

    public function Text()
    {
        $res = Http::postHttp("http://www.1810.com/index.php?c=font&a=display",["noncestr"=>'L3m1vyi8ZzaPtwcDeoAl',"timestamp"=>"1561115035","sign"=>"a2e07840ffca530da75cf69511d3897aefd86c57"],false,["Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOlsiYXVkaWVuY2VfMSIsImF1ZGllbmNlXzIiXSwiZXhwIjoxNTYxMTIyMTUxLCJpYXQiOjE1NjExMTQ5NTEsImlzcyI6InN1bmxvbmdsb25nIiwianRpIjoiMSIsIm5iZiI6MTU2MTExNDk1MSwic3ViIjoiaHR0cDpcL1wvd3d3LjE4MTBiLmNvbSIsInVzZXJfaWQiOiIxIn0.AxG7AMP6z3-y9SphdZX9w9DR_Az9noioZnQ5_FpdZwI","x-api-token: lening"]);
        var_dump($res);
    }

    public function Hash()
    {
        echo $aaa;
//        Log::getInstance()->info("this is a text");
//        echo 111;
        //setLog("myapp","this is a text",['username'=>"zhangsan",'sex'=>15]);
    }

}