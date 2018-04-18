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
		
		$arr = preg_split('/[\(\)]+/', $namespace);
		$key = $arr[1] ?? $arr[0];
		$cls = $arr[0] ?? 0;
		
		if($di['obj'][$key] ?? 0){
			// obj exist
		}else if($cls){
			// class_name(alias) e.g. \Medoo\Medoo(db)
			$di['obj'][$key] = new $cls($arg);
		}
		
		return $di['obj'][$key] ?? null;
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
}