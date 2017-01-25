<?php

function _url($str){
	return './?m=' . urlencode($str);
}

function dd($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
	exit;
}