<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('email');
		$this->load->model('emailmodel');
		$this->load->model('datamodel');
		$this->load->model('submissionmodel');
		$this->load->library('email');
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		$this->load->library('session');
		$this->load->library('upload');
		
		//dynamic configuration
		
		$this->load->model('configmodel');
		
		$this->configmodel->loadConfig();
								
	}
	
	public function sent()
	{
	
		if( $this->session->flashdata('message') != '' ) {
		
			echo $this->load->view('alert', array('data'=>$this->session->flashdata('message')), true);
		
		} else {
		
			$temp = array();
			$temp['error_message_heading'] = "Ouch!";
			$temp['error_message'] = "<small>We can't resubmit the form data. Please return to the original form and resubmit the data from there.</small>";
			
			$temp['alert_type'] = "error";
							
			die( $this->load->view('alert', array('data'=>$temp), true) );
		
		}
	
	}

	public function index($to = '')
	{
	
		//no email address or ID?
		if( $to == '' ) {
		
			$temp = array();
			$temp['error_message_heading'] = "Ouch!";
			$temp['error_message'] = "<small>We don't know where to send this data to; it appears the email or email ID is missing. Please contact <a href='mailto:".$this->config->item('admin_email')."'>".$this->config->item('admin_email')."</a></small>";
			
			if( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] != '' ) {
				$temp['error_message'] .= "<br><a href='".$_SERVER['HTTP_REFERER']."' class='btn btn-primary btn-block'><span class='fui-arrow-left'></span> Go back</a>";
			}
			
			$temp['alert_type'] = "error";
							
			die( $this->load->view('alert', array('data'=>$temp), true) );
		
		}
		
	
		//flat reject if all fields are empty
		
		if( $this->datamodel->allEmpty($_REQUEST) ) {
		
			$temp = array();
			$temp['error_message_heading'] = "Ouch!";
			$temp['error_message'] = "<small>You can not submit an empty form. Please go back to the previous page and enter some values.</small>";
			
			if( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] != '' ) {
				$temp['error_message'] .= "<br><a href='".$_SERVER['HTTP_REFERER']."' class='btn btn-primary btn-block'><span class='fui-arrow-left'></span> Go back</a>";
			}
			
			$temp['alert_type'] = "error";
							
			die( $this->load->view('alert', array('data'=>$temp), true) );
		
		}
		
		//check to see if we have a proper emails address, or a code	
		if (valid_email($to)) {
		
		    //email address
		    $sendTo = $to;
		    
		} else {
		
		    //code
		    
		    if( $this->emailmodel->getEmail($to) ) {
		    
		    	$sendTo = $this->emailmodel->getEmail($to);
		    
		    } else {
		    
		    	$temp = array();
		    	$temp['error_message_heading'] = "Ouch!";
		    	$temp['error_message'] = "<small>It appears the email ID used to submit the data to is invalid. Please contact <a href='mailto:".$this->config->item('admin_email')."'>".$this->config->item('admin_email')."</a></small>";
		    	
		    	$temp['alert_type'] = "error";
		    		
		    	if( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] != '' ) {
		    		$temp['error_message'] .= "<br><a href='".$_SERVER['HTTP_REFERER']."' class='btn btn-primary btn-block'><span class='fui-arrow-left'></span> Go back</a>";
		    	}
		    					
		    	die( $this->load->view('alert', array('data'=>$temp), true) );
		    
		    }

		}
		
		
		//make sure this email address is active
		
		if( $this->emailmodel->isDisabled($sendTo) ) {
		
			$temp = array();
			$temp['error_message_heading'] = "Ouch!";
			$temp['error_message'] = "<small>The recipient of this form data has not been authorized by the API administrator. Please contact <a href='mailto:".$this->config->item('admin_email')."'>".$this->config->item('admin_email')."</a></small>";
			
			$temp['alert_type'] = "error";
				
			if( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] != '' ) {
				$temp['error_message'] .= "<br><a href='".$_SERVER['HTTP_REFERER']."' class='btn btn-primary btn-block'><span class='fui-arrow-left'></span> Go back</a>";
			}
							
			die( $this->load->view('alert', array('data'=>$temp), true) );
		
		}
		
		    
		//SPAM word check
		    
		if( $this->config->item("spam_words") != '' && count( $this->config->item('spam_words') ) > 0 ) {
		    
			if( $this->datamodel->spamCheck($_REQUEST) ) {
		    	
		    	
		    	
		    } else {
		    	
		    	//report caught spam?
		    	
		    	
		    	$this->submissionmodel->store($_REQUEST, "word filter");
		    	
		    	
		    	$temp = array();
		    	$temp['error_message_heading'] = "Ouch!";
		    	$temp['error_message'] = "<small>It appears you're data contain words or phrases which were caught in the SPAM filter. Please try reviewing your data and submitting it again.</small>";
		    	
		    	$temp['alert_type'] = "error";
		    		
		    	if( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] != '' ) {
		    		$temp['error_message'] .= "<br><a href='".$_SERVER['HTTP_REFERER']."' class='btn btn-primary btn-block'><span class='fui-arrow-left'></span> Go back</a>";
		    	}
		    					
		    	die( $this->load->view('alert', array('data'=>$temp), true) );
		    	
		    }
		    		    
		}
		
		
		//SPAM honey pot check
		
		if( isset($_REQUEST['_honey']) && $_REQUEST['_honey'] != '' ) {
		
			$this->submissionmodel->store($_REQUEST, "honey pot");
			
			//this is not right
			$temp = array();
			$temp['error_message_heading'] = "Ouch!";
			$temp['error_message'] = "<small>Our API has identified the submitted data as being entered by a bot and can therefor not process the data.</small>";
			
			$temp['alert_type'] = "error";
				
			if( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] != '' ) {
				$temp['error_message'] .= "<br><a href='".$_SERVER['HTTP_REFERER']."' class='btn btn-primary btn-block'><span class='fui-arrow-left'></span> Go back</a>";
			}
							
			die( $this->load->view('alert', array('data'=>$temp), true) );
		
		}
		
		
		//apply xss_clean filter
		
		foreach( $_REQUEST as $key=>$value ) {
		
			if( substr($key, 0, 1) != "_" && $key != "ci_session" && strpos($key,'wp-') === false ) {
			
				//echo $value." => ".$this->security->xss_clean($value)."<br>";
				
				$_REQUEST[$key] = $this->security->xss_clean($value);//somehow, this is the only way xss filtering works
															
				if( isset($_REQUEST['_valid'][$key]) ) {
								
					$this->form_validation->set_rules($key, $key, "xss_clean|".$_REQUEST['_valid'][$key]);
									
				} else {
							    		
					$this->form_validation->set_rules($key, $key, "xss_clean");
									
				}
			
			}
		
		}
								
		if ($this->form_validation->run() == FALSE) {
				
			//fail		    						    				
			$temp = array();
			$temp['error_message_heading'] = "Ouch!";
			$temp['error_message'] = "<small>Something is not right with the data you've submitted, please see the details below:</small><br>".validation_errors();
			
			$temp['alert_type'] = "error";
				
			if( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] != '' ) {
				$temp['error_message'] .= "<br><a href='".$_SERVER['HTTP_REFERER']."' class='btn btn-primary btn-block'><span class='fui-arrow-left'></span> Go back</a>";
			}
							
			die( $this->load->view('alert', array('data'=>$temp), true) );
						    			
		} else {
			
			//pass
			//$this->load->view('formsuccess');
					
		}
			
			
		//is the email address verified?
					    		
		if( $this->emailmodel->isVerified($sendTo) == false ) {
			
			$verificationCode = $this->emailmodel->setVerification($sendTo);
			
			$this->email->from($this->config->item('email_from'), $this->config->item('email_from_name'));
			$this->email->to($sendTo);
			$this->email->subject("Sent API email address verification");
			
			$temp = array();
			$temp['verificationCode'] = $verificationCode;
			$temp['url'] = $this->config->item('base_url');
			
			$this->email->message( $this->load->view('email_confirmation/confirmation', $temp, true) );
			
			$this->email->send();
			
			if( $this->config->item('debug_verification') ) {
			
				echo $this->email->print_debugger();
			
			}
				
			$temp = array();
			$temp['error_message_heading'] = "Please verify your email address";
			$temp['error_message'] = "<small>The email address <b>".$sendTo."</b> needs to be verified before it can receive emails from Sent API. Please check your inbox for the verification email and click the link within this email to verify your address.<br><br>Once you have verified the email address, please return to the previous page and submit the form again or click the 're-submit form' button.<br><a href='javascript:location.reload()' class='btn btn-info btn-embossed btn-block'>re-submit the form</a></small>";
			
			if( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] != '' ) {
				$temp['error_message'] .= "<div class='text-center'>Or</div><a href='".$_SERVER['HTTP_REFERER']."' class='btn btn-primary btn-block'><span class='fui-arrow-left'></span> Go back</a>";
			}
			
			$temp['alert_type'] = "info";
			
			die( $this->load->view('alert', array('data'=>$temp), true) );
			
		}
		
		
		//do we have a file upload to take care off?
								
		if( isset($_FILES['file']) && $_FILES['file']['name'] != '' ) {
		
			if ( ! $this->upload->do_upload("file")) {
								
				$temp = array();
				$temp['error_message_heading'] = "Ouch!";
				$temp['error_message'] = "<small>Something went wrong with the file you are trying to send. Please see the error(s) below:</small><br>".$this->upload->display_errors();
				
				$temp['alert_type'] = "error";
					
				if( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] != '' ) {
					$temp['error_message'] .= "<br><a href='".$_SERVER['HTTP_REFERER']."' class='btn btn-primary btn-block'><span class='fui-arrow-left'></span> Go back</a>";
				}
								
				die( $this->load->view('alert', array('data'=>$temp), true) );
			
			} else {
			
				$fileData = $this->upload->data();
								
				//setup the attachment
				$this->email->attach( $fileData['full_path'] );
				
				//delete or save attachement
				
				if( $this->config->item('email_save_attachments') == false ) {
								
					$removeAttachment = $fileData['full_path'];
				
				} 
									
			}
		
		}
		
		
		//cc?
		if( isset($_REQUEST['cc']) ) {
		
			print_r( $_REQUEST['cc'] );
		
			$this->email->cc( $_REQUEST['cc'] );
		
		}
		
		
		//bcc?
		if( isset($_REQUEST['bcc']) ) {
		
			print_r( $_REQUEST['bcc'] );
		
			$this->email->bcc( $_REQUEST['bcc'] );
		
		}
			
				    				    		
		$this->email->from($this->config->item('email_from'), $this->config->item('email_from_name'));
		$this->email->to($sendTo); 
			
		//subject
		if( isset($_REQUEST['_subject']) && $_REQUEST['_subject'] != '' ) {
			
			$this->email->subject($_REQUEST['_subject']);
				
		} else {
			
			$this->email->subject($this->config->item('email_default_subject'));
				
		}
			
		//reply to
			
		if( isset($_REQUEST['_replyto']) && $_REQUEST['_replyto'] != '' ) {
		
			if( substr($_REQUEST['_replyto'], 0, 1) == "%" ) {
			
				$replyTo = ltrim($_REQUEST['_replyto'],'%');
				
				if( isset($_REQUEST[$replyTo]) && $_REQUEST[$replyTo] != '' ) {
			
					$this->email->reply_to($_REQUEST[$replyTo]);
				
				} else {
				
					$this->email->reply_to($_REQUEST['_replyto']);
				
				}
			
			} else {
			
				$this->email->reply_to($_REQUEST['_replyto']);
			
			}
			
		}
			
		if( $this->email->mailtype == 'html' ) {
			
			$this->email->message( $this->load->view('emails/default', $_REQUEST, true) );
						    			
			//$this->load->view('emails/default', $_REQUEST);
			
		} else {
			
			$this->email->message( $this->load->view('emails/text', $_REQUEST, true) );
			
		}
		
		//send API email
		$this->email->send();
		
		if( $this->config->item('debug_main') ) {
		
			echo $this->email->print_debugger();
		
		}
		
		
		//clean up attachment?
		
		if( isset($removeAttachment) ) {
		
			unlink( $removeAttachment );
		
		}
		
		
		//save submission
		$this->submissionmodel->store($_REQUEST);
					
		//echo $this->email->print_debugger();
		
		$this->email->clear();
		
		
		//should we send a confirmation to the user?
		
		if( $this->config->item("email_confirmation") != '' && $this->config->item("email_confirmation_subject") != '' && isset($_REQUEST['email']) && $_REQUEST['email'] != '' ) {
		
			$this->email->from($this->config->item('email_from'), $this->config->item('email_from_name'));
			$this->email->to($_REQUEST['email']);
			$this->email->subject($this->config->item("email_confirmation_subject"));
			
			$message = $this->config->item("email_confirmation");
						
			foreach( $_REQUEST as $key=>$value ) {
			
				if( substr($key, 0, 1) != "_" && $key != "ci_session" && strpos($key,'wp-') === false ) {
				    		
					$message = str_replace("%".$key."%", $value, $message);
					
				}				
			
			}
			
			$this->email->message( $message );
			
			$this->email->send();
			
			//echo $this->email->print_debugger();
		
		}
		
			
		//redirect after sending email?
			
		if( isset($_REQUEST['_after']) && $_REQUEST['_after'] != '' ) {
			
			if (filter_var($_REQUEST['_after'], FILTER_VALIDATE_URL)) {
			
				redirect($_REQUEST['_after'], 'location');
				
			} else {
					
				//fail		    						    				
				$temp = array();
				$temp['error_message_heading'] = "Ouch!";
				$temp['error_message'] = "<small>It seems  an invalud redirection URL has been specified. We can't not redirect you to</small><br>".$_REQUEST['_after'];
				
				$temp['alert_type'] = "error";
					
				if( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] != '' ) {
					$temp['error_message'] .= "<br><a href='".$_SERVER['HTTP_REFERER']."' class='btn btn-primary btn-block'><span class='fui-arrow-left'></span> Go back</a>";
				}
								
				die( $this->load->view('alert', array('data'=>$temp), true) );
					
			}
			
		} else {
			
			//no redirection given, display confirmation message
			
			$temp = array();
			$temp['error_message_heading'] = "Success!";
			
			if( isset($_REQUEST['_confirmation']) && $_REQUEST['_confirmation'] != '' ) {
			
				$temp['error_message'] = "<small>".$_REQUEST['_confirmation']."</small>";
			
			} else {
			
				$temp['error_message'] = "<small>".$this->config->item('email_confirmation_message')."</small>";
			
			}
			
			if( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] != '' ) {
				$temp['error_message'] .= "<br><a href='".$_SERVER['HTTP_REFERER']."' class='btn btn-primary btn-block'><span class='fui-arrow-left'></span> Go back</a>";
			}
			
			$temp['alert_type'] = "success";
			
			$this->session->set_flashdata('message', $temp);
						
			redirect( site_url("api/sent") );
			
		}
		
		
	}
}

/* End of file api.php */
/* Location: ./application/controllers/api.php */