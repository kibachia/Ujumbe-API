<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ujumbe API Alert</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Loading Bootstrap -->
    <link href="<?php echo $this->config->item('base_url');?>bootstrap/css/bootstrap.css" rel="stylesheet">
    
    <!-- Loading Flat UI -->
    <link href="<?php echo $this->config->item('base_url');?>css/flat-ui.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url');?>css/style.css" rel="stylesheet">
    
    <link rel="shortcut icon" href="<?php echo $this->config->item('base_url');?>images/favicon.ico">
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="<?php echo $this->config->item('base_url');?>js/html5shiv.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	
    <div class="container">
        
    	<div class="row">
    	
    		<br>
    		
    		<div class="col-md-offset-3 col-md-6">
    		
    			<?php 
    			
    				if( $data['alert_type'] == 'error' ) {
    					
    					$this->load->view("partials/message_error", $data);
    				
    				} elseif( $data['alert_type'] == 'info' ) {
    				
    					$this->load->view("partials/message_info", $data);
    				
    				} elseif( $data['alert_type'] == 'success' ) {
    				
    					$this->load->view("partials/message_success", $data);
    				
    				}
    				
    			?>
    			
    			<p class="small text-center">Ujumbe API - The form submit API</p>
    			
    		</div><!-- /.col-md-12 -->
    	</div>
    </div>
    <!-- /.container -->

  </body>
</html>
