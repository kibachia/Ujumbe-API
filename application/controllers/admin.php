<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
				
		$this->load->model('submissionmodel');
		$this->load->model('emailmodel');
		$this->load->model('attachmentmodel');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('upload');
		
		$this->load->library('ion_auth');
		
		if(!$this->ion_auth->logged_in()) {
			
			redirect( site_url("setup") );
		
		}
						
	}

	public function submissions($page = 1, $filter = '')
	{
		
		$perpage = 15;
		
		$start = ($page-1)*$perpage;
		
		if( $filter != '' ) {
						
			$this->session->set_userdata('filter', $filter);
		
		}
				
		if( isset($_GET['search']) ) {
		
			$search = $_GET['search'];
		
		} else {
			
			$search = false;
		
		}
		
		//grab all submissions
		
		$this->data['submissions'] = $this->submissionmodel->getEm($start, $perpage, $this->session->userdata('filter'), $search);
		$this->data['page'] = $page;
		$this->data['total'] = $this->submissionmodel->getTotal($this->session->userdata('filter'), $search);
		$this->data['perpage'] = $perpage;
	
		$this->load->view('admin/submissions', $this->data);
		
	}
	
	public function deletesubmission($id)
	{
	
		$this->submissionmodel->deleteSubmission($id);
		
		$this->session->set_flashdata('success_message', 'The submission was succesfully deleted.');
		
		redirect(site_url("admin/submissions"), 'location');
	
	}
	
	public function deletesubmissionmulti()
	{
	
		if( isset($_POST['ids']) && count($_POST['ids']) > 0 ) {
			
			$this->submissionmodel->deleteSubmissions($_POST['ids']);
			
			$this->session->set_flashdata('success_message', 'The submissions were succesfully deleted.');
			
			redirect(site_url("admin/submissions"), 'location');
		
		} else {
		
			$this->session->set_flashdata('error_message', 'Please choose one or more submissions to delete.');
			
			redirect(site_url("admin/submissions"), 'location');
		
		}
	
	}
	
	
	public function emailids($page = 1, $filter = '')
	{
	
		$perpage = 15;
		
		$start = ($page-1)*$perpage;
		
		
		if( $filter != '' ) {
						
			$this->session->set_userdata('email_filter', $filter);
		
		}
				
		if( isset($_GET['search']) ) {
		
			$search = $_GET['search'];
		
		} else {
			
			$search = false;
		
		}
		
		
		$this->data['emails'] = $this->emailmodel->getEm($start, $perpage, $this->session->userdata('email_filter'), $search);
		$this->data['page'] = $page;
		$this->data['total'] = $this->emailmodel->getTotal($this->session->userdata('email_filter'), $search);
		$this->data['perpage'] = $perpage;
		
		$this->load->view('admin/emails', $this->data);
	
	}
	
	public function deleteemail($id)
	{
	
		$this->emailmodel->deleteEmail($id);
		
		$this->session->set_flashdata('success_message', 'The email address was succesfully deleted.');
		
		redirect(site_url("admin/emailids"), 'location');
	
	}
	
	public function deleteemailmulti()
	{
	
		if( isset($_POST['ids']) && count($_POST['ids']) > 0 ) {
			
			$this->emailmodel->deleteEmails($_POST['ids']);
			
			$this->session->set_flashdata('success_message', 'The email addresses were succesfully deleted.');
			
			redirect(site_url("admin/emailids"), 'location');
		
		} else {
		
			$this->session->set_flashdata('error_message', 'Please choose one or more email addresses to delete.');
			
			redirect(site_url("admin/emailids"), 'location');
		
		}
	
	}
	
	public function attachments()
	{
	
		$this->data['attachments'] = $this->attachmentmodel->getEm();
		
		$this->load->view('admin/attachments', $this->data);
	
	}
	
	
	public function deleteattachment($file)
	{
	
		unlink($this->upload->upload_path.$file);
				
		$this->session->set_flashdata('success_message', 'The attachment was succesfully deleted.');
		
		redirect(site_url("admin/attachments"), 'location');
	
	}
	
	
	public function deleteattachmentmulti()
	{
	
		if( isset($_POST['ids']) && count($_POST['ids']) > 0 ) {
			
			$this->attachmentmodel->deleteAttachments($_POST['ids']);
			
			$this->session->set_flashdata('success_message', 'The attachments were succesfully deleted.');
			
			redirect(site_url("admin/attachments"), 'location');
		
		} else {
		
			$this->session->set_flashdata('error_message', 'Please choose one or more attachments to delete.');
			
			redirect(site_url("admin/attachments"), 'location');
		
		}
	
	}
	
	public function account()
	{
		
		$this->data['page'] = "Account";
		
		if( isset($_POST['email']) && isset($_POST['password']) ) {
		
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
			$this->form_validation->set_rules('password2', 'Confirm password', 'required|xss_clean|matches[password]');
			
			if ($this->form_validation->run() == FALSE) {
			
				$this->load->view('admin/account', $this->data);
			
			} else {
			
				//update details
				
				$user = $this->ion_auth->user()->row();
				
				$data = array(
					'email' => $_POST['email'],
					'password' => $_POST['password']
				);
				
				$this->ion_auth->update($user->id, $data);
				
				$this->data['success'] = true;
				
				$this->load->view('admin/account', $this->data);
					
			}
		
		} else {
	
			$this->load->view('admin/account', $this->data);
		
		}
	
	}
	
	
	public function toggleEmail()
	{
	
		if( isset($_POST['email']) && isset($_POST['toggle']) ) {
		
			$this->emailmodel->toggleEmail($_POST['email'], $_POST['toggle']);
		
		}
	
	}
	
	
	public function settings()
	{
		
		$this->data['page'] = "Settings";
		
		if( isset($_POST['admin_email']) ) {
				
			$this->form_validation->set_rules('admin_email', 'Administrator email address', 'required|valid_email|xss_clean');
			$this->form_validation->set_rules('email_confirmation_message', 'Confirmation message', 'required|xss_clean');
			$this->form_validation->set_rules('email_from', 'Emails sent from', 'required|valid_email|xss_clean');
			$this->form_validation->set_rules('email_from_name', 'Emails from name', 'required|xss_clean');
			$this->form_validation->set_rules('email_default_subject', 'Default subject', 'required|xss_clean');
			$this->form_validation->set_rules('email_confirmation', 'Confirmation email', 'xss_clean');
			$this->form_validation->set_rules('spam_words', 'Spam words', 'xss_clean');
			
			if ($this->form_validation->run() == FALSE) {
			
				$this->load->view('admin/settings', $this->data);
							
			} else {
			
				//update details
				
				$this->configmodel->update($_POST);
				
				$this->session->set_flashdata('success', 'indeed');
				
				redirect(site_url("admin/settings"), 'location');
					
			}
		
		} else {
	
			$this->load->view('admin/settings', $this->data);
		
		}
	
	}
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */