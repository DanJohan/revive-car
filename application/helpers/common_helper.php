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
