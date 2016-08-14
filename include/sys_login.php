<?php
header('P3P: CP="CAO PSA OUR"'); // Damn frameset on IE!!!!!!!
$obj = new Auth();

if(method_exists($obj, $obj->act)){
	$obj->{$obj->act}();
	exit;
}
