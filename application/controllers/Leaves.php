<?php
	class Leaves extends CI_Controller{
		public $vals = array(
    			'word'      => '',
    			'img_path'  => './captcha/',
    			'img_url'   => 'http://www.lyb.com/captcha/',
    			'font_path' => '',
    			'img_width' => '150',
    			'img_height'    => 30,
    			'expiration'    => 7200,
    			'word_length'   => 2,
    			'font_size' => 20,
    			'img_id'    => 'Imageid',
    			'pool'      => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

    			// White background and border, black text and red grid
    			'colors'    => array(
        		'background' => array(255, 255, 255),
       			'border' => array(255, 255, 255),
        		'text' => array(0, 0, 0),
        		'grid' => array(255, 40, 40)
    				)
				);

			public function __construct()
			{
					parent::__construct();
					$this->load->helper('captcha');
					$this->load->library('session');



			}
			

			public function login()
			{
			

				$cap = create_captcha($this->vals);
				$data['image']= $cap['image'];
				$data['filename']=$cap['filename'];
				// var_dump($cap);exit;

				$_SESSION['word']=$cap['word'];


				//$this->load->view('templates/header');
				$this->load->view('users/login.html',$data);
				//$this->load->view('templates/footerer');
			}

			public function getCap() 
			{
				$cap = create_captcha($this->vals);
				$_SESSION['word']=$cap['word'];
				echo $cap['filename'];
			}

			public function doLogin()
			{
				$username=$_POST['username'];
				$password=$_POST['password'];
				$_SESSION['username']=$_POST['username'];
				$_SESSION['password']=$_POST['password'];


				$this->load->model('Leaves_model');
				$count=$this->Leaves_model->user_message($username,$password);

				//var_dump($count);
				//exit;
				if ($count>0 && strtolower($_SESSION['word'])==strtolower($_POST['code'])) {
					//echo "登录成功！！";
					header("Location: http://www.lyb.com/index.php/Index/index");
				}else{
					echo "登陆失败！！";
					$this->login();

				}

			}

			public function doLogout()
			{
				$username=$_SESSION['username'];
				$_SESSION=array();
				if(isset($_COOKIE[session_name()])){
					setcookie(session_name(),'',time()-42000,'/');
				}
				session_destroy();
				$data['username']=$username;
				$this->load->view('users/doLogout.html',$data);

			}

			



	}