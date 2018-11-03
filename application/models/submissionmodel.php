<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Submissionmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        
        //dynamic configuration
        
        $this->load->model('configmodel');
        
        $this->configmodel->loadConfig();
                
    }
    
    /*
    	stores a submission in the database
    */
    
    public function store($data, $spam = 0)
    {
    
    	$formData = array();
    	
    	foreach( $data as $key=>$value ) {
    	
    		if( substr($key, 0, 1) != "_" && $key != "ci_session" && strpos($key,'wp-') === false && $key != 'cc' && $key != 'bcc' ) {
    		    		
    			$formData[$key] = $value;
    		
    		}
    	
    	}
    	
    	$formDataJson = json_encode($formData);
    	    	
    	$data = array(
    	   'submissions_time' => time(),
    	   'submissions_date' => date("Y-m-d"),
    	   'submissions_ip' => $this->input->ip_address(),
    	   'submissions_useragent' => $this->input->user_agent(),
    	   'submissions_data' => $formDataJson,
    	   'submissions_spam' => $spam
    	);
    	
    	$this->db->insert('submissions', $data); 
    	
    	return true;
    
    }
    
    
    /*
    	retrieve submissions
    */
    
    public function getEm($start, $perpage, $filter, $search)
    {
        
    	if( $filter == 'all' ) {
    
    		$this->db->from('submissions')->order_by('submissions_time', 'desc')->limit($perpage, $start);
    	
    	} elseif( $filter == 'spam' ) {
    	
    		$query = $this->db->from('submissions')->order_by('submissions_time', 'desc')->where('submissions_spam !=', '0')->limit($perpage, $start);
    	
    	} else {
    		
    		$this->db->from('submissions')->order_by('submissions_time', 'desc')->limit($perpage, $start);
    	
    	}
    	
    	if( $search != false ) {
    	
    		$this->db->where("(`submissions_ip` LIKE '%$search%' OR `submissions_useragent` LIKE '%$search%' OR `submissions_data` LIKE '%$search%' OR `submissions_spam` LIKE '%$search%') OR `submissions_date` LIKE '%$search%'");
    	
    		/*$this->db->or_like('submissions_ip', $search);
    		$this->db->or_like('submissions_useragent', $search);
    		$this->db->or_like('submissions_data', $search);
    		$this->db->or_like('submissions_spam', $search);*/
    	
    	}
    	
    	$query = $this->db->get();
    	
    	//echo $this->db->last_query();
    	    	
    	return $query->result();
    
    }
    
    
    /*
    	retrieve all submissions
    */
    
    public function getTotal($filter, $search)
    {
    	
    	if( $filter == 'all' ) {
    	
    		$this->db->from('submissions');
    	
    	} elseif( $filter == 'spam' ) {
    	
    		 $this->db->from('submissions')->where('submissions_spam !=', '0');
    	
    	} else {
    	
    		$this->db->from('submissions');
    	
    	}
    	
    	if( $search != false ) {
    	
    		$this->db->where("(`submissions_ip` LIKE '%$search%' OR `submissions_useragent` LIKE '%$search%' OR `submissions_data` LIKE '%$search%' OR `submissions_spam` LIKE '%$search%')");
    		    	
    	}
    	
    	$query = $this->db->get();
    	
    	return $query->num_rows();
    
    }
    
    
    /*
    	deletes a submission
    */
    
    public function deleteSubmission($id)
    {
    
    	$this->db->where('submissions_id', $id);
    	$this->db->delete('submissions'); 
    
    }
    
    
    /*
    	deletes a number of submissions
    */
    
    public function deleteSubmissions($data)
    {
    
    	foreach( $data as $id ) {
    	
    		$this->db->or_where('submissions_id', $id);
    	
    	}
    	
    	$this->db->delete('submissions'); 
    
    }
    
}