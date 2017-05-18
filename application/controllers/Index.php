<?php
	class Index extends CI_Controller{

		public function __construct()
			{
					parent::__construct();
					$this->load->helper('url');
					$this->load->library('session');
					if (!isset($_SESSION['username']) || $_SESSION['username']=='') {
                    header("Location: http://www.lyb.com/index.php/Leaves/login");
                }

			}

		public function index()
		{	
			if($_SESSION['username']=='admin')
			{
				//管理员 审核留言
				header("Location: http://www.lyb.com/index.php/Admin/admin");


			

			} elseif (!isset($_SESSION['username']) || $_SESSION['username']=="") {
				header("Location: http://www.lyb.com/index.php/Leaves/login");
			}else{
			//echo 111;exit();
			header("Location: http://www.lyb.com/index.php/Users/users");
			}
		}

		public function comment()
		{
			$this->load->view('users/index.html',$_SESSION);


		}

		public function set()
		{
			
			
			$this->load->model('Leaves_model');
			//$this->Leaves_model->get_id();
			$_SESSION['id']=$this->Leaves_model->get_id();
		
			$count=$this->Leaves_model->set_message();
			if ($count>0) {
					
					//header("Location: http://www.lyb.com/index.php/Index/index");
					redirect('http://www.lyb.com/index.php/Index/index');
					
				
				}else{
					echo "留言失败！！";
					//$this->index();

				}
		}
	}

?>