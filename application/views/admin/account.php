<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ujumbe API Admin | Account</title>
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
    	
    		<div class="col-md-4 col-md-offset-4">
    		
    			<h4>User name and password</h4>
    			
    			<hr>
    			
    			<?php if( validation_errors() != '' ):?>
    			<div class="alert alert-error">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4>Error:</h4>
    			  	<?php echo validation_errors();?>
    			</div>
    			<?php endif;?>
    			
    			<?php if( isset($success) ):?>
    			<div class="alert alert-success">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4>Success:</h4>
    			  	<p>
    			  		You're details have been updated.
    			  	</p>
    			</div>
    			<?php endif;?>
    			
    			<form role="form" method="post" action="<?php echo site_url("admin/account")?>">
    				<div class="form-group">
    			    	<label for="exampleInputEmail1">Email address</label>
    			    	<?php
    			    		
    			    		$user = $this->ion_auth->user()->row();
    			    		
    			    	?>
    			    	<input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php echo $user->email;?>">
    			  	</div>
    			  	<div class="form-group">
    			    	<label for="exampleInputPassword1">Password</label>
    			    	<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    			  	</div>
    			  	<div class="form-group">
    			  		<label for="exampleInputPassword1">Confirm Password</label>
    			  		<input type="password" name="password2" class="form-control" id="exampleInputPassword1" placeholder="Password2">
    			  	</div>
    			  	<button type="submit" class="btn btn-primary btn-block btn-embossed">Update details</button>
    			</form>
    		
    		</div><!-- /.col-md-12 -->
    	
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
    
    	// Table: Toggle all checkboxes
    	$('.table .toggle-all').on('click', function() {
    		var ch = $(this).find(':checkbox').prop('checked');
    	  	$(this).closest('.table').find('tbody :checkbox').checkbox(!ch ? 'check' : 'uncheck');
    	});
    	
    	
    	//delete record
    	$('#table').on("click", ".crud .del", function(){
    	
    		if( confirm("Are you sure about this?") ) {
    		
    			return true;
    		
    		} else {
    		
    			return false;
    		
    		}
    	
    	})
    	
    	$('.input-group').on('focus', '.form-control', function () {
    	  $(this).closest('.input-group, .form-group').addClass('focus');
    	}).on('blur', '.form-control', function () {
    	  $(this).closest('.input-group, .form-group').removeClass('focus');
    	});
    	
    })
    </script>
</body>
</html>
