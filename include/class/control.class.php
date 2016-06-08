<?php
class Control {
	
	function __construct(){
		
	}
	
	function __destruct(){
		
	}
	
	function jLoad($arr){
		$html = '';
		$html.= '<script>$(function(){';
		foreach($arr as $key=>$item){
			$html.= '$("' . $key . '").load("./?m=' . $item . '");';
		}
		$html.= '});</script>';
		
		echo $html;
	}
	
	function make($module){
		global $cfg_title;
		global $cfg_brand;
		
		global $cfg_mod;
		global $cfg_nav;
		
		global $database;
		global $mailbase;
		
		
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
	
	function index(){
		$this->sys_index();
	}
	
	function sys_index(){
		if(isset($_SESSION['auth']) && isset($_SESSION['user_id'])){
			$this->jLoad( array('#header'=>'sys_header',
								'#main'=>'sys_intro',
								'#nav'=>'sys_nav',
								'#footer'=>'sys_footer'));
		}else{
			$this->jLoad( array('#main'=>'sys_login'));
			session_destroy();
		}
	}
}

?>