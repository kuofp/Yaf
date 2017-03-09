<?php
namespace Form;

class Chat{
	
	function __construct(){
		
		global $di;
		
		$obj = new \Yapa(
			/*file*/
			_url(get_class($this)),
			/*db*/
			'db_shop',
			/*table*/
			't_chat',
			/*col*/
			array('id', 'user_id', 'user', 'content', 'reply', 'date'),
			/*col_ch*/
			array('代碼', '帳號', '留言名稱', '留言內容', '店家回覆', '留言時間'),
			/*empty check*/
			array(0, 0, 0, 0, 0, 0),
			/*exist(duplicate) check*/
			array(0, 0, 0, 0, 0, 0),
			/*chain(join) check (table, content, id)*/
			array('', 't_account,user,id', '', '', '', ''),
			/*show bootstrap grid class*/
			array(
				'hidden',
				'col-md-2 col-sm-2 col-xs-4',
				'col-md-2 col-sm-2 col-xs-4',
				'col-md-2 col-sm-2 hidden-xs',
				'col-md-2 col-sm-2 col-xs-4',
				'col-md-2 col-sm-2 hidden-xs',
			),
			/*select/radiobox/checkbox/text/textarea/autocomplete/datepicker */
			array('hidden', 'hidden', 'hidden', 'text', 'text', 'hidden'),
			/*authority check*/
			array(
				$_SESSION['auth']['chat_review'] ?? 0,
				$_SESSION['auth']['chat_create'] ?? 0,
				$_SESSION['auth']['chat_modify'] ?? 0,
				$_SESSION['auth']['chat_delete'] ?? 0,
			),
			/*medoo*/
			$di->obj('db'),
			/*phpmailer*/
			$di->obj('mail')
		);
		
		$obj->decodeJson($_POST);
		
		if(!empty($obj->act)){
			//additional settings
			switch($obj->act){
				default:
					break;
			}
			
			//do the work
			echo $obj->{$obj->act}($obj->arg);
			exit;
		}else{
			$obj->render();
		}
		
		unset($obj);
	}
}