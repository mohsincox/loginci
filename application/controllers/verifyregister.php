<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifyregister extends CI_Controller {

	public function index()
	{
		$this->load->library('form_validation');

	   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
	   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

	   if($this->form_validation->run() == FALSE)
	   {
	     //Field validation failed.  User redirected to login page
	     $this->load->view('login_view');
	   }
	   else
	   {
	     //Go to private area
	     //redirect('home', 'refresh');
	   		$username = $this->input->post('username');
	   		$password = md5($this->input->post('password'));

	   		$sql = "INSERT INTO users (username, password) 
        	VALUES (".$this->db->escape($username).", ".$this->db->escape($password).")";
			$this->db->query($sql);

			$query = $this->db->query('SELECT id, username FROM users WHERE username = "$username" AND password = "$password"  LIMIT 1');
				$row = $query->row();
				//echo $row->name;

			$sess_array = array(
		         'id' => $row->id,
		         'username' => $row->username
		       );
		       $this->session->set_userdata('logged_in', $sess_array);
		     redirect('home', 'refresh');
		   }
	   }
	}

