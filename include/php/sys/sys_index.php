<?php
namespace Sys;

class Index{
	
	function __construct(){
		
		$tpl = new \Yatp(__DIR__ . '/../../html/admin.tpl');
		
		$html = $tpl->block('index')->assign(array('title' => \Box::val('title')));
		
		$lang = [];
		foreach(\Box::val('lang')['list'] as $k=>$v){
			$lang[] = [
				'text' => $k,
				'value' => $v,
				'selected' => ((\Box::val('lang')['default']) == $v? 'selected': ''),
			];
		}
		$lang = $tpl->block('lang')->assign(['option' => $tpl->block('lang.option')->nest($lang)]);
		
		if(isset($_SESSION['auth']) && isset($_SESSION['user'])){
			$html->assign(
				array(
					'header' => '',
					'nav'    => $tpl->block('nav')->assign(
						array(
							'user' => $_SESSION['user']['account'],
							'brand'=> \Box::val('brand'),
							'submenu' => $this->getSubMenu(\Box::val('nav')),
							'lang' => $lang,
						)
					),
					'main' => $tpl->block('intro'),
				)
			)->render();
			
		}else{
			$html->assign(
				array(
					'main'   => '',
					'nav'    => '',
					'header' => $tpl->block('login')->assign(
						array(
							'title' => \Box::val('title'),
							'brand' => \Box::val('brand'),
							'lang'  => $lang,
						)
					),
					'footer' => '',
					
				)
			)->render();
		}
		
		exit;
	}
	
	// bootstrap nav
	function getSubMenu($list, $sub=0){
		$html = '';
		
		$tpl = new \Yatp(__DIR__ . '/../../html/admin.tpl');
		$arr = [];
		foreach($list as $item){
			// skip first
			if($sub == 1){
				if($item[2] ?? 0){
					$sub = 2;
					continue;
				}else{
					break;
				}
			}
			
			if(is_array($item[0] ?? '')){
				// sub-menu case
				$menu = $this->getSubMenu($item, 1);
				if($menu){
					$arr[] = ['submenu-li' => $menu];
				}
				
			}else{
				if($item[2] ?? 0){
					$arr[] = [
						'submenu-li' => $tpl->block('submenu-li')->assign([
							'link' => ($item[1] ?? ''),
							'name' => ($item[0] ?? ''),
						])
					];
				}
			}
		}
		
		$html = $tpl->block('submenu-li')->nest($arr)->render(false);
		$cnt = count($arr);
		if($sub && $cnt){
			$html = $tpl->block('submenu')->assign([
				'name' => ($list[0][0] ?? ''),
				'submenu-li' => $html,
			])->render(false);
		}else if($sub && $cnt==0){
			// remove sub-menu
			$html = '';
		}
		
		return $html;
	}
}