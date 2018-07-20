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
