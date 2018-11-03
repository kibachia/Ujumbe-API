<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emailmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->helper('string');
        
        //dynamic configuration
        
        $this->load->model('configmodel');
        
        $this->configmodel->loadConfig();
                
    }
    
    /*
    	registers a new email address with the service
    */
    
    public function registerEmail($email)
    {
    	
    	//create unique email code
    	$emailCode = random_string('alnum', 20);
    	
    	if( $this->config->item('private_api') == false ) {
    	
    		$data = array(
    				'emails_email' => $_POST['email'],
    				'emails_code' => $emailCode,
    				'emails_active' => '1'
    		);
    	
    	} else {
    	
    		$data = array(
    	   		'emails_email' => $_POST['email'],
    	   		'emails_code' => $emailCode
    		);
    	
    	}
    	
    	$this->db->insert('emails', $data);
    	
    	//return the code
    	
    	$emailID = $this->db->insert_id();
    	
    	$query = $this->db->from('emails')->where('emails_id', $emailID)->get();
    	
    	$res = $query->result();
    	
    	return $res[0]->emails_code;
    
    }
    
    
    /*
    	masks an email address with a unqiue code
    */
    
    public function maskEmail($email)
    {
    
    	$query = $this->db->from('emails')->where('emails_email', $email)->where('emails_code !=', '')->get();
    	
    	if( $query->num_rows() > 0 ) {
    	
    		//already has a code, return it
    		
    		$res = $query->result();
    		
    		return $res[0]->emails_code;
    	
    	} else {
    	
    		//does the email address exist?
    		
    		$query = $this->db->from('emails')->where('emails_email', $email)->get();
    		
    		if( $query->num_rows() > 0 ) {
    		
    			//email address exists, give it a code
    			
    			$res = $query->result();
    			
    			$emailCode = random_string('alnum', 20);
    			
    			$data = array(
    			   'emails_code' => $emailCode
    			);
    			
    			$this->db->where('emails_id', $res[0]->emails_id);
    			$this->db->update('emails', $data);
    			
    			return $emailCode;
    		
    		} else {
    		
    			//we've got nothing
    			
    			$emailCode = random_string('alnum', 20);
    			
    			if( $this->config->item('private_api') == false ) {
    			
    				$data = array(
    			   		'emails_email' => $_POST['email'],
    			   		'emails_code' => $emailCode,
    			   		'emails_active' => "1"
    				);
    			
    			} else {
    			
    				$data = array(
    					'emails_email' => $_POST['email'],
    					'emails_code' => $emailCode
    				);
    			
    			}
    			
    			$this->db->insert('emails', $data);
    			
    			return $emailCode;
    		
    		}
    	
    	}
    
    }
    
    
    /*
    	checks to see if this email address has already been registered with this service
    */
    
    public function checkEmail($email) 
    {
    
    	$query = $this->db->from('emails')->where('emails_email', $email)->get();
    	
    	if( $query->num_rows() > 0 ) {
    	
    		//already registered
    		return false;
    	
    	} else {
    	
    		//all good
    		return true;
    	
    	}
    
    }
    
    
    /*
    	returns the code for an email address
    */
    
    public function getCode($email)
    {
    
    	$query = $this->db->from('emails')->where('emails_email', $email)->where('emails_code !=', ' ')->get();
    	  
    	$result = $query->result();
    	    	    	  			
		if( count($result) > 0 ) {
					
			return $result[0]->emails_code;
		
		} else {
						
			return false;
		
		}
    
    }
    
    
    /*
    	returns email address for a given code
    */
    
    public function getEmail($code)
    {
    
    	$query = $this->db->from('emails')->where('emails_code', $code)->get();
    	    	    	
    	if( $query->num_rows() > 0 ) {
    	
    		$result = $query->result();
    		
    		return $result[0]->emails_email;
    	
    	} else {
    	
    		return false;
    	
    	}
    
    }
    
    
    /*
    	checks if an email address has been verified
    */
    
    public function isVerified($email)
    {
    
    	$query = $this->db->from('emails')->where('emails_email', $email)->where('emails_verified', "1")->get();
    	
    	if( $query->num_rows() > 0 ) {
    	
    		return true;
    	
    	} else {
    	
    		return false;
    	
    	}
    
    }
    
    
    /*
    	sets the verification for an email address
    */
    
    public function setVerification($email)
    {
    
    	$randomString = random_string('alnum', 16);
    	
    	$hash = md5($randomString);
    	
    	if( !$this->checkEmail($email) ) {
    	
    		//does this email has a verification code set?
    		
    		$query = $this->db->from('emails')->where('emails_email', $email)->where('emails_verification_code !=', '')->get();
    		
    		if( $query->num_rows() == 0 ) { 
    	
    			//already exists
    			$data = array(
    				'emails_verification_code' => $hash,
   				);
    		
    			$this->db->where('emails_email', $email);
    			$this->db->update('emails', $data);
    			
    			return $hash;
    		
    		} else {
    		
    			//return existing verification code
    			
    			$result = $query->result();
    			
    			return $result[0]->emails_verification_code;
    		
    		}
    	
    	} else {
    		
    		//does not exist yet
    		
    		if( $this->config->item('private_api') == false ) {
    		
    			$data = array(
    		   		'emails_email' => $email,
    		   		'emails_verification_code' => $hash,
    		   		'emails_active' => "1"
    			);
    		
    		} else {
    		
    			$data = array(
    				'emails_email' => $email,
    				'emails_verification_code' => $hash
    			);
    		
    		}
    		
    		$this->db->insert('emails', $data);
    		
    		return $hash;
    	
    	}
    
    }
    
    
    /*
    	checks the code and sets email to verified if correct
    */
    
    public function confirmEmail($code)
    {
    
    	$query = $this->db->from('emails')->where('emails_verification_code', $code)->get();
    	    	
    	if( $query->num_rows() > 0 ) {
    	
    		$temp = $query->result();
    	
    		$data = array(
    			'emails_verified' => "1"
    		);
    		
    		$this->db->where('emails_verification_code', $code);
    		$this->db->update('emails', $data);
    		
    		return $temp[0]->emails_email;
    	
    	} else {
    	
    		return false;
    	
    	}
    
    }
    
    
    /*
    	grab us some emails from the db
    */
    
    public function getEm($start, $perpage, $filter, $search)
    {
    	
    	if( $filter == 'all' ) {
    	
    		$this->db->from('emails')->order_by('emails_email')->limit($perpage, $start);
    		
    	} elseif( $filter == 'verified' ) {
    		
    		$query = $this->db->from('emails')->order_by('emails_email')->where('emails_verified', '1')->limit($perpage, $start);
    		
    	} elseif( $filter == 'notverified' ) {
    		
    		$query = $this->db->from('emails')->order_by('emails_email')->where('emails_verified', '0')->limit($perpage, $start);
    		
    	} elseif( $filter == 'active' ) {
    		
    		$query = $this->db->from('emails')->order_by('emails_email')->where('emails_active', '1')->limit($perpage, $start);
    		
    	} elseif( $filter == 'notactive' ) {
    		
    		$query = $this->db->from('emails')->order_by('emails_email')->where('emails_active', '0')->limit($perpage, $start);
    		
    	} else {
    			
    		$this->db->from('emails')->order_by('emails_email')->limit($perpage, $start);
    		
    	}
    	
    	
    	if( $search != false ) {
    	
    		$this->db->where("(`emails_email` LIKE '%$search%' OR `emails_code` LIKE '%$search%' OR `emails_verification_code` LIKE '%$search%')");
    	    	
    	}
    
    	
    	$query = $this->db->get();
    	
    	return $query->result();
    
    }
    
    
    /*
    	returns the total number of emails
    */
    
    public function getTotal($filter, $search)
    {
    
    	if( $filter == 'all' ) {
    	
    		$this->db->from('emails')->order_by('emails_email');
    		
    	} elseif( $filter == 'verified' ) {
    		
    		$query = $this->db->from('emails')->order_by('emails_email')->where('emails_verified', '1');
    		
    	} elseif( $filter == 'notverified' ) {
    		
    		$query = $this->db->from('emails')->order_by('emails_email')->where('emails_verified', '0');
    		
    	} elseif( $filter == 'active' ) {
    		
    		$query = $this->db->from('emails')->order_by('emails_email')->where('emails_active', '1');
    		
    	} elseif( $filter == 'notactive' ) {
    		
    		$query = $this->db->from('emails')->order_by('emails_email')->where('emails_active', '0');
    		
    	} else {
    			
    		$this->db->from('emails')->order_by('emails_email');
    		
    	}
    	
    	
    	if( $search != false ) {
    	
    		$this->db->where("(`emails_email` LIKE '%$search%' OR `emails_code` LIKE '%$search%' OR `emails_verification_code` LIKE '%$search%')");
    	    	
    	}
    	
    	$query = $this->db->get();
    	
    	return $query->num_rows();
    
    }
    
    
    /*
    	deletes an email address
    */
    
    public function deleteEmail($id)
    {
    
    	$this->db->where('emails_id', $id);
    	$this->db->delete('emails'); 
    
    }
    
    
    /*
    	deletes a bunch of email addresses
    */
    
    public function deleteEmails($data)
    {
    
    	foreach( $data as $id ) {
    	
    		$this->db->or_where('emails_id', $id);
    	
    	}
    	
    	$this->db->delete('emails');
    
    }
    
    
    /*
    	enables/disables an email address
    */
    
    public function toggleEmail($email, $toggle)
    {
    
    	if( $toggle == 'on' ) {
    
    		$data = array(
    			'emails_active' => "1"
    		);
    	
    	} elseif( $toggle == 'off' ) {
    	
    		$data = array(
    			'emails_active' => "0"
    		);
    	
    	}
    	
    	$this->db->where('emails_email', $email);
    	$this->db->update('emails', $data); 
    
    }
    
    
    /*
    	returns true if this address is not active
    */
    
    public function isDisabled($email)
    {
    
    	$query = $this->db->from('emails')->where('emails_email', $email)->get();
    	
    	if( $query->num_rows() > 0 ) {
    	
    		$res = $query->result();
    	    	
    		if( $res[0]->emails_active == '0' ) {
    	
    			return true;
    	
    		} else {
    	
    			return false;
    	
    		}
    	
    	} else {
    	
    		return false;
    	
    	}
    
    }
    
}