<?php
	class Admin extends CI_Controller{
		

			public function __construct()
			{
					parent::__construct();
					$this->load->helper('url');
					$this->load->library('session');

                    if (!isset($_SESSION['username']) || $_SESSION['username']!=='admin') {
                    header("Location: http://www.lyb.com/index.php/Leaves/login");
                }
			}

            public function admin()
            {
                //管理员审核
                //显示所有条目，可执行查看、删除、通过操作
                //查询所有记录
                $this->load->model('Leaves_model');
                $result=$this->Leaves_model->get_message();
                $result['result']=$result;
                //var_dump($result);
                $this->load->view('users/admin.html',$result);
            }

            public function delete()
            {
                $id=$_GET['id'];
                $this->load->model('Leaves_model');
                $count=$this->Leaves_model->delete_message($id);

                if ($count>0) {

                    //echo "删除成功！！";
                    header("Location: http://www.lyb.com/index.php/Admin/admin");
                }else{
                    echo "删除失败！！";                  

                }
            }

            public function pass()
            {
                $id=$_GET['id'];
                $this->load->model('Leaves_model');
                $count=$this->Leaves_model->set_passmessage($id);
                if ($count>0) {

                    //echo "审核成功！！";
                    header("Location: http://www.lyb.com/index.php/Admin/delete?id=$id");
                }else{
                    echo "审核失败！！";                  

                }
            }

            public function read()
            {
                //查看单条记录内容
                $id=$_GET['id'];
                $this->load->model('Leaves_model');
                $row=$this->Leaves_model->read_message($id);
                if(isset($row)){
                        $this->load->view('users/read.html',$row);
                }else{
                    echo "查看失败！！！";
                }
            }
        }
?>