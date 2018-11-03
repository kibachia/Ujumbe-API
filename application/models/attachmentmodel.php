<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attachmentmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->load->helper('file');
        $this->load->library('upload');
        
        //dynamic configuration
        
        $this->load->model('configmodel');
        
        $this->configmodel->loadConfig();
                
    }
    
    /*
    	returns a list of all attachments saved on the server
    */
    
    public function getEm()
    {
    
    	$files = get_dir_file_info($this->upload->upload_path, true);
    	
    	//die(print_r($files));
    	
    	return $files;
    
    }
    
    
    /*
    	deletes a bunch of attachments
    */
    
    public function deleteAttachments($data)
    {
    
    	foreach( $data as $file ) {
    	
    		unlink( $this->upload->upload_path.$file );
    	
    	}
    
    }
    
}