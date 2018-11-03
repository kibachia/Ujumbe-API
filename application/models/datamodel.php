<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datamodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        
        //dynamic configuration
        
        $this->load->model('configmodel');
        
        $this->configmodel->loadConfig();
                
    }
    
    /*
    	looks for spam words and returns false if found, true if not found
    */
    
    public function spamCheck($data)
    {
    
    	foreach( $data as $key=>$value ) {
    	
    		if( substr($key, 0, 1) != "_" && $key != "ci_session" && strpos($key,'wp-') === false && $key != 'cc' && $key != 'bcc' ) {
    		    		
    			foreach( $this->config->item("spam_words") as $spamWord ) {
    			    			
    				if (strpos($value, $spamWord) !== false) {
    				    				    
    				    return false;
    				
    				}
    			
    			}
    		
    		}
    	
    	}
    	
    	return true;
    
    }
    
    
    /*
    	returns false if all fields are empty
    */
    
    public function allEmpty($data) {
    
    	$allEmpty = true;
    
    	foreach( $data as $key=>$value ) {
    	
    		if( substr($key, 0, 1) != "_" && $key != "ci_session" && strpos($key,'wp-') === false && $key != 'cc' && $key != 'bcc' ) {
    		    		
    			if( $value != '' ) {
    			
    				$allEmpty = false;
    			
    			}
    		
    		}
    	
    	}
    	
    	return $allEmpty;
    
    }
    
}