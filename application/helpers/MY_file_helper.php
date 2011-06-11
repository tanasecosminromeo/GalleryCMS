<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('delete_directory'))
{
function delete_directory($dirname) {
   if (is_dir($dirname))
      $dir_handle = opendir($dirname);
   if (!$dir_handle)
      return false;
   while($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
         if (!is_dir($dirname."/".$file))
            unlink($dirname."/".$file);
         else
            delete_directory($dirname.'/'.$file);    
      }
   }
   closedir($dir_handle);
   rmdir($dirname);
   return true;
}

}




if ( ! function_exists('create_directory'))
{

/**
 * php at msn dot net 
 *
 * Makes directory and returns BOOL(TRUE) if exists OR made.
 *
 * @param  $path Path name
 * @return bool
 */

function create_directory($pathname, $mode = 0755, $rec = true) {
	$pathname =  preg_replace('/(\/){2,}|(\\\){1,}/','/',$pathname); //only forward-slash
	
	 return is_dir($pathname) || @mkdir($pathname, $mode, $rec);
}


}

 





