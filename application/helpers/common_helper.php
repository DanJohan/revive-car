<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('dd'))
{
    function dd($data,$dump=true)
    {
        if(is_array($data)){
        	echo "<pre>",print_r($data),"</pre>";
        }else{
        	echo $data;
        }
        if($dump){
        	exit; 
        }
    }   
} 

if ( ! function_exists('generate_otp'))
{
    function generate_otp($digits = 4)
    {
        return rand(pow(10, $digits - 1) - 1, pow(10, $digits) - 1);
    }   
}


if( ! function_exists('randomString')) {
    function randomString($length = 6) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}
