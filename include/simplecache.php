<?php
//Source : http://php-html.net/tutorials/creating-a-simple-php-cache-script/
class simplecache {
	private $cacheDir='cache';  
   
        public function get($key,$check) {  
	       $filename_cache = $this->cacheDir . '/' . $key . '.cache'; //Cache filename  
	       $filename_info = $this->cacheDir . '/' . $key . '.info'; //Cache info  
   
		if (file_exists($filename_cache) && file_exists($filename_info)) {  
		         $chk_old = file_get_contents ($filename_info); //Last update time of the cache file  
			 if ($check == $chk_old) {//Compare last updated and current check some  
			    return file_get_contents ($filename_cache);   //Get contents from file  
			 }  
		}  
   		return null;
	}  
        
     public function put($key, $content,$check)  
     {  
 $filename_cache = $this->cacheDir . '/' . $key . '.cache'; //Cache filename  
     $filename_info = $this->cacheDir . '/' . $key . '.info'; //Cache info  
   
     file_put_contents ($filename_cache ,  $content); // save the content  
     file_put_contents ($filename_info , $check); 
     }  
 }  
?>
