<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verify extends CI_Controller {

	function __construct()
	{
		parent::__construct();
				
		$this->load->model('emailmodel');
						
	}

	public function index($string)
	{
	
		$email = $this->emailmodel->confirmEmail($string);
		
		if( $email ) {
		
			$temp['error_message_heading'] = "Success!";
			$temp['error_message'] = "<small>Your email address has been verified and you can now receive Sent emails on this email address:<br><b>".$email."</b></small>";
			
			$temp['alert_type'] = "success";
										
			die( $this->load->view('alert', array('data'=>$temp), true) );
		
		} else {
		
			$temp['error_message_heading'] = "Ouch!";
			$temp['error_message'] = "<small>It appears the email verification URL/code is not correct and we can not verify your email address at this point. Please double check the verification URL from the email.</small>";
			
			$temp['alert_type'] = "error";
										
			die( $this->load->view('alert', array('data'=>$temp), true) );
		
		}
		
	}
}

/* End of file verify.php */
/* Location: ./application/controllers/verify.php */