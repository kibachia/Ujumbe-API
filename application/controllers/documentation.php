<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documentation extends CI_Controller {

	public function index()
	{
	
		$this->load->helper('url');
		
		$this->load->view('documentation');
		
	}
}

/* End of file documentation.php */
/* Location: ./application/controllers/documentation.php */