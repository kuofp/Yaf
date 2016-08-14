<?php
class Control {
	
	function __construct(){
		
	}
	
	function __destruct(){
		
	}
	
	function make(){
		$module = $this->get('m')?:'index';
		
		global $cfg_title;
		global $cfg_brand;
		
		global $cfg_mod;
		global $cfg_nav;
		
		global $database;
		global $mailbase;
		
		// Reduce session lock
		session_start();
		switch($module){
			case 'sys_login':
			case 'sys_index':
			case 'index':
				// Write session
				break;
			default:
				session_write_close();
				break;
		}
		
		
		// Include file
		if(isset($cfg_mod[$module]) && file_exists($cfg_mod[$module])){
			require $cfg_mod[$module];
		}
		// Call method
		if(method_exists($this, $module)){
			$this->{$module}();
		}
	}
	
	function get($key){
		return isset($_GET[$key])? $_GET[$key]: '';
	}
	
	function newMedoo($arr){
		return new medoo($arr);
	}
	
	function newPHPMailer($arr){
		$mail = new PHPMailer;
		if($arr['isSMTP']){
			$mail->isSMTP();                                  // Set mailer to use SMTP
			$mail->Host = $arr['Host'];                       // Specify main and backup SMTP servers
			$mail->SMTPAuth = $arr['SMTPAuth'];               // Enable SMTP authentication
			$mail->Username = $arr['Username'];               // SMTP username
			$mail->Password = $arr['Password'];               // SMTP password
			$mail->SMTPSecure = $arr['SMTPSecure'];           // Enable TLS encryption, `ssl` also accepted
			$mail->Port = $arr['Port'];                       // TCP port to connect to
			
			$mail->isHTML($arr['isHTML']);                              // Set email format to HTML
		
			//http://www.weste.net/2013/7-17/92746.html  yahoo failed issue
			$mail->CharSet = $arr['CharSet'];
			
			$mail->FromName = "=?UTF-8?B?". base64_encode($arr['FromName'])."?=";
		}else{
			
		}
		
		return $mail;
	}
	
}

?>