<?php
	class Users extends CI_Controller{
		

			public function __construct()
			{
					parent::__construct();
					$this->load->helper('url');
					$this->load->library('session');

                    if (!isset($_SESSION['username']) || $_SESSION['username']=='') {
                    header("Location: http://www.lyb.com/index.php/Leaves/login");
                }
			}

            public function users()
            {
                //普通用户查看信息
                //显示所有条目，可执行查看
                //查询所有记录
                $this->load->model('Leaves_model');
                $result=$this->Leaves_model->get_passdmessage();
                $result['result']=$result;
              
                $this->load->view('users/users.html',$result);
            }

            

            public function read()
            {
                //查看单条记录内容
                $id=$_GET['id'];
                $this->load->model('Leaves_model');   
                $row=$this->Leaves_model->read_passdmessage($id);
                $id=$row['uid'];

                $username=$this->Leaves_model->get_username($id);
                $row['username']=$username;
                if(isset($row)){
                        $this->load->view('users/passread.html',$row);
                }else{
                    echo "查看失败！！！";
                }
            }
        }
?>