<?php
	class Leaves_model extends CI_Model{
		public function __construct()
		{
			$this->load->database();
			$this->load->library('session');

		}

		public function user_message($username,$password)
		{
			
			$this->db->get_where('ci_users',array('username'=>$username,'password'=>$password));
			$count=$this->db->count_all_results();
			//$count=$this->db->count_all('ci_users');
			return $count;
		}

		public function set_users($username,$password,$sex)
		{

			$data = array(
        	'username' => $this->input->post('username'),
        	'password' => $this->input->post('password'),
        	'sex' => $this->input->post('sex')
    		);

    		$this->db->insert('ci_users', $data);
    		$id=$this->db->insert_id();
    		$count=$this->db->affected_rows();
    		$data=array($id,$count);
    		return $data;

		}

		public function get_id()
		{

			$sql = "SELECT id FROM ci_users WHERE username = ?";
			$query=$this->db->query($sql, array($_SESSION['username']));
			$row = $query->row();
			if (isset($row))
			{
				
    			return $row->id;
    			
			}else{
				echo "string";
			}

			//exit();

		}

		public function set_message()
		{
			$data = array(
				'time' => $this->input->post('time'),
				'title' => $this->input->post('title'),
				'content' => $this->input->post('content'),
				'uid' => $_SESSION['id']
				);
			if($data['title']!='' && $data['content']!=''){
			$this->db->insert('ci_message', $data);
    		$count=$this->db->affected_rows();
    		return $count;
    		}else{
    			return false;
    		}

		}

		public function get_message()
		{
			$sql = "SELECT * FROM ci_message";
			$query=$this->db->query($sql);
			$result=$query->result();
			return $result;


		}

		public function delete_message($id)
		{
			$this->db->delete('ci_message', array('id' => $id));
			return $count=$this->db->affected_rows();


		}

		public function set_passmessage($id)
		{
			$sql = "SELECT * FROM ci_message WHERE id = ? ";
			$query=$this->db->query($sql, array($id));
			$row = $query->row_array();
			$this->db->insert('ci_passmessage', $row);
			$count=$this->db->affected_rows();
			if($count>0){
				return $count;
			}else{
				return false;
			}
		}

		public function get_passdmessage()
		{
			$sql = "SELECT * FROM ci_passmessage";
			$query=$this->db->query($sql);
			$result=$query->result();
			return $result;

		}

		public function read_message($id)
		{
			$sql = "SELECT * FROM ci_message WHERE id = ? ";
			$query=$this->db->query($sql, array($id));
			$row = $query->row_array();
			if(isset($row)){
				return $row;
			}else{
				return false;
			}
		}

		public function read_passdmessage($id)
		{
			$sql = "SELECT * FROM ci_passmessage WHERE id = ? ";
			$query=$this->db->query($sql, array($id));
			$row = $query->row_array();
			if(isset($row)){
				return $row;
			}else{
				return '查询错误！';
			}
		}

		public function get_username($id)
		{

			$sql = "SELECT * FROM ci_users WHERE id = ? ";
			$query=$this->db->query($sql, array($id));
			$row = $query->row();
			if (isset($row))
			{
				
    			return $row->username;
    			
			}else{
				echo "string";
			}


		}

		public function checkName($username)
		{
			//检查用户表内有没有输入的用户名
			//$sql = "SELECT * FROM ci_users WHERE username = ? ";
			//$this->db->query($sql, array($username));
			$this->db->where('username',$username);
			$this->db->from('ci_users');
			$count=$this->db->count_all_results();
			return $count;
		}
	}
	?>