<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




if(!function_exists('checkdnsrr')){
    function checkdnsrr($host, $type=''){
        if(!empty($host)){
            $type = (empty($type)) ? 'MX' :  $type;
            exec('nslookup -type='.$type.' '.escapeshellcmd($host), $result);
            $it = new ArrayIterator($result);
            foreach(new RegexIterator($it, '~^'.$host.'~', RegexIterator::GET_MATCH) as $result){
                if($result){
                    return true;
                }               
            }
        }
        return false;
    }
}





if(!function_exists('domain_exists')){
function domain_exists($email,$record = 'MX')
{
	list($user,$domain) =	explode('@', $email);
	return checkdnsrr($domain,$record);
}

}