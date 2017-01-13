<?php
namespace Plugin;

class Excel{
	
	function __construct(){
		$filename="Export_".date("YmdHis").".xls";         // 建立檔名
		header("Content-type:application/vnd.ms-excel; "); // 送出header
		header("Content-Disposition:filename=$filename");  // 指定檔名
		echo $_POST['data'];
	}
}