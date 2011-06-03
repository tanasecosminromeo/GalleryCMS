<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('generate_random_code'))
{
function generate_random_code() {
		$cons = "bcdfghjklmnpqrstvwxyz";
		$vocs = "aeiou";
		for ($x=0; $x < 6; $x++) {
			mt_srand ((double) microtime() * 1000000);
			$con[$x] = substr($cons, mt_rand(0, strlen($cons)-1), 1);
			$voc[$x] = substr($vocs, mt_rand(0, strlen($vocs)-1), 1);
		}
		mt_srand((double)microtime()*1000000);
		$num1 = mt_rand(0, 9);
		$num2 = mt_rand(0, 9);
		$makecode = $con[0] . $voc[0] .$con[2] . $num1 . $num2 . $con[3] . $voc[3] . $con[4];
		return($makecode);
	}
}
