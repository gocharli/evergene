<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('slug'))
{
	function slug($str)
	{
		if($str!='')
		{
			return url_title($str,'-',true);
		}
		else
		{
			return '';
		}
	}
}
if(!function_exists('clean_string'))
{
function clean_string($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string=preg_replace('/[^A-Za-z0-9\-]/', '', $string);
   $string = str_replace('-', ' ', $string);
   return $string; // Removes special chars.
}
}
if(!function_exists('dateDiff'))
{
	function dateDiff($d1,$d2){
		$date1=strtotime($d1);
		$date2=strtotime($d2);
		$seconds = $date1 - $date2;
		$weeks = floor($seconds/604800);
		$seconds -= $weeks * 604800;
		$days = floor($seconds/86400);
		$seconds -= $days * 86400;
		$hours = floor($seconds/3600);
		$seconds -= $hours * 3600;
		$minutes = floor($seconds/60);
		$seconds -= $minutes * 60;
		$months=round(($date1-$date2) / 60 / 60 / 24 / 30);
		$years=round(($date1-$date2) /(60*60*24*365));
		$diffArr=array("Seconds"=>$seconds,
			"minutes"=>$minutes,
			"Hours"=>$hours,
			"Days"=>$days,
			"Weeks"=>$weeks,
			"Months"=>$months,
			"Years"=>$years
		) ;
		return $diffArr;
	}
}
if ( ! function_exists('age'))
{
	function age($dob)
	{
		if($dob!='0000-00-00' && $dob!='')
		{
			$from = new DateTime($dob);
			$to   = new DateTime('today');
			return $from->diff($to)->y;
		}
		else
		{
			return 0;
		}
	}
}
if ( ! function_exists('num_format'))
{
	function number_point_format($number,$point)
	{

		return number_format((float)$number, $point, '.', '');

	}
}
if ( ! function_exists('valid_name')){
	function valid_name($str)
	{
		if(!preg_match("/^[a-zA-Z\s]+$/",$str))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}
if ( ! function_exists('price_format')){
   function price_format($number)
   {
         return floor($number);

   }
}
if ( ! function_exists('current_datetime')){
	function current_datetime()
	{
		return date('Y-m-d H:i:s');

	}
}
if (!function_exists('format_datetime')){
   function format_datetime($datetime)
   {
     if($datetime!='' && $datetime!='0000-00-00 00:00:00')
     {
        return date('m-d-Y h:i a',strtotime($datetime));
     }
     else
     {
        return '';
     }
      
   }
}

if (!function_exists('format_date')){
   function format_date($date)
   {
     if($date!='' && $date!='0000-00-00 00:00:00')
     {
        return date('m-d-Y',strtotime($date));
     }
     else
     {
        return '';
     }
      
   }
}

if ( ! function_exists('short_text')){
   function short_text($text, $chars_limit)
   {
          // Check if length is larger than the character limit
        if (strlen($text) > $chars_limit)
        {
            // If so, cut the string at the character limit
            $new_text = substr($text, 0, $chars_limit);
            // Trim off white space
            $new_text = trim($new_text);
            // Add at end of text ...
            return $new_text . "...";
        }
        // If not just return the text as is
        else
        {
        return $text;
        }
   }
}
if ( ! function_exists('percentage_discount')){
   function percentage_discount($org_price, $discount_percent)
   {
       if($discount_percent>0)
       {
         $total= $org_price - ($org_price * ($discount_percent / 100));
         return number_format($total,2);
       }
       else
       {
          return $org_price;
       }
   }
}
if(!function_exists('time_elapsed_string')){
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
}
if(!function_exists('randomString')){
function randomString() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
    }
}
if(!function_exists('drandomString')){
function drandomString($str) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $str; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
    }
}
if(!function_exists('random_username')){
    function random_username($string) {
    
    $firstPart = strtolower($string);
    
    $nrRand = rand(100, 999);
    
    $username = trim($firstPart).trim($nrRand);
    return $username;
    }
}
if(!function_exists('random_phone_code')){
    function random_phone_code() {   
    
    $nrRand = rand(1111, 9999);    
    $code = trim($nrRand);
    return $code;
    }
}

if(!function_exists('otp_generate')){
    function otp_generate($value=7) 
    {   
        $string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string_shuffled = str_shuffle($string);
        $password = substr($string_shuffled, 1, $value);
        return $password;
    }
}
?>
