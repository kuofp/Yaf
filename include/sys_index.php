<?php
	// bootstrap nav
	function getSubMenu($list, $sub=0){
		$html = '';
		
		$i = 1;
		foreach($list as $item){
			if($i==1 && $sub==1){
				if(authCheck($item)){
					$html .= ' <li class="dropdown-submenu"><a href="#">' . $item[0] . '</a><ul class="dropdown-menu">';
					$i = 0;
					continue;
				}else{
					// break this sub-menu
					return '';
				}
			}
			if(is_array($item[0])){
				$html .= getSubMenu($item, 1);
			}else{
				if(authCheck($item)){
					$html .= '<li><a href="#" ' . getOnClick($item[1]) . '>' . $item[0] . '</a></li>';
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
		return ($item[$offset]=='') || isset($_SESSION['auth'][$item[$offset]]);
	}
	
	
	$tpl = new Snake('include/template/form.tpl');
	
	
	$html = $tpl->block('index')->assign(array('title' => $cfg_title));
	
	if(isset($_SESSION['auth']) && isset($_SESSION['user_id'])){
		$html->assign(
			array(
				'header' => $tpl->block('header'),
				'nav'   => $tpl->block('nav')->assign(
					array(
						'user' => $_SESSION['user_name'],
						'mail' => $_SESSION['user_mail'],
						'brand'=> $cfg_brand,
						'nav'  => getSubMenu($cfg_nav),
						
					)
				),
				'main' => $tpl->block('intro'),
			)
		)->render();
		
	}else{
		$html->assign(
			array(
				'header' => '',
				'nav'   => '',
				'main'  => $tpl->block('login')->assign(
					array(
						'title' => $cfg_title,
						'brand' => $cfg_brand,
					)
				),
				'footer'=> '',
				
			)
		)->render();
		session_destroy();
	}
	