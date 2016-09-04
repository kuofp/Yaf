<?php
class Control {
	
	protected $act;
	
	function __construct(){
		$this->act = isset($_REQUEST['m'])? $_REQUEST['m']: 'index';
	}
	
	function __destruct(){
		
	}
	
	function make(){
		
		global $cfg_title;
		global $cfg_brand;
		
		global $cfg_mod;
		global $cfg_nav;
		
		global $database;
		global $mailbase;
		
		// Reduce session lock
		session_start();
		switch($this->act){
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
		if(isset($cfg_mod[$this->act]) && file_exists($cfg_mod[$this->act])){
			require $cfg_mod[$this->act];
		}
		// Call method
		if(method_exists($this, $this->act)){
			$this->{$this->act}();
		}
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