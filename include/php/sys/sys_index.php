<?php
namespace Sys;

class Index{
	
	function __construct(){
		
		$tpl = new \Yatp(__DIR__ . '/../../html/admin.tpl');
		
		$html = $tpl->block('index')->assign(array('title' => \Box::val('title')));
		$lang = $tpl->block('lang')->assign(array('option' => $tpl->block('lang.option')->nest(\Box::obj('Lang')->get())));
		
		if(isset($_SESSION['auth']) && isset($_SESSION['user'])){
			$html->assign(
				array(
					'header' => '',
					'nav'    => $tpl->block('nav')->assign(
						array(
							'user' => $_SESSION['user']['account'],
							'brand'=> \Box::val('brand'),
							'side' => $this->getSubMenu(\Box::val('nav')),
							'lang' => $lang,
						)
					),
					'main' => $tpl->block('intro'),
				)
			)->render();
			
		}else{
			$html->assign(
				array(
					'header' => '',
					'nav'    => '',
					'main'   => $tpl->block('login')->assign(
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
		
		$i = 1;
		foreach($list as $item){
			if($i==1 && $sub==1){
				if($this->authCheck($item)){
					$html .= ' <li class="dropdown-submenu"><a href="#">' . $item[0] . '</a><ul class="dropdown-menu">';
					$i = 0;
					continue;
				}else{
					// break this sub-menu
					return '';
				}
			}
			if(is_array($item[0])){
				$html .= $this->getSubMenu($item, 1);
			}else{
				if($this->authCheck($item)){
					$html .= '<li><a href="#" ' . $this->getOnClick($item[1]) . '>' . $item[0] . '</a></li>';
				}
			}
		}
		$html .= '</ul></li>';
		
		return $html;
	}
	
	function getOnClick($link){
		return ($link=='')? '': 'onclick="' . "$('#main').load('', {m: '" . $link . "'});" . '"';
	}
	
	function authCheck($item, $offset=2){
		return ($item[$offset]=='') || ($_SESSION['auth'][$item[$offset]] ?? 0);
	}
}