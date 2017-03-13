<?php
namespace Form;

class Ad{
	
	function __construct(){
		
		$obj = new \Yapa(
			/*file*/
			_url(get_class($this)),
			/*db*/
			'db_shop',
			/*table*/
			't_ad',
			/*col*/
			array('id', 'pic', 'link', 'status_id'),
			/*col_ch*/
			array(_('id'), _('picture'), _('link'), _('status')),
			/*empty check*/
			array(0, 0, 0, 0),
			/*exist(duplicate) check*/
			array(0, 0, 0, 0),
			/*chain(join) check (table, content, id)*/
			array('', '', '', 't_status,alias,id'),
			/*show bootstrap grid class*/
			array(
				'hidden',
				'col-md-2 col-sm-2 col-xs-4',
				'col-md-8 col-sm-8 col-xs-4',
				'col-md-2 col-sm-2 col-xs-4',
			),
			/*select/radiobox/checkbox/text/textarea/autocomplete/datepicker */
			array('hidden', 'uploadfile', 'json', 'select'),
			/*authority check*/
			array(
				$_SESSION['auth']['admin_review'] ?? 0,
				$_SESSION['auth']['admin_create'] ?? 0,
				$_SESSION['auth']['admin_modify'] ?? 0,
				$_SESSION['auth']['admin_delete'] ?? 0,
			),
			/*medoo*/
			\Box::obj('db'),
			/*phpmailer*/
			\Box::obj('mail'),
			/*config*/
			array(
				'preset' => array(
					'link' => array('API'=>'', 'KEY'=>'')
				)
			)
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
		}else{
			$obj->render();
		}
		
		unset($obj);
		exit;
	}
}