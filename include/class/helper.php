<?php

function _url($str){
	return './?m=' . urlencode($str);
}

if(!function_exists('dd')){
	function dd($arr){
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
		exit;
	}
}
