<?
@session_start();
if(!isset($_SESSION['id']))
{
	@header("location:index.php");
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>DBA</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- The styles -->
	<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	  #DataTables_Table_0_filter{
		float:right;
	  }
	  #DataTables_Table_0_length{
		float:right;
	  }
	  .row-fluid .span14:first-child{
		width:50%;
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
	<link href='css/breadCrums.css' rel='stylesheet'>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="images/logo.png">
	<style>
		.header_custom
		{
			float: left;
			width: 84%;
			height: 72px;
			
			border-radius: 4px;
		}
		.nav li a:hover
		{
			background:white;
		}
	</style>
</head>

<body>
		<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				
				<a class="brand" href="index.php"> <img alt="Charisma Logo" src="images/logo.png" style='width:100%;height:9%'/></a>
				
			
				<div class='header_custom'>
				<ul class='nav nav-tabs nav-stacked main-menu' style='margin:13px 14px 14px 14px;'>
					<li><a class="ajax-link" href="dashboard.php" style='text-decoration:none;'><i class="icon-home"></i><span class="hidden-tablet"> Home</span></a></li>
					<li><a class="ajax-link" href="master.php" style='text-decoration:none;'><i class="icon-folder-open"></i><span class="hidden-tablet"> Master data</span></a></li>
					<li><a class="ajax-link" href="operation.php" style='text-decoration:none;'><i class="icon-align-justify"></i><span class="hidden-tablet"> Operations</span></a></li>
					<li><a class="ajax-link" href="report.php" style='text-decoration:none;'><i class="icon-home"></i><span class="hidden-tablet"> Report</span></a></li>
				</ul>
					
				<!-- theme selector starts -->
				<!--
				<div class="btn-group pull-right theme-container" style='margin: 18px 0px 14px 0px;'>
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-tint"></i><span class="hidden-phone"> Change Theme / Skin</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" id="themes">
						<li><a data-value="classic" href="#"><i class="icon-blank"></i> Classic</a></li>
						<li><a data-value="cerulean" href="#"><i class="icon-blank"></i> Cerulean</a></li>
						<li><a data-value="cyborg" href="#"><i class="icon-blank"></i> Cyborg</a></li>
						<li><a data-value="redy" href="#"><i class="icon-blank"></i> Redy</a></li>
						<li><a data-value="journal" href="#"><i class="icon-blank"></i> Journal</a></li>
						<li><a data-value="simplex" href="#"><i class="icon-blank"></i> Simplex</a></li>
						<li><a data-value="slate" href="#"><i class="icon-blank"></i> Slate</a></li>
						<li><a data-value="spacelab" href="#"><i class="icon-blank"></i> Spacelab</a></li>
						<li><a data-value="united" href="#"><i class="icon-blank"></i> United</a></li>
					</ul>
				</div>
				-->
				<!-- theme selector ends -->
				
				<!-- user dropdown starts -->
				
				<!-- user dropdown ends -->
				
				<div class="btn-group pull-right" style='margin: 18px 0px 14px 0px'>
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i><span class="hidden-phone"><?php echo $_SESSION['name'];?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<!--<li><a href="#">Profile</a></li>-->
						<li class="divider"></li>
						<li><a href="password.php">Change Password</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
					
					<div class="dba-logo"><img src="images/dba-logo.png"/></div>
				</div>
				</div>
				
					<!--<div class="btn-group pull-right" style='margin: 13px 0px 14px 0px;'>
					
				</div>-->
				
				
			</div>
			
		</div>
	</div>
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
			
			
		
			
