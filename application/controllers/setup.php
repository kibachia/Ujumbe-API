<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setup extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		
		if( !$this->db->conn_id ) {
		
			$redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
			$redir .= "://".$_SERVER['HTTP_HOST'];
			$redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
			$redir = str_replace('install/','',$redir);
		
			header('Location: '.$redir."install/");
		
		} 
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		$this->load->library('session');
		
		$this->load->model('emailmodel');
								
	}

	public function index()
	{
		$this->data['page'] = "setup";
	
		if( isset( $_POST['email'] ) ) {
					
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
			if ($this->form_validation->run() == FALSE) {
				
				//$this->load->view('myform');
					
			} else {
									
				$this->data['emailCode'] = $this->emailmodel->maskEmail($_POST['email']);
				
			}
		
		}
	
		$this->load->view('setup', $this->data);
	}
}

/* End of file setup.php */
/* Location: ./application/controllers/setup.php */