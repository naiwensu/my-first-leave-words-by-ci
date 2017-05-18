<?php
	class Register extends CI_Controller{
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
					$this->load->helper('url');
					$this->load->helper('captcha');
					$this->load->library('session');

			}

			public function checkName()
			{
				$username=$_GET['username'];
				$this->load->model('Leaves_model');
				$count=$this->Leaves_model->checkName($username);
				//$count=10;
				if($count>0){
					echo "不允许";
				}else{
					echo "允许";
				}

			}
						

			public function getCap() 
			{
				$cap = create_captcha($this->vals);
				$_SESSION['word']=$cap['word'];
				echo $cap['filename'];
			}
			

			public function reg()
			{
				$cap = create_captcha($this->vals);
				$data['image']= $cap['image'];
				$data['filename']=$cap['filename'];
				// var_dump($cap);exit;
				$_SESSION['word']=$cap['word'];
				$this->load->view('users/register.html',$data);

			}

			public function doRegister()
			{
				$username=$_POST['username'];
				$password=$_POST['password'];
				$repassword=$_POST['repassword'];
				$sex=$_POST['sex'];

				$count=0;

				if($username!="" && $password=$repassword && strtolower($_SESSION['word'])==strtolower($_POST['code'])){

				$this->load->model('Leaves_model');
				$data=$this->Leaves_model->set_users($username,$password,$sex);
				$count=$data[1];
				$id=$data[0];
				$_SESSION['id']=$id;


				}

				//var_dump($count);
				//exit;
				if ($count>0) {
					//echo "注册成功！！";
					redirect('http://www.lyb.com/index.php/Leaves/login');
					//header("Location: http://www.lyb.com/index.php/Leaves/login"); 

				}else{
					//echo "注册失败！！";
					redirect('http://www.lyb.com/index.php/Register/reg');
					//header("Location: http://www.lyb.com/index.php/Register/reg"); 

				}
			}
	}