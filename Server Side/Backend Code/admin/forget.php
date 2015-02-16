<?
include "connection.php";
$client='Client';
if (isset($_POST["myusername"]))
    {
    $from = $_POST["myusername"]; // send
	//Here i am checking if email exits or not 
	$send_pass=mysql_query("select * from `admin` where username='$from'");
	$send_pass1=mysql_query("select * from `salesuser` where username='$from'");

	if(mysql_num_rows($send_pass)!=0)
	{
		$row=mysql_fetch_array($send_pass);
		$password=$row['password'];
		$subject = "FarmBrain";
		$message = "username : ".$from."
		password : ".$password;
		echo $message;
		// message lines should not exceed 70 characters (PHP rule), so wrap it
		$message = wordwrap($message, 70);
		// send mail
		mail($from,$subject,$message,"From: no-reply@farmbrain.com\n");
		$msg=1;
		//echo 1;
		//echo "New password has been sent to email. <a href='index.php'>Click here to login</a>";
	}
	
	else if(mysql_num_rows($send_pass1)!=0)
	{
		$row=mysql_fetch_array($send_pass);
		$password=$row['password'];
		$subject = "FarmBrain";
		$message = "username : $from
		password : $password";
		// message lines should not exceed 70 characters (PHP rule), so wrap it
		$message = wordwrap($message, 70);
		// send mail
		mail($from,$subject,$message,"From: no-reply@farmbrain.com\n");
		$msg=1;
		//echo 1;
		//echo "New password has been sent to email. <a href='index.php'>Click here to login</a>";	
	}
	else
	{
		$msg=0;
		//echo 0;
	}
    }
	?>



<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<title>DBA member login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
	<meta name="author" content="Muhammad Usman">

	<!-- The styles -->
	<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="images/logo.png">
		
</head>

<body>
		<div class="container-fluid">
		<div class="row-fluid">
		
			<div class="row-fluid">
				<div class="span12 center login-header">
					<img src="images/logo.png">
				</div><!--/span-->
			</div><!--/row-->
			
			<div class="row-fluid" style='margin-top:10px;'>
				<div class="well span5 center login-box">
					<div class="alert alert-info">
						<h4>Forgot Password</h4>
					</div>
					<? if (!isset($_POST["myusername"])){ ?>
					<form name="form1" method="POST" action="#" class="form-horizontal">
						<fieldset>
							<div class="input-prepend" title="Username" data-rel="tooltip">
								<span class="add-on"><i class="icon-user"></i></span>
								
								<input autofocus class="input-large span10" name="myusername" id="username" type="text" placeholder='fill you email id here'/>
								
							</div>
							<div class="clearfix"></div>
						
							
							<div class="clearfix"></div>

							<p class="center span5">
							<button type="submit" name='submit' class="btn btn-primary">Submit</button>
							</p>
						</fieldset>
					</form>
					<?}else{?>
					<fieldset>
						<div class="input-prepend" title="Username" data-rel="tooltip">
								<span class="add-on"><i class="icon-user"></i></span>
								<center>
									<?if($msg==0){?>
									There is no user with this username <br><a href='index.php'>Click here to login</a>
									<?}else{?>
									Your password has been sent to your email.<br>
									<a href='index.php'>Click here to login</a>
									<?}?>
								</center>
								
							</div>
					</fieldset>
					<?}?>
				</div><!--/span-->
			</div><!--/row-->
				</div><!--/fluid-row-->
		
	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
	<script src="js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="js/charisma.js"></script>
	
		
</body>
</html>