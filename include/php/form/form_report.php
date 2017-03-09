<?php
namespace Form;

class Report{
	
	function __construct(){
		
		global $di;
		
		$obj = new \Yapa(
			/*file*/
			_url(get_class($this)),
			/*db*/
			'db_shop',
			/*table*/
			't_account',
			/*col*/
			array('id', 'account_id', 'user', 'sum1', 'sum2'),
			/*col_ch*/
			array('代碼', '階層', '帳號', '總額', '總額'),
			/*empty check*/
			array(0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
			/*exist(duplicate) check*/
			array(0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0),
			/*chain(join) check (table, content, id)*/
			array('', 't_account,user,id', '', '', '', ''),
			/*show bootstrap grid class*/
			array(
				'hidden',
				'col-md-4 col-sm-4 col-xs-7',
				'col-md-4 col-sm-4 col-xs-4',
				'col-md-1 col-sm-1 col-xs-1 text-right',
				'col-md-1 col-sm-1 hidden-xs text-right',
				'col-md-1 col-sm-1 hidden-xs',
				'col-md-1 col-sm-1 hidden-xs',
			),
			/*select/radiobox/checkbox/text/password/textarea/autocomplete/datepicker */
			array('hidden', 'select', 'text', 'value', 'value', 'text'),
			/*authority check*/
			array(
				$_SESSION['auth']['account_review'] ?? 0,
				0,
				0,
				0,
			),
			/*medoo*/
			$di->obj('db'),
			/*phpmailer*/
			$di->obj('mail'),
			/*config*/
			array(
				'perpage' => 0
			)
		);
		
		$arr = $obj->decodeJson($_POST);

		if(!empty($obj->act)){
			//additional settings
			switch($obj->act){
				case 'review':
					
					$r = $di->obj('db')->query('
					SELECT
						SUM(rda_result_amount) as "sum2",
						SUM(rda_bet_amount) as "sum1",
						m.ant_pid as id
					FROM rda
					JOIN (
						SELECT ant_id, ant_pid
						FROM mem
					) as m
					ON rda.pid = m.ant_id
					WHERE rda_bet_date >= ' . strtotime('2017-01-01') . ' AND rda_bet_date < ' . strtotime('2017-01-02') . '
					GROUP BY m.ant_pid;
					')->fetchAll(\PDO::FETCH_ASSOC);
					
					$obj->bind($r);
					break;
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