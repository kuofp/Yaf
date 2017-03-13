<?php

class Box{
	
	protected $obj;
	protected $val;
	protected static $str = 'unique_di_name';
	
	public static function init(){
		
		$str = self::$str;
		
		global $$str;
		
		$di = &$$str;
		
		if(!$di){
			$GLOBALS[(self::$str)] = array(
				'obj' => array(),
				'val' => array(),
			);
		}
	}
	
	public static function obj($namespace, $arg = '', $option = ''){
		
		self::init();
		
		$str = self::$str;
		global $$str;
		$di = &$$str;
		
		if($di['obj'][$namespace] ?? 0){
			// obj exist
		}elseif(method_exists('Box', $namespace)){
			$di['obj'][$namespace] = self::$namespace($arg);
		}else{
			$di['obj'][$namespace] = new $namespace($arg);
		}
		
		return $di['obj'][$namespace];
	}
	
	public static function val($key, $val = ''){
		
		self::init();
		
		$str = self::$str;
		global $$str;
		$di = &$$str;
		
		if(func_num_args() == 1){
			return $di['val'][$key] ?? '';
		}else{
			$di['val'][$key] = $val;
			return 0;
		}
	}
	
	public static function all(){
		
		self::init();
		
		$str = self::$str;
		global $$str;
		$di = &$$str;
		
		return $di['val'];
	}
	
	public static function mail($arr){
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
	
	public static function db($arr){
		return new Medoo\Medoo($arr);
	}
}