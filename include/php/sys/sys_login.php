<?php
namespace Sys;

class Login{
	
	public $act;
	private $database;
	
	function __construct(){
		
		header('P3P: CP="CAO PSA OUR"'); // Damn frameset on IE!!!!!!!
		
		$this->act = isset($_REQUEST['method'])? $_REQUEST['method']: '';
		$this->database = \Box::obj('db');
		
		if(method_exists($this, $this->act)){
			$this->{$this->act}();
			exit;
		}
	}
	
	function login(){
		
		//check parameter
		if(empty($_POST['user']) || empty($_POST['password'])){
			echo 'err_empty';
			exit;
		}
		
		$user = $_POST["user"];
		$password = md5($_POST["password"]);
		
		
		$datas = $this->database->select('t_account', '*', array('AND' => array('user'=>$user, 'password'=>$password, 'valid_id'=>3) ) );

		//set session
		if(empty($datas)){
			echo 'err_fail';
			
		}else{
			echo 'success';
			
			$datas_auth = $this->database->select('t_auth', '*');
			$arr_auth = array();
			$arr_tmp = preg_split("/[\s,]+/", $datas[0]['auth'] ?? '');
			
			foreach($datas_auth as $v){
				$arr_auth[$v['name']] = in_array($v['id'], $arr_tmp);
			}
			
			$_SESSION['auth'] = $arr_auth;
			$_SESSION['user'] = $datas[0];
		}
	}
	
	function logout(){
		
		unset($_SESSION['user']);
		unset($_SESSION['auth']);
		
		echo 'logout';
		header("Location: ./");
	}
	
	// change password
	function change(){
		
		$user = $this->database->select('t_account', '*', array('id'=>$_SESSION['user_id']));
		$password = isset($_POST['password'])? $_POST['password']: '';
		
		if(empty($password)){
			echo 'err_empty';
			
		}else if($user[0]['password'] != $password){
			$password = md5($password);
			
			$this->database->update('t_account', array('password'=>$password), array('id'=>$_SESSION['user']['id']));
			
			echo 'success';
		}
	}
}