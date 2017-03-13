<?php

class Lang{
	
	protected $val;
	
	function __construct(){
		
		$this->val = array(
			'繁體中文'   => 'zh_TW',
			'简体中文'   => 'zh_CN',
			'English'    => 'en',
			/*
			'日本語'     => 'ja',
			'한글'         => 'ko',
			'ภาษาไทย'      => 'th',
			'tiếng Việt' => 'vi',
			'Melayu'     => 'ms_MY',
			'Español'    => 'es',
			'Indonesia'  => 'id',
			'русский'    => 'ru',
			*/
		);
	}
	
	public function init($lang = ''){
		
		$lang = ($lang)?: ($_REQUEST['lang'] ?? $_COOKIE['lang'] ?? '');
		
		if(!in_array($lang, $this->val)){
			$lang = 'zh_TW';
		}
		
		setcookie('lang', $lang, time() + (86400 * 30), '/');
		
		return $lang;
	}
	
	public function set($lang = ''){
		
		$lang = $this->init($lang);
		
		putenv('LANG=' . $lang);
		setlocale(LC_ALL, $lang . '.utf8');
		bindtextdomain('admin', __DIR__ . '/../../public/locale');
		textdomain('admin');
	}
	
	public function get(){
		
		$lang = $this->init();
		
		$result = array();
		foreach($this->val as $k=>$v){
			$result[] = array('text'=>$k, 'value'=>$v, 'selected'=>($lang == $v? 'selected': ''));
		}
		
		return $result;
	}
}