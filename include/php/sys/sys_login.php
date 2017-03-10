<?php
namespace Sys;

class Login{
	
	public $act;
	private $database;
	
	function __construct(){
		header('P3P: CP="CAO PSA OUR"'); // Damn frameset on IE!!!!!!!
		global $di;
		
		$this->act = isset($_GET['method'])? $_GET['method']: '';
		$this->database = $di->obj('db');
		
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
			
			if(!empty($datas[0]['auth'])){
				
				$datas_auth = $this->database->select('t_auth', '*');
				$arr_auth = array();
				$arr_tmp = preg_split("/[\s,]+/", $datas[0]['auth']);
				
				foreach($datas_auth as $item){
					if(in_array($item['id'], $arr_tmp)){
						$arr_auth[$item['name']] = $item['id'];
					}
				}
			}
			
			$_SESSION['user_id'] = $datas[0]['id'];
			$_SESSION['user_user'] = $datas[0]['user'];
			$_SESSION['user_name'] = $datas[0]['name'];
			$_SESSION['user_mail'] = $datas[0]['mail'];
			$_SESSION['auth'] = $arr_auth;
		}
	}
	
	function logout(){
		
		unset($_SESSION['user_id']);
		unset($_SESSION['user_user']);
		unset($_SESSION['user_name']);
		unset($_SESSION['user_mail']);
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
			
			$this->database->update('t_account', array('password'=>$password), array('id'=>$_SESSION['user_id']));
			
			echo 'success';
		}
	}
}