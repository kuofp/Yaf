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
	
	public static function db($arr){
		return new Medoo\Medoo($arr);
	}
}