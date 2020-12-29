<?php
namespace Sys;

class Index{
	
	function __construct()
	{
		$tpl = new \Yatp(__DIR__ . '/admin.html');
		
		$html = $tpl->block('index');
		
		$lang = [];
		foreach(\Box::val('lang')['list'] as $k=>$v){
			$lang[] = [
				'text' => $v,
				'value' => $k,
				'selected' => ((\Box::val('lang')['default']) == $k? 'selected': ''),
			];
		}
		$lang = $tpl->block('lang')->assign(['option' => $tpl->block('lang.option')->nest($lang)]);
		
		if(isset($_SESSION['auth']) && isset($_SESSION['user'])){
			$html->assign([
				'header' => '',
				'nav' => $tpl->block('nav')->assign([
					'user' => $_SESSION['user']['account'],
					'submenu' => $this->menu(\Box::val('nav')),
					'lang' => $lang,
				]),
				'main' => $tpl->block('intro'),
			])->render();
			
		}else{
			$html->assign([
				'main' => '',
				'nav' => '',
				'header' => $tpl->block('login')->assign(['lang' => $lang]),
				'footer' => '',
			])->render();
		}
	}
	
	function menu($list, $sub = 0)
	{
		$html = '';
		
		$tpl = new \Yatp(__DIR__ . '/admin.html');
		$arr = [];
		foreach($list as $v){
			// skip first
			if($sub == 1){
				if($v[2] ?? 0){
					$sub = 2;
					continue;
				}else{
					break;
				}
			}
			
			if(is_array($v[0] ?? '')){
				// sub-menu case
				$menu = $this->menu($v, 1);
			}else if($v[2] ?? 0){
				$menu = $tpl->block('submenu-li')->assign([
					'link' => ($v[1] ?? ''),
					'name' => ($v[0] ?? ''),
				]);
			}
			
			if($menu){
				$arr[] = ['submenu-li' => $menu];
			}
		}
		
		$html = $tpl->block('submenu-li')->nest($arr);
		if($sub){
			$html = count($arr)? $tpl->block('submenu')->assign([
				'name' => ($list[0][0] ?? ''),
				'submenu-li' => $html,
			]): '';
		}
		
		return $html;
	}
}