<?php
namespace Plugin;

class Files{
	
	function __construct(){
		
		$method = $_GET['method'] ?? 'upload';
		
		return $this->$method();
	}
	
	public function upload(){
		$result = array();
		
		$files = $_FILES ?? array();
		$a = [];
		foreach($files as $file){
			// {"name":"new 2.txt","type":"text\/plain","tmp_name":"\/tmp\/phpRJ91Ks","error":0,"size":1295}
			$url = 'upload/' . md5(time() . rand());
			$result[] = array('url' => $url, 'name' => $file['name'], 'size' => $file['size']);
			move_uploaded_file($file['tmp_name'], $url);
		}
		
		echo json_encode($result);
	}
	
	public function download(){
		
		if($_GET['name'] && $_GET['url']){
			header('Content-Disposition: attachment; filename="' . $_GET['name'] . '"');
			readfile($_GET['url']);
		}
	}
}