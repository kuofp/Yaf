<?php

class Control {
	
	protected $act;
	
	function __construct(){
		
		$this->act = $_REQUEST['m'] ?? 'index';
	}
	
	function __destruct(){
		
	}
	
	function make(){
		
		global $di;
		
		$cfg_mod  = $di->val('cfg_mod');
		
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
		
		if(class_exists($this->act)){
			// new obj directly
			$c = $this->act;
			return new $c;
			
		}elseif(class_exists($cfg_mod[$this->act] ?? '')){
			// new obj via module table
			return new $cfg_mod[$this->act];
			
		}elseif(file_exists($cfg_mod[$this->act] ?? '')){
			// include file
			require $cfg_mod[$this->act];
		}
	}
}