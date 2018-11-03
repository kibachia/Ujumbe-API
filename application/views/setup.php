<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>The Form Submit API - Ujumbe API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="<?php echo $this->config->item('base_url');?>bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="<?php echo $this->config->item('base_url');?>css/flat-ui.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url');?>css/setup.css" rel="stylesheet">

    <link rel="shortcut icon" href="<?php echo $this->config->item('base_url');?>images/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="<?php echo $this->config->item('base_url');?>js/html5shiv.js"></script>
      <script src="<?php echo $this->config->item('base_url');?>js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	
	<div class="container setup">
	
		<header>
			
			<div class="row">
			
				<div class="col-md-3">
					
					<h3>
						<img src="<?php echo $this->config->item('base_url');?>images/icons/ujumbe.svg" >
						Ujumbe
					</h3>
				
				</div><!-- /.col-md-3 -->
				
				<div class="col-md-9">
				
					<div class="text-right margin-top-32 margin-bottom-0 apiUrl clearfix">
						<pre class="pull-right"><code><b><?php echo site_url('/api');?></b></code></pre>
						<p class="pull-right lead">
							Your API url: 
						</p>
					</div>
				
				</div><!-- /.col-md-9 -->
			
			</div><!-- /.row -->
			
			<hr>
			
			<div class="row">
			
				<div class="col-md-8">
				
					<ul class="nav nav-tabs nav-append-content sample-tabs">
    					<li class="active"><a href="#emailID">Retrieve Email ID</a></li>
    				    <li><a href="#advanced">Advanced Fields</a></li>
    				    <li><a href="#validate">Validation</a></li>
   					</ul> <!-- /tabs -->
    				
    				<div class="tab-content">
    				
    					<div class="tab-pane active" id="emailID">
    					
    						<hr>
    						
    						<h4>Retrieve your email ID</h4>
    					
    						<p>
    							Enter your email address in the form below and click the Submit button to generate your email ID.
    						</p>
    						
    						<?php if( validation_errors() != '' ):?>
    						
    						<div class="alert alert-error">
    							<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    						  	<?php echo validation_errors(); ?>
    						</div>
    						
    						<?php endif;?>
    						
    						<?php if( isset($emailCode) ):?>
    						
    						<div class="alert alert-success">
    							<button type="button" class="close fui-cross" data-dismiss="alert"></button>
    							<p>
    						  		Your email address has been masked and you can now use the following email ID instead of your email address:<br>
    						  		<b><?php echo $emailCode;?></b>
    							</p>
    							<p>
    								Set your form <code>action=""</code> attribute to: <code>action="<?php echo site_url('/api');?>/<?php echo $emailCode;?>"</code> to start using the API.
    							</p>
    						</div>
    						
    						<?php endif;?>
    						
    						<form role="form" action="<?php echo site_url('/setup');?>" method="post" class="margin-bottom-15">
    							<div class="form-group">
    						    	<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email address" value="<?php if( isset($_POST['email']) ){echo $_POST['email'];}?>">
    						  	</div>
    						  	<button type="submit" class="btn btn-info btn-embossed">Retrieve Email ID</button>
    						</form>
    						
    					</div>
    				
    					<div class="tab-pane" id="advanced">
    							
    						<hr>
    						
    						<h4>Using advanced fields</h4>
    						
    						<div class="panel-group margin-bottom-15" id="advancedAccordion">
    						
    							<div class="panel panel-default">
    						    	<div class="panel-heading">
    						      		<h4 class="panel-title">
    						        		<a data-toggle="collapse" data-parent="#advancedAccordion" href="#collapseOne">
    						          			Subject
    						        		</a>
    						      		</h4>
    						    	</div>
    						   		<div id="collapseOne" class="panel-collapse collapse in">
    						   			<div class="panel-body">
    						        		<p>
    						        			Specify a custom email subject. If omitted, the default subject (set in the configuration file) will be used.
    						        		</p>
    						        		
    						        		<pre><code>&lt;input type="hidden" <b>name="_subject"</b> value="My awesome subject"&gt;</code></pre>
    						      		</div>
    						    	</div>
    							</div><!-- /.panel -->
    						  
    							<div class="panel panel-default">
    								<div class="panel-heading">
    						    		<h4 class="panel-title">
    						        		<a data-toggle="collapse" data-parent="#advancedAccordion" href="#collapseTwo">
    						          			Reply to
    						        		</a>
    						      		</h4>
    						    	</div>
    						    	<div id="collapseTwo" class="panel-collapse collapse">
    						    		<div class="panel-body">
    						       			<p>
    						       				Specify a custom reply to email address for the email.
    						       			</p>
    						       			
    						       			<pre><code>&lt;input type="hidden" <b>name="_replyto"</b> value="johndoe@gmail.com"&gt;</code></pre>
    						       			
    						       			<p>
    						       				Instead of specifying a static custom "reply to" address, you can also choose to use an email address entered by the user of the form. In order to do this, give your custom "replyto_" field a value of "%" followed by the name of the field. Let's assume you have a field named "email" which value you'd like to use for your custom "reply to" field, then you'd give you "reply to" field a value of "%email".
    						       			</p>
    						       			
    						       			<pre><code>&lt;input type="hidden" <b>name="_replyto"</b> value="%email"&gt;</code></pre>
    						       			
    						      		</div>
    						   		</div>
    							</div><!-- /.panel -->
    							
    							<div class="panel panel-default">
    								<div class="panel-heading">
    									<h4 class="panel-title">
    							    		<a data-toggle="collapse" data-parent="#advancedAccordion" href="#collapseTen">
    							      			CC
    							    		</a>
    							  		</h4>
    								</div>
    								<div id="collapseTen" class="panel-collapse collapse">
    									<div class="panel-body">
    							   			<p>
    							   				Specify one or more CC recipients for the email.
    							   			</p>
    							   			
    							   			<pre><code>&lt;input type="hidden" <b>name="cc[]"</b> value="johndoe@gmail.com"&gt;
&lt;input type="hidden" <b>name="cc[]"</b> value="janedoe@gmail.com"&gt;</code></pre>
    							   			
    							   			<p>
    							   				Use the above syntax to specify one or more CC recipients. Please note the name of this field is "<b>cc[]</b>". This allows you to specify any number of entries, rather then just one.
    							   			</p>
    							   			    							   			
    							  		</div>
    								</div>
    							</div><!-- /.panel -->
    							
								<div class="panel panel-default">
    								<div class="panel-heading">
    									<h4 class="panel-title">
    							    		<a data-toggle="collapse" data-parent="#advancedAccordion" href="#collapseEleven">
    							      			BCC
    							    		</a>
    							  		</h4>
    								</div>
    								<div id="collapseEleven" class="panel-collapse collapse">
    									<div class="panel-body">
    							   			<p>
    							   				Specify one or more BCC recipients for the email.
    							   			</p>
    							   			
    							   			<pre><code>&lt;input type="hidden" <b>name="bcc[]"</b> value="johndoe@gmail.com"&gt;
&lt;input type="hidden" <b>name="bcc[]"</b> value="janedoe@gmail.com"&gt;</code></pre>
    							   			
    							   			<p>
    							   				Use the above syntax to specify one or more BCC recipients. Please note the name of this field is "<b>bcc[]</b>". This allows you to specify any number of entries, rather then just one.
    							   			</p>
    							   			    							   			
    							  		</div>
    								</div>
    							</div><!-- /.panel -->
    						  
    							<div class="panel panel-default">
    								<div class="panel-heading">
    						    		<h4 class="panel-title">
    						        		<a data-toggle="collapse" data-parent="#advancedAccordion" href="#collapseThree">
    						          			Redirection
    						        		</a>
    						      		</h4>
    						    	</div>
    						    	<div id="collapseThree" class="panel-collapse collapse">
    						    		<div class="panel-body">
    						        		<p>
    						        			Specify a URL to redirect the user to after successfully submitting the form.
    						        		</p>
    						        		
    						        		<pre><code>&lt;input type="hidden" <b>name="_after"</b> value="http://google.com"&gt;</code></pre>
    						      		</div>
    						    	</div>
    							</div><!-- /.panel -->
    							
    							<div class="panel panel-default">
    								<div class="panel-heading">
    									<h4 class="panel-title">
    							    		<a data-toggle="collapse" data-parent="#advancedAccordion" href="#collapseFour">
    							      			Honey pot
    							    		</a>
    							  		</h4>
    								</div>
    								<div id="collapseFour" class="panel-collapse collapse">
    									<div class="panel-body">
    							    		<p>
    							    			This is a special field which acts as a form of SPAM protection. This hidden field will not be shown to regular visitors, but most SPAM bots will automatically enter a value into this field. If Ujumbe API detects a value, the data is considered SPAM and won't be processed (no email will get send).
    							    		</p>
    							    		
    							    		<pre><code>&lt;input type="text" <b>name="_honey"</b> value="" style="display:none"&gt;</code></pre>
    							  		</div>
    								</div>
    							</div><!-- /.panel -->
    							
    							<div class="panel panel-default">
    								<div class="panel-heading">
    									<h4 class="panel-title">
    							    		<a data-toggle="collapse" data-parent="#advancedAccordion" href="#collapseFive">
    							      			Sending files with the form
    							    		</a>
    							  		</h4>
    								</div>
    								<div id="collapseFive" class="panel-collapse collapse">
    									<div class="panel-body">
    							    		<p>
    							    			Ujumbe API handles form files with a breeze. Simply add the following element to your form and API will attach the file the email it sends out:
    							    		</p>
    							    		
    							    		<pre><code>&lt;input type="file" <b>name="file"</b>&gt;</code></pre>
    							  		</div>
    								</div>
    							</div><!-- /.panel -->
    							
    							<div class="panel panel-default">
    								<div class="panel-heading">
    									<h4 class="panel-title">
    							    		<a data-toggle="collapse" data-parent="#advancedAccordion" href="#collapseSix">
    							      			Setting a custom confirmation message
    							    		</a>
    							  		</h4>
    								</div>
    								<div id="collapseSix" class="panel-collapse collapse">
    									<div class="panel-body">
    							    		<p>
    							    			Set a custom confirmation message shown to the user after successfully submitting the form:
    							    		</p>
    							    		
    							    		<pre><code>&lt;input type="hidden" <b>name="_confirmation"</b> value="&lt;b&gt;Thank you!&lt;/b&gt; We have received your message and will get back to you asap."&gt;</code></pre>
    							  		</div>
    								</div>
    							</div><!-- /.panel -->
    							
    						</div><!-- /.panel-group -->
    					
    					</div>
    				
    					<div class="tab-pane" id="validate">
    						
							<hr>
							
							<h4>Using validation fields</h4>
							
							<p>
								<b>Ujumbe API</b> lets you set validation rules on the submitted data. The syntax is simple, just add a hidden input field to your form, and set the name attribute to <code>name="_valid[field_name]"</code> where you woud replace "field_name" with the name of the field for which you are defining a rule. If you were to have a field named "email", then you name your validation field <code>name="_valid[email]"</code>.
							</p>
							
							<p>
								The value attribute of your validation field should contain one or more validation rules. When specifying multiple rules for a single field, the rules should be separated by a "|" as such <code>name="rule_one|rule_two|rule_three"</code>.
							</p>
							
							<p>
								Below you'll a listing of all available validation rules:
							</p>
							
							<div class="table-responsive">
								<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th width="80px">Rule</th>
											<th>Description</th>
											<th>Example</th>
										</tr>
									</thead>
							    	<tbody>
							    		<tr>
							    			<td><b>required</b></td>
							    			<td>Returns FALSE if the form element is empty.</td>
							    			<td></td>
							    		</tr>
							    		<tr>
							    			<td><b>min_length</b></td>
							    			<td>Returns FALSE if the form element is shorter then the parameter value.</td>
							    			<td>min_length[6]</td>
							    		</tr>
							    		<tr>
							    			<td><b>max_length</b></td>
							    			<td>Returns FALSE if the form element is longer then the parameter value.</td>
							    			<td>max_length[12]</td>
							    		</tr>
							    		<tr>
							    			<td><b>exact_length</b></td>
							    			<td>Returns FALSE if the form element is not exactly the parameter value.</td>
							    			<td>exact_length[8]</td>
							    		</tr>
							    		<tr>
							    			<td><b>greater_than</b></td>
							    			<td>Returns FALSE if the form element is less than the parameter value or not numeric.</td>
							    			<td>greater_than[8]</td>
							    		</tr>
							    		<tr>
							    			<td><b>less_than</b></td>
							    			<td>Returns FALSE if the form element is greater than the parameter value or not numeric.</td>
							    			<td>less_than[8]</td>
							    		</tr>
							    		<tr>
							    			<td><b>alpha</b></td>
							    			<td>Returns FALSE if the form element contains anything other than alphabetical characters.</td>
							    			<td></td>
							    		</tr>
							    		<tr>
							    			<td><b>alpha_numeric</b></td>
							    			<td>Returns FALSE if the form element contains anything other than alpha-numeric characters.</td>
							    			<td></td>
							    		</tr>
							    		<tr>
							    			<td><b>alpha_dash</b></td>
							    			<td>Returns FALSE if the form element contains anything other than alpha-numeric characters, underscores or dashes.</td>
							    			<td></td>
							    		</tr>
							    		<tr>
							    			<td><b>numeric</b></td>
							    			<td>Returns FALSE if the form element contains anything other than numeric characters.</td>
							    			<td></td>
							    		</tr>
							    		<tr>
							    			<td><b>integer</b></td>
							    			<td>Returns FALSE if the form element contains anything other than an integer.</td>
							    			<td></td>
							    		</tr>
							    		<tr>
							    			<td><b>is_natural</b></td>
							    			<td>Returns FALSE if the form element contains anything other than a natural number: 0, 1, 2, 3, etc.</td>
							    			<td></td>
							    		</tr>
							    		<tr>
							    			<td><b>is_natural_no_zero</b></td>
							    			<td>Returns FALSE if the form element contains anything other than a natural number, but not zero: 1, 2, 3, etc.</td>
							    			<td></td>
							    		</tr>
							    		<tr>
							    			<td><b>valid_email</b></td>
							    			<td>Returns FALSE if the form element does not contain a valid email address.</td>
							    			<td></td>
							    		</tr>
							    		<tr>
							    			<td><b>valid_emails</b></td>
							    			<td>Returns FALSE if any value provided in a comma separated list is not a valid email.</td>
							    			<td></td>
							    		</tr>
							    		<tr>
							    			<td><b>valid_ip</b></td>
							    			<td>Returns FALSE if the supplied IP is not valid. Accepts an optional parameter of "IPv4" or "IPv6" to specify an IP format.</td>
							    			<td></td>
							    		</tr>
							    	</tbody>
							  </table>
							</div>
    						
    					</div>
    					
   					</div> <!-- /tab-content -->
				
				</div><!-- /.col-md-9 -->
				
				<div class="col-md-4">
				
					<h6 class="smaller"><span class="fui-lock text-primary"></span> Admin Login</h6>
					
					<?php if( $this->session->flashdata('message') != '' ):?>
					<div class="alert alert-info">
						<button type="button" class="close fui-cross" data-dismiss="alert"></button>
					  	<?php echo $this->session->flashdata('message');?>
					</div>
					<?php endif;?>
					
					<form role="form" method="post" action="<?php echo site_url("auth/login")?>">
						<div class="form-group">
					    	<input type="email" name="identity" class="form-control" id="identity" placeholder="Your email address">
					  	</div>
					  	<div class="form-group">
						    <input type="password" name="password" class="form-control" id="password" placeholder="Your password">
					  	</div>
					  	<button type="submit" class="btn btn-primary btn-block btn-embossed">Secure Login</button>
					</form>
				
				</div><!-- /.col-md-4 -->
			
			</div><!-- /.row -->
			
		</header>
	
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
	
})
</script>
</body>
</html>