<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
                
    }
    
    /*
    	load the dynamic configuration
    */
    
    public function loadConfig()
    {
    
    	$query = $this->db->get('config');
    	
    	$res = $query->result();
    	
    	foreach( $res[0] as $key => $value ) {
    	
    		if( $value == 'true' ) {
    		
    			$this->config->set_item($key, true);
    		
    		} elseif( $value == 'false' ) {
    		
    			$this->config->set_item($key, false);
    		
    		} elseif( $key == 'spam_words' ) {
    		
    			$this->config->set_item($key, json_decode($value, true));
    		
    		} else {
    	
    			$this->config->set_item($key, $value);
    		
    		}
    	
    	}
    
    }
    
    
    /*
    	saves configuration data
    */
    
    public function update($data)
    {
    
    	$ddata = array(
    		'admin_email' => $data['admin_email'],
    	    'email_confirmation_message' => $data['email_confirmation_message'],
    	 	'email_from' => $data['email_from'],
    	 	'email_from_name' => $data['email_from_name'],
    	 	'email_default_subject' => $data['email_default_subject'],
    	 	'email_confirmation' => $data['email_confirmation'],
    	 	'email_confirmation_subject' => $data['email_confirmation_subject']
 		);
 		
 		//spam words
 		 		
 		if( $data['spam_words'] != '' ) {
 		
 			$tempArr = explode("
", $data['spam_words']);

			$ddata['spam_words'] = json_encode($tempArr);
 		
 		} else {
 		
 			$ddata['spam_words'] = '';
 		
 		}
 		
 		//private API
 		
 		if( isset($data['private']) ) {
 		
 			if( $data['private'] == 'yes' ) {
 			
 				$ddata['private_api'] = 'true';
 			
 			} else {
 			
 				$ddata['private_api'] = 'false';
 			
 			}
 		
 		} else {
 		
 			$ddata['private_api'] = 'false';
 		
 		}
 		
 		//save attachments?
 		
 		if( isset($data['email_save_attachments']) ) {
 		
 			if( $data['email_save_attachments'] == 'yes' ) {
 			
 				$ddata['email_save_attachments'] = 'true';
 			
 			} else {
 			
 				$ddata['email_save_attachments'] = 'false';
 			
 			}
 		
 		} else {
 		
 			$ddata['email_save_attachments'] = 'false';
 		
 		}
 		
 		//debug verification
 		
 		if( isset($data['debug_verification']) ) {
 		
 			if( $data['debug_verification'] == 'yes' ) {
 			
 				$ddata['debug_verification'] = 'true';
 			
 			} else {
 			
 				$ddata['debug_verification'] = 'false';
 			
 			}
 		
 		} else {
 		
 			$ddata['debug_verification'] = 'false';
 		
 		}
 		
 		
 		//debug main email
 		
 		if( isset($data['debug_main']) ) {
 		
 			if( $data['debug_main'] == 'yes' ) {
 			
 				$ddata['debug_main'] = 'true';
 			
 			} else {
 			
 				$ddata['debug_main'] = 'false';
 			
 			}
 		
 		} else {
 		
 			$ddata['debug_main'] = 'false';
 		
 		}
 		
 		//print_r($ddata);
 		
 		//die();
 		
    	
    	$this->db->where('config_id', "1");
    	$this->db->update('config', $ddata);
    	
    	//die($this->db->last_query());
    
    }
    
}