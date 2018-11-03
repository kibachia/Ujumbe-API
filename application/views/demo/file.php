<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>File Demo | Sent API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="<?php echo $this->config->item('base_url')?>bootstrap/css/bootstrap.css" rel="stylesheet">
    
    <!-- Loading Flat UI -->
    <link href="<?php echo $this->config->item('base_url')?>css/flat-ui.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url')?>css/setup.css" rel="stylesheet">
    
    <link rel="shortcut icon" href="<?php echo $this->config->item('base_url')?>images/favicon.ico">
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="<?php echo $this->config->item('base_url')?>js/html5shiv.js"></script>
      <script src="<?php echo $this->config->item('base_url')?>js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	
	<div class="container setup">
	
		<header>
			
			<div class="row">
			
				<div class="col-md-6">
					
					<h3>
						<img src="<?php echo $this->config->item('base_url')?>images/icons/mail2.svg" src="Sent. API">
						Sent. <small>File Demo</small>
					</h3>
				
				</div><!-- /.col-md-6 -->
				
				<div class="col-md-6">
				
					<div class="text-right margin-top-32 margin-bottom-0 apiUrl clearfix">
						<pre class="pull-right"><code><b><?php echo site_url('/api');?></b></code></pre>
						<p class="pull-right lead">
							Your API url: 
						</p>
					</div>
				
				</div><!-- /.col-md-6 -->
			
			</div><!-- /.row -->
			
			<hr>
			
			<div class="row">
			
				<div class="col-md-12">
				
					<ul class="nav nav-tabs nav-append-content sample-tabs">
    					<li class="active"><a href="#form">The Form</a></li>
    					<li><a href="#code">The Code</a></li>
   					</ul> <!-- /tabs -->
    				
    				<div class="tab-content">
    				
    					<div class="tab-pane active" id="form">
    					
    						<hr>
    						
    						<h4>The form</h4>
    						    					
    						<div class="row margin-bottom-15">
    						
    							<div class="col-md-9">
    							
    								<p>
    									This form includes an file upload field. The uploaded file will be attached to the email by the Sent API.
    								</p>
    								
    								<div class="alert alert-info">
    									<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    								 	<p class="margin-bottom-10">Please enter an email address to which the form data should be send:</p>
    								 	<div class="form-group">
    								 		<input type="email" class="form-control" id="email_" name="email_" placeholder="Your email">
    								 	</div>
    								</div>
    					
    								<form enctype="multipart/form-data" method="post" action="<?php echo site_url('/api');?>" id="form">
    									<div class="form-group">
    						    			<input type="text" class="form-control" id="name" name="name" placeholder="Your name">
    						  			</div>
    						  			<div class="form-group">
    						    			<input type="email" class="form-control" id="email" name="email" placeholder="Your email">
    						  			</div>
    						  			<div class="form-group">
    						  	  			<textarea  class="form-control" name="message" id="message" rows="3" placeholder="Your message"></textarea>
    						  			</div>
    						  			<div class="form-group">
    						  				<div class="fileinput fileinput-new" data-provides="fileinput">
    						  					<div class="input-group">
    						  						<div class="form-control uneditable-input" data-trigger="fileinput">
    						  							<span class="fui-clip fileinput-exists"></span>
    						  							<span class="fileinput-filename"></span>
    						  						</div>
    						  						<span class="input-group-btn btn-file">					    	
    						  							<span class="btn btn-default fileinput-new" data-role="select-file">Select file</span>
    						  							<span class="btn btn-default fileinput-exists" data-role="change"><span class="fui-gear"></span>&nbsp;&nbsp;Change</span>
    						  							<input type="file" name="file">
    						  							<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span>&nbsp;&nbsp;Remove</a>					    	
    						  						</span>					    
    						  					</div>
    						  				</div>
    						  			</div>
    						  			<button type="submit" id="submit" class="btn btn-primary btn-embossed disabled">Please enter a valid email address to send the email to</button>
    								</form>
    							
    							</div>
    						
    						</div><!-- /.row -->
    						
    					</div><!-- /.tab-pane -->
    					
    					<div class="tab-pane" id="code">
    					
    						<hr>
    						
    						<h4>The code</h4>
    						
    						<div class="margin-bottom-15">
    						
<pre><code class="smaller">&lt;form method="post" action="//yourdomain.com/api/johndoe@gmail.com" method="post"&gt;
    &lt;input type="hidden" name="_valid[name]" value="required"&gt;
    &lt;input type="hidden" name="_valid[email]" value="required|valid_email"&gt;
    &lt;input type="hidden" name="_valid[message]" value="required"&gt;
    &lt;input type="text" name="name" placeholder="Your name"&gt;
    &lt;input type="email" name="email" placeholder="Your email"&gt;
    &lt;textarea  name="message" rows="3" placeholder="Your message">&lt;/textarea&gt;
    &lt;button type="submit" class="btn btn-primary btn-embossed disabled">Submit Form&lt;/button&gt;
&lt;/form&gt;</code></pre>
    						
    						</div>
    					
    					</div><!-- /.tab-pane -->
    				    				    					
   					</div> <!-- /tab-content -->
				
				</div><!-- /.col-md-12 -->
				
			</div><!-- /.row -->
			
		</header>
	
	</div><!-- /.container -->
	
<!-- Load JS here for greater good =============================-->
<script src="<?php echo $this->config->item('base_url')?>js/jquery-1.8.3.min.js"></script>
<script src="<?php echo $this->config->item('base_url')?>js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $this->config->item('base_url')?>js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo $this->config->item('base_url')?>js/bootstrap.min.js"></script>
<script src="<?php echo $this->config->item('base_url')?>js/bootstrap-select.js"></script>
<script src="<?php echo $this->config->item('base_url')?>js/bootstrap-switch.js"></script>
<script src="<?php echo $this->config->item('base_url')?>js/flatui-checkbox.js"></script>
<script src="<?php echo $this->config->item('base_url')?>js/flatui-radio.js"></script>
<script src="<?php echo $this->config->item('base_url')?>js/flatui-fileinput.js"></script>
<script src="<?php echo $this->config->item('base_url')?>js/jquery.tagsinput.js"></script>
<script src="<?php echo $this->config->item('base_url')?>js/jquery.placeholder.js"></script>
<script>
$(function(){

	var API_URL = "<?php echo site_url('/api');?>/";

	// Tabs
	$(".nav-tabs a").on('click', function (e) {
		e.preventDefault();
	  	$(this).tab("show");
	})
	
	$('body').on("keyup", "#email_", function(){
	
		if( validateEmail( $(this).val() ) ) {
		
			$('button#submit').removeClass('disabled').text("Submit Form");
			
			$('form#form').attr('action', API_URL+$('#email_').val());
		
		} else {
		
			$('button#submit').addClass('disabled').text("Please enter a valid email address to send the email to");
		
		}
	
	});
	
	
	function validateEmail(email) { 
	    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(email);
	}
	
	
	$('form#form').submit(function(){
	
		if( !validateEmail( $('#email_').val() ) ) {
		
			alert('Please enter a valid email adrdess to send the form data to.');
			
			return false;
		
		} else {
					
			return true;
		
		}
	
	})
	
})
</script>
</body>
</html>