<?php
namespace Sys;

class Login{
	
	public $act;
	private $database;
	
	function __construct()
	{
		header('P3P: CP="CAO PSA OUR"'); // Damn frameset on IE!!!!!!!
		
		$this->act = $_REQUEST['method'] ?? '';
		$this->database = \Box::obj('db');
		
		if(method_exists($this, $this->act)){
			echo $this->{$this->act}();
			exit;
		}
	}
	
	function login()
	{
		//check parameter
		if(($_POST['account'] ?? 0) && ($_POST['password'] ?? 0)){
			$user = $this->database->select('t_account', '*', [
				'AND' => [
					'account' => $_POST['account'],
					'status_id' => 1,
				]
			]);
			//set session
			if($user && password_verify($_POST['password'], $user[0]['password'])){
				
				$auth = $this->database->select('t_auth', '*');
				$tmp = preg_split('/[\s,]+/', $user[0]['auth'] ?? '');
				
				$arr = [];
				foreach($auth as $v){
					$arr[$v['name']] = in_array($v['id'], $tmp);
				}
				
				$_SESSION['auth'] = $arr;
				$_SESSION['user'] = $user[0];
				
				$result = ['code' => 0, 'text' => ''];
				
			}else{
				$result = ['code' => 1, 'text' => '帳號或密碼錯誤'];
			}	
		}else{
			$result = ['code' => 1, 'text' => '所有欄位必填'];
		}
		
		return json_encode($result, JSON_UNESCAPED_UNICODE);
	}
	
	function logout()
	{
		unset($_SESSION['user']);
		unset($_SESSION['auth']);
		header('Location: ./');
	}
	
	function change()
	{
		if($_POST['password'] ?? 0){
			$this->database->update('t_account', ['password' => password_hash($_POST['password'], PASSWORD_DEFAULT)], ['id' => $_SESSION['user']['id']]);
			$result = ['code' => 0, 'text' => '密碼修改成功'];
		}else{
			$result = ['code' => 1, 'text' => '密碼務必填寫'];
		}
		
		return json_encode($result, JSON_UNESCAPED_UNICODE);
	}
}