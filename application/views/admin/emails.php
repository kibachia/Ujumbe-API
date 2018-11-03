<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ujumbe API Admin | Emails</title>
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
    	
    	<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="mainNav">
    		<div class="container">
    			<div class="navbar-header">
    				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
    					<span class="sr-only">Toggle navigation</span>
    			 	</button>
   				</div>
    			<div class="collapse navbar-collapse" id="navbar-collapse-01">
    				<ul class="nav navbar-nav">			      
    					<li><a class="no-right-padding" href="<?php echo site_url('admin/submissions');?>">Submissions</a></li>
    			    	<li class="active"><a href="<?php echo site_url('admin/emailids');?>">Email IDs</a></li>
    			    	<li><a href="<?php echo site_url('admin/attachments');?>">Attachments</a></li>
    				</ul> 		      
    				<ul class="nav navbar-nav navbar-right">
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
    				<form class="navbar-form navbar-right" action="<?php echo site_url("admin/emailids")?>" method="get" role="search">
    					<div class="form-group">
    						<div class="input-group">
    							<input class="form-control" id="navbarInput-01" name="search" type="search" placeholder="Search email addresses" value="<?php 	if( isset($_GET['search']) ){echo $_GET['search'];}?>">
    							<span class="input-group-btn">
    								<button type="submit" class="btn"><span class="fui-search"></span></button>
    							</span>            
    						</div>
    					</div>	             
    				</form>
    			</div><!-- /.navbar-collapse -->
    		</div><!-- /.container -->
    	</nav><!-- /navbar -->
    	
    	<div class="row">
    	
    		<div class="col-md-12">
    		
    			<?php if( $this->session->flashdata('success_message') ):?>
    			<div class="alert alert-success">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4>Success:</h4>
    			  	<p>
    			  		<?php echo $this->session->flashdata('success_message');?>
    			  	</p>
    			</div>
    			<?php endif;?>
    			
    			<?php if( $this->session->flashdata('error_message') ):?>
    			<div class="alert alert-error">
    				<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    				<h4>Error:</h4>
    			  	<p>
    			  		<?php echo $this->session->flashdata('error_message');?>
    			  	</p>
    			</div>
    			<?php endif;?>
    			
    			<form action="<?php echo site_url("admin/emails/deletemulti");?>" method="post">
    		
    			<div class="info clearfix">
    			
    				Number of email addresses: <b><?php echo $total;?></b>
    				
    				<div class="pull-right">
    				
    					<a href="<?php echo site_url("admin/emailids/1/all")?>" class="label <?php if( $this->session->userdata('email_filter') == '' || $this->session->userdata('email_filter') == 'all' ):?>label-primary<?php else:?>label-default<?php endif;?>">All</a>
    					
    					<a href="<?php echo site_url("admin/emailids/1/verified")?>" class="label <?php if( $this->session->userdata('email_filter') == 'verified' ):?>label-primary<?php else:?>label-default<?php endif;?>">Verified</a>
    					
    					<a href="<?php echo site_url("admin/emailids/1/notverified")?>" class="label <?php if( $this->session->userdata('email_filter') == 'notverified' ):?>label-primary<?php else:?>label-default<?php endif;?>">Not Verified</a>
    					
    					<a href="<?php echo site_url("admin/emailids/1/active")?>" class="label <?php if( $this->session->userdata('email_filter') == 'active' ):?>label-primary<?php else:?>label-default<?php endif;?>">Active</a>
    					
    					<a href="<?php echo site_url("admin/emailids/1/notactive")?>" class="label <?php if( $this->session->userdata('email_filter') == 'notactive' ):?>label-primary<?php else:?>label-default<?php endif;?>">Not Active</a>
    					
    				</div>
    			    			
    			</div><!-- /.info -->
    		
    			<div class="table-responsive">
    				<table class="table table-bordered table-striped" id="table">
    				 	<thead>
    				    	<tr>
    				        	<th width="30">
    				        		<label class="checkbox no-label toggle-all" for="checkbox-table-1"><input type="checkbox" value="" id="checkbox-table-1" data-toggle="checkbox"></label>
    				        	</th>
   								<th width="225">Email</th>
    				            <th width="225">Email mask</th>
    				            <th width="">Verification code</th>
    				            <th width="100">Verified?</th>
    				            <th width="130">Active?</th>
    				            <th width="100">Actions</th>
  							</tr>
    					</thead>
    				    <tbody>
    				    	<?php foreach( $emails as $email ):?>
    				    	<tr>
    				        	<td>
    				        		<label class="checkbox no-label" for="checkbox-table-<?php echo $email->emails_id?>"><input type="checkbox" name="ids[]" value="<?php echo $email->emails_id?>" id="checkbox-table-<?php echo $email->emails_id?>" data-toggle="checkbox"></label>
    				        	</td>
   								<td>
   									<b><?php echo $email->emails_email;?></b>
   								</td>
    				            <td><?php echo $email->emails_code;?></td>
    				            <td>
    				            	<?php echo $email->emails_verification_code;?>
    				            </td>
    				            <td>
    				            	<?php if( $email->emails_verified == 1 ){echo "yes";}else{echo "no";}?>
    				            </td>
    				            <td>
    				           		<div class="demo-col">
    				           			<input type="checkbox" class="toggleEmail" id="<?php echo $email->emails_email;?>" <?php if( $email->emails_active == 1 ){echo "checked";}?> data-toggle="switch" />
    				           		</div><!-- /.demo-col -->
    				            </td>
    				            <td class="text-center">
    				            	<div class="crud">
    				            		<a href="<?php echo site_url("admin/emails/delete/".$email->emails_id);?>"><span class="fui-cross-inverted text-danger del"></span></a>
    				            	</div>
    				            </td>
   							</tr>
   							<?php endforeach;?>
    					</tbody>
   					</table>
   					
   				</div><!-- /.table-responsive -->
   				
   				<div class="actions clearfix">
   				
   					<button type="submit" class="btn btn-danger btn-embossed"><span class="fui-cross-inverted"></span> Delete Selected</button>
   					
   					<div class="pagination pagination-minimal pull-right">
   						<ul>
   					    	<li class="previous"><a <?php if( $page != '1' ):?>href="<?php echo site_url("admin/emailids/".($page-1));?><?php if( isset($_GET['search']) ){echo "?search=".$_GET['search'];}?>"<?php endif;?> class="fui-arrow-left"></a></li>
   					    	<?php 
   					    	
   					    		for( $x=1; $x<=ceil($total/$perpage); $x++ ):
   					    	
   					    	?>
   					    	<li <?php if( $page == $x ):?>class="active"<?php endif;?> ><a href="<?php echo site_url("admin/emailids/".$x)?><?php if( isset($_GET['search']) ){echo "?search=".$_GET['search'];}?>"><?php echo $x;?></a></li>
   					    	<?php endfor;?>
   					    	
   					    	<li class="next"><a <?php if( $page < ceil($total/$perpage) ):?>href="<?php echo site_url("admin/emailids/".($page+1));?><?php if( isset($_GET['search']) ){echo "?search=".$_GET['search'];}?>"<?php endif;?> class="fui-arrow-right"></a></li>
   					  	</ul>
   					</div><!-- /pagination -->
   				
   				</div><!-- /.actions -->
    		
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
    	
    	// Switch
    	$("[data-toggle='switch']").wrap('<div class="switch" />').parent().bootstrapSwitch();
    	
    	
    	$('#table').on("change", ".toggleEmail", function(){
    	
    		if( $(this).prop('checked') ) {
    		
    			$toggle = "on";
    		
    		} else {
    		
    			$toggle = "off";
    		
    		}
    		    	
    		$.ajax({
    			type: "POST",
    			data: {email: $(this).attr('id'), toggle: $toggle},
    		  	url: "<?php echo site_url("admin/toggleEmail")?>"
    		}).done(function(response){
    		
    		})
    	
    	})
    	
    })
    </script>
</body>
</html>
