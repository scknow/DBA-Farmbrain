<?php
include "connection.php";
session_start();
$id= $_SESSION['id'];
$warning=0;
if(isset($_REQUEST['submit'])){
	$password = $_POST['cpass'];
	$n = $_POST['npass'];
	if(!isset($_SESSION['supplierid']))
	{
		$sql="SELECT * FROM admin where adminid='$id' and password='$password'";
	}else
	{
		$sql="SELECT * FROM salesuser where userid='$id' and password='$password'";
	}
	
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	//echo $count;
	if($count==1){
		if(!isset($_SESSION['supplierid'])){
			$sql="UPDATE admin SET password='$n' where adminid='$id'";
		}
		else
		{
			$sql="UPDATE salesuser SET password='$n',password_change='1' where userid='$id'";
			$row=mysql_fetch_array($result);
			if($row['password_change']==0)
			{
				header('Location:dashboard.php');
			}
		}
		
		$result = mysql_query($sql);
		
		$warning=2;
	}else{
		$warning=1;
	}
}
include "header.php";
?>

<?
include "footer.php";
?>

<div id="content" class="span10" style='width: 100%;'>
			<!-- content starts -->			
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="dashboard.php">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Settings</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable" style='width:72%;margin: 0 auto;'>		
				<div class="box span12" style='width:100%;min-height:219px;overflow:hidden;float:left'>				
				<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Change Password</h2>
				</div>
					<div class="box-content">					
						<center>
							<?
							if($warning==1){
							?>
								<p>Current password doesn't match</p>
							<?
							}else if($warning==2){?>
								<p>Password changed successfully </p>
								<?
							}
							?>
							<form name="form1" method="post" id="all" action="#" enctype="multipart/form-data">
							Current Password: <input type='password' name="cpass" /><br>
							New Password: <input type='password' name="npass" id="npass" onkeyup="check_password()" /><br>
							Confirm Password: <input type='password' name="conpass" id="conpass" onkeyup="check_password()" /><br>
							<p style="color:red; display:none" id="ppass" >Password not match!</p>
							<input type='submit' value="Change Password" name="submit"/>
							</form>
						</center>
					</div>
				</div>
			</div>
		</div>

<script>
$( "#supplier_li" ).click(function() {
	$( "#supplier_ul" ).slideToggle(1000);						
});
				
$( "#customer_li" ).click(function() {
		$( "#customer_ul" ).slideToggle(1000);						
});
				
$( "#product_li" ).click(function() {
	$( "#product_ul" ).slideToggle(1000);						
});
					
$( "#node_li" ).click(function() {
	$( "#node_ul" ).slideToggle(700);
});
function check_password(){
	var npass = $("#npass").val();
	var conpass = $("#conpass").val();
	if(npass!=conpass){
		$("#ppass").show();
	}else{
		$("#ppass").hide();
	}
}
</script>