<?php

function _url($str){
	return './?o=' . urlencode($str);
}

function dd($arr){
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
	exit;
}