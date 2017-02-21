<?php

class Box{
	
	protected $obj;
	protected $val;
	
	function __construct(){
		
		$this->obj = [];
		$this->val = [];
		
	}
	
	public function obj($namespace, $arg = '', $option = ''){
		
		if($this->obj[$namespace] ?? 0){
			// obj exist
		}elseif(method_exists($this, $namespace)){
			$this->obj[$namespace] = $this->$namespace($arg);
		}else{
			$this->obj[$namespace] = new $namespace($arg);
		}
		
		return $this->obj[$namespace];
	}
	
	public function val($key, $val = ''){
		if(func_num_args() == 1){
			return $this->val[$key] ?? '';
		}else{
			$this->val[$key] = $val;
			return $this;
		}
	}
	
	public function all(){
		return $this->val;
	}
	
	function mail($arr){
		$mail = new PHPMailer;
		if($arr['isSMTP']){
			$mail->isSMTP();                                  // Set mailer to use SMTP
			$mail->Host = $arr['Host'];                       // Specify main and backup SMTP servers
			$mail->SMTPAuth = $arr['SMTPAuth'];               // Enable SMTP authentication
			$mail->Username = $arr['Username'];               // SMTP username
			$mail->Password = $arr['Password'];               // SMTP password
			$mail->SMTPSecure = $arr['SMTPSecure'];           // Enable TLS encryption, `ssl` also accepted
			$mail->Port = $arr['Port'];                       // TCP port to connect to
			$mail->isHTML($arr['isHTML']);                    // Set email format to HTML
		
			//http://www.weste.net/2013/7-17/92746.html  yahoo failed issue
			$mail->CharSet = $arr['CharSet'];
			
			$mail->FromName = "=?UTF-8?B?". base64_encode($arr['FromName'])."?=";
		}else{
			
		}
		
		return $mail;
	}
	
	function db($arr){
		return new Medoo\Medoo($arr);
	}
}