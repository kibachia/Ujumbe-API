<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ujumbe API Admin | Attachments</title>
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
    					<li><a class="no-right-padding" href="<?php echo site_url("admin/submissions");?>">Submissions</a></li>
    			    	<li><a href="<?php echo site_url("admin/emailids");?>">Email IDs</a></li>
    			    	<li class="active"><a href="<?php echo site_url('admin/attachments');?>">Attachments</a></li>
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
    			
    			<form action="<?php echo site_url("admin/attachments/deletemulti");?>" method="post">
    		
    			<div class="info clearfix">
    			
    				Number of attachments: <b><?php echo count($attachments);?></b>
    			    			
    			</div><!-- /.info -->
    		
    			<div class="table-responsive">
    				<table class="table table-bordered table-striped" id="table">
    				 	<thead>
    				    	<tr>
    				        	<th width="30">
    				        		<label class="checkbox no-label toggle-all" for="checkbox-table-1"><input type="checkbox" value="" id="checkbox-table-1" data-toggle="checkbox"></label>
    				        	</th>
   								<th width="">File</th>
   								<th width="130">Date</th>
    				            <th width="180">Size</th>
    				            <th width="120">Actions</th>
  							</tr>
    					</thead>
    				    <tbody>
    				    	<?php foreach( $attachments as $attachment ):?>
    				    	<tr>
    				        	<td>
    				        		<label class="checkbox no-label" for="checkbox-table-<?php echo $attachment['name']?>"><input type="checkbox" name="ids[]" value="<?php echo $attachment['name']?>" id="checkbox-table-<?php echo $attachment['name']?>" data-toggle="checkbox"></label>
    				        	</td>
   								<td>
   									<b><a href="<?php echo site_url().$attachment['relative_path'].$attachment['name'];?>" target="_blank"> <?php echo $attachment['name']?></a></b>
   								</td>
    				            <td>
    				            	<?php echo date("Y-m-d", $attachment['date'])?>
    				            </td>
    				            <td>
    				            	<?php echo $attachment['size']?> bytes
    				            </td>
    				            <td>
    				            	<div class="crud">
    				            		<a href="<?php echo site_url("admin/attachments/delete/".$attachment['name']);?>"><span class="fui-cross-inverted text-danger del"></span></a>
    				            		&nbsp;
    				            		<a href="<?php echo site_url().$attachment['relative_path'].$attachment['name'];?>" target="_blank"><span class="fui-export"></span></a>
    				            	</div>
    				            </td>
   							</tr>
   							<?php endforeach;?>
    					</tbody>
   					</table>
   					
   				</div><!-- /.table-responsive -->
   				
   				<div class="actions clearfix">
   				
   					<button type="submit" class="btn btn-danger btn-embossed"><span class="fui-cross-inverted"></span> Delete Selected</button>
   				
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
    	
    })
    </script>
</body>
</html>
