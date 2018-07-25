<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('generate_otp'))
{
    function generate_otp($digits = 4)
    {
        return rand(pow(10, $digits - 1) - 1, pow(10, $digits) - 1);
    }   
}

if ( ! function_exists('getRandomString'))
{
	function getRandomString($length=5) 
	{

	    $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWZYZ";

	    $real_string_length = strlen($characters) ;     
	    $string='';
	    for ($p = 0; $p < $length; $p++) 
	    {
	        $string .= $characters[mt_rand(0, $real_string_length-1)];
	    }

	    return strtolower($string);
	}
}
