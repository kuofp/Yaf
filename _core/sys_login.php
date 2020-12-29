<?php
namespace Sys;

class Login{
	
	public $act;
	private $database;
	
	function __construct(){
		
		header('P3P: CP="CAO PSA OUR"'); // Damn frameset on IE!!!!!!!
		
		$this->act = $_REQUEST['method'] ?? '';
		$this->database = \Box::obj('db');
		
		if(method_exists($this, $this->act)){
			echo $this->{$this->act}();
			exit;
		}
	}
	
	function login(){
		
		//check parameter
		if(($_POST['account'] ?? 0) && ($_POST['password'] ?? 0)){
			$datas = $this->database->select('t_account', '*', array('AND' => array('account'=>$_POST['account'], 'status_id'=>1) ) );
			
			//set session
			if($datas && password_verify($_POST['password'], $datas[0]['password'])){
				
				$datas_auth = $this->database->select('t_auth', '*');
				$arr_auth = [];
				$arr_tmp = preg_split('/[\s,]+/', $datas[0]['auth'] ?? '');
				
				foreach($datas_auth as $v){
					$arr_auth[$v['name']] = in_array($v['id'], $arr_tmp);
				}
				
				$_SESSION['auth'] = $arr_auth;
				$_SESSION['user'] = $datas[0];
				
				$result = ['code' => 0, 'text' => ''];
				
			}else{
				$result = ['code' => 1, 'text' => '帳號或密碼錯誤'];
			}	
		}else{
			$result = ['code' => 1, 'text' => '所有欄位必填'];
		}
		
		return json_encode($result, JSON_UNESCAPED_UNICODE);
	}
	
	function logout(){
		unset($_SESSION['user']);
		unset($_SESSION['auth']);
		header('Location: ./');
	}
	
	// change password
	function change(){
		
		if($_POST['password'] ?? 0){
			$this->database->update('t_account', ['password' => password_hash($_POST['password'], PASSWORD_DEFAULT)], ['id' => $_SESSION['user']['id']]);
			$result = ['code' => 0, 'text' => '密碼修改成功'];
			
		}else{
			$result = ['code' => 1, 'text' => '密碼務必填寫'];
		}
		
		return json_encode($result, JSON_UNESCAPED_UNICODE);
	}
}