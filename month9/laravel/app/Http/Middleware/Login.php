<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;

class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $key = '1810b';
        $data = $request->all();

        $info = User::where(['tel'=>$data['tel']])->first();

        $sign = openssl_decrypt(json_encode($data),'DES-ECB',$key);
//        dd($sign);
        if($sign !== session('sign')){
            return response(['error'=>'签名不正确']);
        }
        return $next($request);
    }
}
