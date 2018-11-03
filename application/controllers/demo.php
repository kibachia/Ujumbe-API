<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demo extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		$this->load->library('session');
		
		$this->load->model('emailmodel');
			
	}

	public function basic()
	{
		
		$this->data['page'] = "Basic Demo";
	
		$this->load->view('demo/basic', $this->data);
		
	}
	
	public function advanced()
	{
		
		$this->data['page'] = "Advanced Demo";
	
		$this->load->view('demo/advanced', $this->data);
		
	}
	
	public function validation()
	{
		
		$this->data['page'] = "Validation Demo";
	
		$this->load->view('demo/validation', $this->data);
		
	}
	
	public function file()
	{
		
		$this->data['page'] = "File Demo";
	
		$this->load->view('demo/file', $this->data);
		
	}
	
}

/* End of file demo.php */
/* Location: ./application/controllers/demo.php */