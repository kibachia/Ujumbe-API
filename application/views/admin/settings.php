<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ujumbe API Admin | Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="<?php echo $this->config->item('base_url');?>bootstrap/css/bootstrap_.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="<?php echo $this->config->item('base_url');?>css/flat-ui.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url');?>css/admin.css" rel="stylesheet">

    <link rel="shortcut icon" href="<?php echo $this->config->item('base_url');?>images/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="<?php echo $this->config->item('base_url');?>js/html5shiv.js"></script>
      <script src="<?php echo $this->config->item('base_url');?>js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    <div class="container">
    	
    	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    		<div class="container">
    			<div class="navbar-header">
    				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
    					<span class="sr-only">Toggle navigation</span>
    			 	</button>
   				</div>
    			<div class="collapse navbar-collapse" id="navbar-collapse-01">
    				<ul class="nav navbar-nav">			      
    					<li><a href="<?php echo site_url("admin/submissions");?>">Submissions</a></li>
    			    	<li><a href="<?php echo site_url("admin/emailids");?>">Email IDs</a></li>
    			    	<li><a href="<?php echo site_url('admin/attachments');?>">Attachments</a></li>
    				</ul> 		      
    				<ul class="nav navbar-nav navbar-right" style="margin-right: 0px;">
    					<li class="dropdown">
    			    		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administrator <b class="caret"></b></a>
    			    		<span class="dropdown-arrow"></span>
    			    		<ul class="dropdown-menu">
    			      			<li><a href="<?php echo site_url('admin/account');?>">Account</a></li>
    			      			<li><a href="<?php echo site_url('admin/settings');?>">Settings</a></li>
    			      			<li class="divider"></li>
    			      			<li><a href="<?php echo site_url('logout');?>">Logout</a></li>
    			    		</ul>
    			  		</li>
    			  		<li>
    			  			<a href="<?php echo site_url("logout");?>" class="no-right-padding">
    			  				<span class="fui-exit"></span>
    			  			</a>
    			  		</li>
    				</ul>
    			</div><!-- /.navbar-collapse -->
    		</div>
    	</nav><!-- /navbar -->
    	
    	<div class="row">
    		
    		<form action="<?php echo site_url("/admin/settings")?>" method="post">
    		
    		<div class="col-md-8 col-md-offset-2">
    		
    			<?php if( validation_errors() != '' ):?>
    			<div class="alert alert-error">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    			  	<?php echo validation_errors();?>
    			</div>
    			<?php endif;?>
    			
    			<?php if( $this->session->flashdata('item') != '' ):?>
    			<div class="alert alert-success">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    			  	<p>
    			  		Your settings have been successfully saved.
    			  	</p>
    			</div>
    			<?php endif;?>
    			
    			<div class="well">
    			
    				<h4>API Settings</h4>
    				
    				<hr>
    			
    				<div class="form-group">
    					<label for="private"><b>Private API</b></label>
    					<div class="form-group">
    				   		<input type="checkbox" name="private" id="private" value="yes" data-toggle="switch" <?php if( $this->config->item('private_api') ):?>checked<?php endif;?> />
    				   	</div>
    				   	<p class="help-block">
    				   		If set to "on", your API is private and new email addresses will need to be activated by the administrator before being able to receive form data.
    				   	</p>
    				</div>
    				
    				<div class="form-group">
    					<label for="admin_email"><b>Administrator email address</b> <span>*</span></label>
    					<div class="form-group">
    				   		<input type="email" class="form-control" name="admin_email" id="admin_email" placeholder="Administrator email address" value="<?php echo $this->config->item('admin_email');?>">
    				   	</div>
    				   	<p class="help-block small">
    				   		This is the email address shown to users within certain error messages. Please note that this email address can be different from the admin login.
    				   	</p>
    				</div>
    				
    				<div class="form-group">
    					<label for="email_confirmation_message"><b>Confirmation message</b> <span>*</span></label>
    					<div class="form-group">
    				   		<textarea class="form-control" rows="5" name="email_confirmation_message" id="email_confirmation_message" placeholder="Confirmation message"><?php echo $this->config->item('email_confirmation_message');?></textarea>
    				   	</div>
    				   	<p class="help-block small">
    				   		This is the confirmation message shown to users after they successfully submit a form. This message can be overwritten by specifying a custom confirmation using a hidden "_confirmation" field inside the form.
    				   	</p>
    				</div>
    			
    			</div><!-- /.well -->
    			
    			<div class="well">
    			
    				<h4>Email Settings</h4>
    				
    				<hr>
    				
    				<div class="form-group">
    					<label for="private"><b>Debug verification email</b></label>
    					<div class="form-group">
    				   		<input type="checkbox" name="debug_verification" id="debug_verification" value="yes" data-toggle="switch" <?php if( $this->config->item('debug_verification') ):?>checked<?php endif;?> />
    				   	</div>
    				   	<p class="help-block">
    				   		If you're having issues sending/receiving verification emails, you can turn debugging on. This will result in data being shown on the screen which will let you know if something is going wrong or not. This will happen right after a verification email is sent (meaning you'll need to submit a form).
    				   	</p>
    				</div>
    				
    				<div class="form-group">
    					<label for="private"><b>Debug main email</b></label>
    					<div class="form-group">
    				   		<input type="checkbox" name="debug_main" id="debug_main" value="yes" data-toggle="switch" <?php if( $this->config->item('debug_main') ):?>checked<?php endif;?> />
    				   	</div>
    				   	<p class="help-block">
    				   		If you're having issues sending/receiving the main API emails, you can turn debugging on. This will result in data being shown on the screen which will let you know if something is going wrong or not. This will happen right after an email is sent (meaning you'll need to submit a form).
    				   	</p>
    				</div>
    				
    				<div class="form-group">
    					<label for="email_from"><b>Emails sent from</b> <span>*</span></label>
    					<div class="form-group">
    				   		<input type="email" class="form-control" name="email_from" id="email_from" placeholder="Emails from" value="<?php echo $this->config->item('email_from');?>">
    				   	</div>
    				   	<p class="help-block small">
    				   		This email address will be used for the "from" field in your emails.
    				   	</p>
    				</div>
    				
    				<div class="form-group">
    					<label for="email_from_name"><b>Emails from name</b> <span>*</span></label>
    					<div class="form-group">
    				   		<input type="text" class="form-control" name="email_from_name" id="email_from_name" placeholder="Emails from name" value="<?php echo $this->config->item('email_from_name');?>">
    				   	</div>
    				   	<p class="help-block small">
    				   		This email address will be used for the "from" name field in your emails.
    				   	</p>
    				</div>
    				
    				<div class="form-group">
    					<label for="email_default_subject"><b>Default subject</b> <span>*</span></label>
    					<div class="form-group">
    				   		<input type="text" class="form-control" name="email_default_subject" id="email_default_subject" placeholder="Default subject" value="<?php echo $this->config->item('email_default_subject');?>">
    				   	</div>
    				   	<p class="help-block small">
    				   		This will be used as the default subject for emails containing the form data. This can be overwritten by setting a custom subject (using the hidden "_subject" field in the form).
    				   	</p>
    				</div>
    				
    				<div class="form-group">
    					<label for="email_confirmation"><b>Confirmation email</b> </label>
    					<div class="form-group">
    				   		<textarea class="form-control" name="email_confirmation" rows="10" id="email_confirmation" placeholder="Confirmation message"><?php echo $this->config->item('email_confirmation');?></textarea>
    				   	</div>
    				   	<p class="help-block small">
    				   		This is the default confirmation email sent to users submitting the form. If empty, no confirmation email will be send.
    				   	</p>
    				   	<p class="help-block small">
    				   		You can use other form data to populate the confirmation message, by including the form name enclosed by "%" characters. For example, you want to include the contents of a field named "email", you would use "%email%".
    				   	</p>
    				</div>
    				
    				<div class="form-group">
    					<label for="email_confirmation_subject"><b>Confirmation email subject</b> <span>*</span></label>
    					<div class="form-group">
    				   		<input type="text" class="form-control" name="email_confirmation_subject" id="email_confirmation_subject" placeholder="Default subject" value="<?php echo $this->config->item('email_confirmation_subject');?>">
    				   	</div>
    				   	<p class="help-block small">
    				   		This is the subject of the default confirmation email sent to users submitting the form.
    				   	</p>
    				</div>
    			
    			</div><!-- /.well -->
    			
    			<div class="well">
    			
    				<h4>Attachment Settings</h4>
    				
    				<hr>
    				
    				<div class="form-group">
    					<label for="email_save_attachments "><b>Store attachments on server</b></label>
    					<div class="form-group">
    				   		<input type="checkbox" name="email_save_attachments" value="yes" id="email_save_attachments" data-toggle="switch" <?php if( $this->config->item('email_save_attachments') ):?>checked<?php endif;?> />
    				   	</div>
    				   	<p class="help-block">
    				   		If set to "on", files send with form submissions will be stored on the server in addition to being send as an attachment. If you turn on this option, please make sure you specify a folder inside <b>/application/config/upload.php</b> and that this folder is writable by the web server. A wrong folder path or wrong permissions can lead to errors when submitting the form.
    				   	</p>
    				</div>
    			
    			</div><!-- /.well -->
    			
    			<div class="well">
    			
    				<h4>SPAM filter</h4>
    				
    				<hr>
    				
    				<div class="form-group">
    					<label for="spam_words"><b>SPAM words and phrases</b> </label>
    					<div class="form-group">
    						<?php 
								
								if( $this->config->item('spam_words') != '' ) {
								    							
    								$spamwords = implode("
", $this->config->item('spam_words'));

								} else {
								
									$spamwords = '';
								
								}
    						
    						;?>
    				   		<textarea class="form-control" rows="5" name="spam_words" id="spam_words" placeholder="SPAM words and/or phrases"><?php echo $spamwords;?></textarea>
    				   	</div>
    				   	<p class="help-block small">
    				   		Here you can specify SPAM detection words or phrases. Please enter ONE word OR phrase per line. When the API detects form data containing one or more of these words or phrases, it will be considered as SPAM and no email will be send.
    				   	</p>
    				   	<p class="help-block small">
    				   		Leave this empty to disable the SPAM filter.
    				   	</p>
    				</div>
    			
    			</div><!-- /.well -->
    			
    			<button type="submit" class="btn btn-primary btn-embossed btn-block btn-hg">Save settings</button>
    			
    			<br><br>
    		
    		</div><!-- /.col-md-6 -->
    		
    		</form>
    	
    	</div><!-- /.row -->
    	
    </div><!-- /.container -->


    <!-- Load JS here for greater good =============================-->
    <script src="<?php echo $this->config->item('base_url');?>js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/bootstrap.min.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/bootstrap-select.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/bootstrap-switch.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/flatui-checkbox.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/flatui-radio.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/jquery.tagsinput.js"></script>
    <script src="<?php echo $this->config->item('base_url');?>js/jquery.placeholder.js"></script>
    <script>
    $(function(){
    
    	// Tabs
    	$(".nav-tabs a").on('click', function (e) {
    		e.preventDefault();
    	  	$(this).tab("show");
    	})
    	
    	$('.input-group').on('focus', '.form-control', function () {
    	  $(this).closest('.input-group, .form-group').addClass('focus');
    	}).on('blur', '.form-control', function () {
    	  $(this).closest('.input-group, .form-group').removeClass('focus');
    	});
    
    	// Switch
    	$("[data-toggle='switch']").wrap('<div class="switch" />').parent().bootstrapSwitch();
    	
    })
    </script>
</body>
</html>
