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

if( ! function_exists('array_column_multi')) {
    function array_column_multi(array $input, array $column_keys) {
       // dd($input,false);
      //  dd($column_keys);
        $result = array();
        $column_keys = array_flip($column_keys);
        foreach($input as $key => $el) {
            $result[$key] = array_intersect_key($el, $column_keys);
        }
            return $result;
    }
}

if(! function_exists('array_filter_by_value')) {
    function array_filter_by_value($my_array, $index, $value)
    { 
        if(is_array($my_array) && count($my_array)>0)  
        { 
            $new_array=array();
            foreach(array_keys($my_array) as $key){ 
                $temp[$key] = $my_array[$key][$index]; 
                 
                if ($temp[$key] != $value){ 
                    $new_array[$key] = $my_array[$key]; 
                } 
            } 
        } 
        return $new_array; 
    } 
}

if (!function_exists('array_group_by')) {
    
    function array_group_by(array $array, $key)
    {
        if (!is_string($key) && !is_int($key) && !is_float($key) && !is_callable($key) ) {
            trigger_error('array_group_by(): The key should be a string, an integer, or a callback', E_USER_ERROR);
            return null;
        }
        $func = (!is_string($key) && is_callable($key) ? $key : null);
        $_key = $key;
        // Load the new array, splitting by the target key
        $grouped = [];
        foreach ($array as $value) {
            $key = null;
            if (is_callable($func)) {
                $key = call_user_func($func, $value);
            } elseif (is_object($value) && isset($value->{$_key})) {
                $key = $value->{$_key};
            } elseif (isset($value[$_key])) {
                $key = $value[$_key];
            }
            if ($key === null) {
                continue;
            }
            $grouped[$key][] = $value;
        }
        // Recursively build a nested grouping if more parameters are supplied
        // Each grouped array value is grouped according to the next sequential key
        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $params = array_merge([ $value ], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $params);
            }
        }
        return $grouped;
    }
}

