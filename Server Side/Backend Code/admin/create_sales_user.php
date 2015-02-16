<?php
include "connection.php";
session_start();
if(isset($_REQUEST['upload_csv'])){
	if (is_uploaded_file($_FILES['filename']['tmp_name']) && !empty($_FILES['filename']['tmp_name'])) {
			// echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		
		$emailval = '/([\w\-]+\@[\w\-]+\.[\w\-]+)/';
		$mob='/^\d+$/';
		
		$handle = fopen($_FILES['filename']['tmp_name'], "r");
		$hdata = fgetcsv($handle, 1000, ",");
		$header ="";
		foreach($hdata as $h)
		{
			if(trim($h)!="")
				$header .= trim($h) . ', ';
		}
		$header .= 'Error Description';
		$status = "true";
		$msg = "";
		$out="";
		$line_no=2;
		$err = false;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			
			if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])==""))//||(trim($data[6])==""))
			{
				$msg = "Some field is missing. Not uploading.<br> ";
				$out .= $data[0] . ', ';
				$out .= $data[1] . ', ';
				$out .= $data[2] . ', ';
				$out .= $data[3] . ', ';
				$out .= $data[4] . ', ';
				$out .= $data[5] . ', ';
				$out .= $data[6] . ', ';
				$out .= "Some field is missing at line - " . $line_no . ', ';
				$out .= "\n";
				$err = true;
			}		
			else
			{
				if (!filter_var(trim($data[1]), FILTER_VALIDATE_EMAIL))
				{
					foreach($data as $h)
					{
						//if(trim($h)!="")
						$out .= trim($h) . ', ';
					}
					$msg="Check your email. Stopped uploading.<br> ";
					$status = "false";
					$out .= "Error at row - ". $line_no;
					$out .= "\n";
					$err=true;
					//break;
				}else{
					$userid = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
					$username = trim($data[1]);
					// $password = trim($data[2]);
					$password=generateRandomString();
					$firstname = trim($data[2]);
					$lastname = trim($data[3]);
					$supplierid = trim($data[4]);
					$active = 1; //trim($data[6]);
					$defaultnotification = trim($data[5]);
					$seid = trim($data[6]);
					if($userid==''){
						$userid=0;
					}				
					$sql = "select * from salesuser where userid=$userid";
					$result = mysql_query($sql);
					if(mysql_num_rows($result)>0){
						$sql = "update salesuser set username=$username, firstname=$firstname, lastname=$lastname, supplierid=$supplierid, active=$active, defaultnotification=$defaultnotification, seid=$seid where userid=$userid";
						$result = mysql_query($sql);
					}else{
						$sql = "INSERT INTO salesuser(username, password, firstname, lastname, supplierid, active, defaultnotification,seid) VALUES ('$username', '$password', '$firstname', '$lastname', '$supplierid', '$active', '$defaultnotification', '$seid')"; 
						$result = mysql_query($sql);
						echo mysql_error();		
						$to=$username;
						$subject="DBA sales user password";
						$body="Username: ".$username."<br>password: ".$password;
						$headers = 'From: dba.com' . "\r\n" .
							'Reply-To: info@dba.com' . "\r\n" .
							'X-Mailer: PHP/' . phpversion();
						$headers.="MIME-Version: 1.0" . "\r\n";
						$headers.="Content-type:text/html;charset=iso-8859-1" . "\r\n";
							
						mail($to,$subject,$body,$headers);			
					}
				}
			}
			$line_no += 1;
		}
		
		if($err)
		{
			// echo "<script></script>";
			echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');alert('Uploaded but with some errors');</script>";
		}else{
			echo "<script>alert('File Uploaded Successully');</script>";
		}
		// echo $msg;
		fclose($handle);
	}else{
		echo "<script>alert('Please choose a file to upload');</script>";
	}
	
}
else if(isset($_REQUEST['submit'])){
		$username = $_POST['username']; 
		$password =  substr(md5(uniqid(mt_rand(), true)), 0, 5); 
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		if(!isset($_SESSION['supplierid']))
		{
			$supplierid = $_POST['supplierid'];
		}
		else
		{
			$supplierid = $_SESSION['supplierid'];
		}
		$customersid = $_POST['customersid'];
		$seid = $_POST['seid'];
		$active = $_POST['active'];
		$add_edit = $_POST['add_edit'];
		$defaultnotification = $_POST['defaultnotification'];
		
		if($add_edit==1)
		{
			$id=$_POST['field_id'];
			$sql = "update salesuser set firstname='$firstname', lastname='$lastname', supplierid='$supplierid', defaultnotification='$defaultnotification',seid='$seid' where userid='$id'";
			$result = mysql_query($sql);			
			
			$max_id = $id;
			$customersid = $_POST['customersid'];
			$customersid = explode(",",$customersid);
			mysql_query("delete from access_level where salesuserid='$id'");
			for($i=0;$i<sizeof($customersid);$i++)
			{
				$sql = "INSERT INTO access_level(salesuserid,customerid)VALUES('$max_id','$customersid[$i]')";
				$result=mysql_query($sql);
			}
		}
		else
		{
			$sql = "INSERT INTO salesuser(username, password, firstname, lastname, supplierid, active, defaultnotification,seid) VALUES ('$username', '$password', '$firstname', '$lastname', '$supplierid', '$active', '$defaultnotification', '$seid')"; 
			$result = mysql_query($sql);
			
			$sql="SELECT MAX( userid  ) FROM salesuser";
			$result=mysql_query($sql);
			$temp=mysql_fetch_array($result);
			$max_id = $temp['MAX( userid  )'];
			$customersid = $_POST['customersid'];
			$customersid = explode(",",$customersid);
			//print_r($customersid);
			
			for($i=0;$i<sizeof($customersid);$i++){
				$sql = "INSERT INTO access_level(salesuserid,customerid)VALUES('$max_id','$customersid[$i]')";
				$result=mysql_query($sql);
			}
			
			$to=$username;
			$subject="DBA sales user password";
			// $body="Username: ".$username."<br>password: ".$password;
			// $body = $firstname." ".$lastname."<br /><br />
			// Welcome to Farmbrain (DBA).<br /><br />
			// Please download the app by clicking this link.<br /><br />
			// You have been registered as a Customer User for ". $firstname ." ". $lastname ."<br /><br />
			// Your user credentials are - <br />".
			// $username ."<br />".
			// $password ."<br /><br />
			// Please change this password once you login. <br /><br />
			// Best,<br /><br />
			// Farmbrain DBA <br />";
			
			$body = $firstname." ".$lastname."<br /><br />
			Welcome to Farmbrain (DBA).<br /><br />
			Please download the webapp by clicking this link.<br /><br />
			You have been registered as a Supplier User for ". $firstname ." ". $lastname ."<br /><br />
			Your user credentials are - <br />".
			$username ."<br />".
			$password ."<br /><br />
			Please change this password once you login. <br /><br />
			Best,<br /><br />
			Farmbrain DBA <br />";
			
			$name_of_u=$firstname ." ". $lastname;
			$headers = 'From: dba.com' . "\r\n" .
			'Reply-To: info@dba.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			$headers.="MIME-Version: 1.0" . "\r\n";
			$headers.="Content-type:text/html;charset=iso-8859-1" . "\r\n";
				
			//mail($to,$subject,$body,$headers);
			// curl_post($email_to,$subject,$message,$uname,$pass,$name)
			curl_post($to,$subject,$body,$username,$password,$name_of_u);
		}
		
		header('Location: ' . basename($_SERVER['PHP_SELF']));
	}
	
	function generateRandomString($length = 6) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}	
	
	function curl_post($email_to,$subject,$message,$uname,$pass,$name)
	{
		$subject="You have been added to the DBA account";
		$data_string = "msg=".$message."&email_to=".$email_to."&subject=".$subject."&username=".$uname."&password=".$pass."&name=".$name;
		$ch = curl_init('http://104.131.176.201/PHPMailer-master/examples/supplier_user_mail.php');                                                               
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
		$result = curl_exec($ch);
	}
	
	include "header.php";
	include "menu.php";
?>


<div id='upload_hover'></div>
<div id="content" class="span10">
			<!-- content starts -->			
			<!-- bread crum -->
			<div class='bread'>
				<ul class="breadcrumb">
					<li class="step">
						<a href="index.php">Home</a>
					</li>
					<li class="step">
						<a href="#">Suppliers</a>
					</li>
					<li class="step">
						<a href="#" class="active1">Sales User</a>
					</li>
				</ul>
			</div>
			<!-- end bread crum -->
	<div class="row-fluid sortable">		
			<div class="box span12">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-user"></i>Sales User</h2>
					<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 120px;'><i class="icon-cog"></i> Add Sales User</a>
					</div>
				</div>
				<div class="box-content">
					<table class="table table-striped table-bordered bootstrap-datatable datatable">
						<thead>
							<tr>
								<th><input type="checkbox" onclick="check_all()"/></th>
								<th>SU #</th>
								<th>SU Name</th>
								<th>Supplier Name</th>
								<th>Username</th>
								<th>Active</th>
								<th>Notify By</th>
								<th style='display:none;'>sid</th>
							  </tr>
						</thead>   
						<tbody>
							<?php
							include "connection.php";
							$sql="SELECT * FROM supplier";
							//echo $sql;
							$result = mysql_query($sql);
							$cust = array();
							while ($row = mysql_fetch_array($result))
							{
								$cust[$row['supplierid']] = $row['businessname'];
							}
							// var_dump($cust);echo "<br>";
							if(!isset($_SESSION['supplierid'])){
								$sql="SELECT * FROM salesuser ORDER BY supplierid DESC";
							}else{
								$supplierid = $_SESSION['supplierid'];
								$sql="SELECT * FROM salesuser WHERE supplierid='$supplierid' ORDER BY supplierid DESC";
							}
							
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								// var_dump($row);echo "<br>";
								$id=$row['userid']."$$"."userid"."$$".'salesuser';
								$line_id=$row['userid'];
								echo "<tr id='$line_id'>";												
								echo "<td  class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['userid']."') name='check[]' value='".$row['userid']."'></td>";
								
								$max_id=str_pad($row['userid'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$id')>DBASU{$max_id}</a></td>";
								
								echo "<td>".$row['lastname'].", ".$row['firstname']."</td>";
								echo "<td>{$cust[$row['supplierid']]}</td>";
								echo "<td>{$row['username']}</td>";
								//echo "<td>{$row['seid']}</td>";
								
								if($row['active']){
									echo "<td>Yes</td>";
								}else{
									echo "<td>No</td>";
								}
								
								echo "<td>{$row['defaultnotification']}</td>";
								echo "<td  style='display:none;'>{$row['supplierid']}</td>";
								echo "</tr>";
								
							}
							?>
						</tbody>
					</table>  
					<div>
						<button onclick="deletentries()" style="margin-right:10px"><a href="#">Delete Selected</a></button>
						<button style="margin-right:10px" id="download_csv"><a href="#">Download Selected</a></button>
						<button style="margin-right:10px" id="download_csv_all"><a href="#">Download All</a></button>
						<button id="upload_csv_btn" style="margin-right:10px"><a href="#">Upload</a></button>
					</div>
				</div>
			</div><!--/span-->			
	</div>
</div><!--/#content.span10-->


<hr>

<div class="modal hide fade" id="myModal">
	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick='hide()'>Close</button>
				<h3>Sales User Form</h3>
	</div>
	<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
	<div class="modal-body">
		<div class="box-content">
		<fieldset>
				<div class="control-group">
							<label class="control-label" for="inputError">Email Id</label>
							<div class="controls">
								<input id="eml" type="email" name="eml" onkeyup="usr_pop()" required/>  
							</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputError">Username</label>
					<div class="controls">
						<input name="username" id="partner_user_id" type="email" required readonly /> 
						<p id="alreaytag" style="color:red; display:none">User id already exist</p>
					</div>
				</div>	
				
				<div class="control-group" style='display:none;' id="regen_pass_div">
					<label class="control-label" for="inputError">Password (Auto generated)</label>
					<div class="controls">
						<input type="button" id="regen_pass" value="Regenerate Password" name="regen_pass"/>
						<!-- <input id="pwd_txt" type="password" value="123456789" onkeyup="usr_pop()" readonly /> -->
						<label id="pwd_regen_msg" style='color:red;'></label>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >First Name</label>
					<div class="controls">
						<input name="firstname" type="text" id='fname'  required />  
					</div>
				</div>	
				
				<div class="control-group">
					<label class="control-label" >Last Name</label>
					<div class="controls">
						<input name="lastname" type="text" id='lname' required />  
					</div>
				</div>	
				<?
				if(!isset($_SESSION['supplierid'])){
				?>
				<div class="control-group">
					<label class="control-label" >Supplier</label>
					<div class="controls">
						<select name="supplierid" id='supplierid' required >
						<?php
						if(isset($_GET['id']))
						{
							$id = $_GET['id'];
							$sql="SELECT * FROM supplier WHERE supplierid='$id' ";
							$result = mysql_query($sql);
							$row = mysql_fetch_array($result);
							echo "<option value='".$row['supplierid']."'>".$row['businessname']."</option>";
						}else{
							include "connection.php";
							echo "<option value=''>Select</option>";
							$sql = "SELECT * FROM supplier";
							$result = mysql_query($sql);
							while($row=mysql_fetch_array($result)){
								echo "<option value='".$row['supplierid']."'>".$row['businessname']."</option>";
							}
						}
						?>
						</select>
					</div>
				</div>
				<?
				}
				?>
				<div class="control-group">
					<label class="control-label" >User Employer ID</label>
					<div class="controls">
						<input name="seid" type="text" id="seid" required />  
					</div>
				</div>	
				
				<div class="control-group">
					<label class="control-label" >Customer</label>
					<div class="controls">
						<select id="state" multiple onchange="cusch()" >
						   <?php
						   //id="customer id" multiple
							include "connection.php";
							$sql = "SELECT * FROM customer";
							$result = mysql_query($sql);
							echo "<option value='0'>All</option>";
							while($row=mysql_fetch_array($result)){
								echo "<option value='".$row['customerid']."'>".$row['businessname']."</option>";
							}
							?>
						</select>  
					</div>
				</div>	
				<div class="control-group" style="display:none" >
					<label class="control-label" >Customer</label>
					<div class="controls">
						<input id="abc" name="customersid" type="text" required />  
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Default notification type</label>
					<div class="controls">
						<select name="defaultnotification" required >
							<option value="">Select</option>
							<option selected >In-App</option>
							<option>Email</option>
							<option>Fax</option>	
							<option>Phone</option>						
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Active</label>
					<div class="controls" >
						<select name="active" >
							<option value="1">Yes</option>
							<option value="0">No</option>			
						</select>
					</div>
				</div>			
						
			<input type='hidden' name='add_edit' id='add_edit' value='0'/>
			<input type='hidden' name='field_id' id='field_id' value='0'/>
		</fieldset>				
		</div>	
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" onclick='hide()'>Close</a>
		<input type='submit' value='Submit' name='submit' style='background-color: #4376de;background-image:-moz-linear-gradient(top, #4c7de0, #366ddc);background-image:-ms-linear-gradient(top, #4c7de0, #366ddc);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#4c7de0), to(#366ddc));background-image: -webkit-linear-gradient(top, #4c7de0, #366ddc);background-image:-o-linear-gradient(top, #4c7de0, #366ddc);background-image:linear-gradient(top, #4c7de0, #366ddc);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c7de0, endColorstr=#366ddc,GradientType=0);border-color: #366ddc #366ddc #1d4ba8;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);color: white;border-radius: 2px;height: 28px;width: 66px;font-size: 14px;' >
				<!--<a href="#" class="btn btn-primary" onclick='submit_form()' >Submit</a>-->
	</div>
	</form> 
</div>

	<div id="overlay"></div>

<? include "footer.php"?>

<script>
var ul1 = false;
var ul2 = false;
var ul3 = false;
var ul4 = false;
var ul5 = false;

	$(document).ready(function(){
			$( "#supplier_ul" ).show();
			$( "#i3" ).html('-');
			ul1 = true;
			$.ajax({
				type: "POST",
				url: "get_supplier_list.php",
				data: {action:'authenticated'}
			})
			.done(function( msg ){
				// alert(msg);
				res = JSON.parse(msg);
				// console.log(res[0].productcategoryid);
				<?php if(isset($_SESSION['supplierid']))
				{
					$supplierid = $_SESSION['supplierid'];?>
					var s='';
					for(i=0;i<res.length;i++)
					{
						if(res[i].supplierid=='<?php echo $supplierid;?>')
						{
							s=s+"<option value='"+res[i].businessname+"'>"+res[i].businessname+"</option>";
						}
					}
				<?}else{?>
				var s="<option value=''>All</option>";
					for(i=0;i<res.length;i++)
					{
						s=s+"<option value='"+res[i].businessname+"'>"+res[i].businessname+"</option>";					
					}
				<?}?>
				$("div.myTools").html('<label>Supplier</label><select id="suppliers">'+s+'</select>');
				var table=$('.datatable').dataTable();
				$('select#suppliers').change( function() { 
					if($(this).val()==''){
						table.fnFilter( $(this).val(), 3, true ); 
					}else{
						table.fnFilter( "^"+ $(this).val() +"$", 3, true ); 
					}
				});
				var add_chk = getParameterByName('add');//alert(add_chk);
				if(add_chk == 1){
					// add_new_function();//alert("ASD");
					// $(".modal-backdrop").addClass("fade");
					// $(".modal-backdrop").addClass("in");
					$("#myModal").addClass("in");
					$("#myModal").css("display","block");	
					$( "body" ).append('<div class="modal-backdrop fade in"></div>');
				}
					
			});
			
			$("#regen_pass").click(function(){
				$.ajax({
				type: "POST",
				url: "regen_pass.php",
				data: {action:'regen_pass', username:$("#partner_user_id").val(),field_id:$("#field_id").val(),type:"salesuser",firstname:$("#fname").val(),lastname:$("#lname").val()}
			})
			.done(function( msg ){
				if(msg == 'success'){
					$("#pwd_regen_msg").html("Password successfully generated");
				}else{
					$("#pwd_regen_msg").html("Please retry");
				}
				// alert(msg);
				});
			});
		});
		
$( "#supplier_li" ).click(function() {
	$( "#supplier_ul" ).slideToggle(1000);	
	if(ul1){
		$( "#i3" ).html('+');
		ul1 = false;
	}else{
		$( "#i3" ).html('-');
		ul1 = true;
	}
});
				
$( "#customer_li" ).click(function() {
	$( "#customer_ul" ).slideToggle(1000);	
	if(ul2){
		$( "#i2" ).html('+');
		ul2 = false;
	}else{
		$( "#i2" ).html('-');
		ul2 = true;
	}	
});
				
$( "#product_li" ).click(function() {
	$( "#product_ul" ).slideToggle(1000);	
	if(ul3){
		$( "#i1" ).html('+');
		ul3 = false;
	}else{
		$( "#i1" ).html('-');
		ul3 = true;
	}
});
					
$( "#node_li" ).click(function() {
	$( "#node_ul" ).slideToggle(700);
	if(ul4){
		$( "#i4" ).html('+');
		ul4 = false;
	}else{
		$( "#i4" ).html('-');
		ul4 = true;
	}
});
		function getParameterByName(name) 
				{
						name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
						var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
							results = regex.exec(location.search);
						return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
				}
		function delete_item(id)
				{
					var r = confirm("Are you sure you want to delete these entries ?");
					if (r == true) 
					{
					$("#"+id).hide();
					data='table_name=Product&field_name=Field&id='+id;
					$.ajax({
									type: "POST",				
									url: "delete_entery.php",
									data:data
									}).done(function( msg )
										{	
											//alert(msg);
										});
				}}	
				function product_edit(id){
					//alert(id);
					$("#add_edit").val(1);
					// $("#regen_pass_div").css("display","block");
					// $("#pwd_txt").css("display","none");
					$("#regen_pass_div").css("display","block");
					$("#pwd_regen_msg").html('');
					$("#myModal").show();
					$("#myModal").addClass('in');
					
					var $div = $('<div />').appendTo('body');
					$div.attr('class','modal-backdrop fade in');
					
					$.ajax({
						type: "GET",
						url: "edit.php",
						data: {d:id}
					})
					.done(function( msg ) {
						//alert(msg);
						obj = JSON.parse(msg);
						$("#field_id").val(obj['userid']);
						$("#eml").prop("disabled",false);
						var username=obj['username'];
						$("#eml").val(obj['username']);
						$("#seid").val(obj['seid']);
						$("#partner_user_id").prop("disabled",false);
						$("#partner_user_id").val($("#eml").val());
						$("#fname").val(obj['firstname']);
						$("#lname").val(obj['lastname']);
						$("#eml").prop("disabled",true);
						$("#partner_user_id").prop("disabled",true);
						$("#supplierid").val(obj['supplierid']);
						$.ajax({
						type: "GET",
						url: "get_access.php",
						data: {d:id}
						})
						.done(function( msg ) {
						});
												
					});
				}
				
				function hide()
				{					
					$("#myModal").hide();
					$(".fade").removeClass('in');
					$( ".modal-backdrop" ).remove();
					$("#regen_pass_div").css("display","none");
					$("#pwd_regen_msg").html('');					
				}
					
				function add_new_function()
					{						
						$("#add_edit").val(0);
						$(".select1 .chzn-single span").html('select');
						$(".select2 .chzn-single span").html('select');
						$(".select3 .chzn-single span").html('select');
						$(".select4 .chzn-single span").html('select');
						$(".select5 .chzn-single span").html('select');
						$(".select6 .chzn-single span").html('select');
						$(".chzn-drop").css('display','block');
						$("#all")[0].reset();					
					}
					
					var checklist = new Array();
					var checklistjson = new Array();
					function checked_entries(id){
						var index = checklist.indexOf(id);
						if(index==-1){
							var ide = {
								row:id
							}
							checklistjson.push(ide);
							checklist.push(id);
						}else{
							checklistjson.splice(index,1);
							checklist.splice(index,1);
						}
					}

					function deletentries(){
						var r = confirm("Are you sure you want to delete these entries ?");
					if (r == true) 
					{
						var str = JSON.stringify(checklistjson);
						//alert(str);
						$.ajax({
							type: "POST",
							url: "delete_check.php",
							data: {local:str, table:"salesuser", column:"userid"}
						})
						.done(function( msg ){
						
						});
						
						for(i=0;i<checklist.length;i++){
							$("#"+checklist[i]).hide();
						}
					}
					}
					
					function search_uniq(){
						var str = $("#partner_user_id").val();
						//alert(str);
						$.ajax({
							type: "GET",
							url: "search_partner.php",
							data: {term:str}
						})
						.done(function( msg ){
						//alert(msg);
							if(msg==1){
								$("#alreaytag").show();
								//document.getElementById("alsubmt").disabled = true;
							}else{
								$("#alreaytag").hide();
								//document.getElementById("alsubmt").disabled = false;
							}
						});
					}
					
					function check_password(){
						var fpass = $("#fpass").val();
						var cpass = $("#cpass").val();
						if(fpass!=cpass){
							$("#ppass").show();
						}else{
							$("#ppass").hide();
						}
					}
					function cusch(){
						var abc = $("#state").val();
						if(abc=='0'){
							$("#state option").prop('selected', true);
						}
						abc = $("#state").val();
						$("#abc").val(abc);
						//alert(abc);
					}
					
					function usr_pop(){
						$("#partner_user_id").val($("#eml").val());
						search_uniq();
					}
					$("#download_csv").on("click", function(e){
						download_csv_selected('salesuser',checklist,'sales_user','submit','userid');
						// if(checklist.length == 0){
							// alert("Please select a record.");
						// }else{
							// location.href="dba_export_csv.php?type=salesuser&list="+checklist+"&page_name=sales_user&action=submit&type_nam=userid";
						// }						
					});
					$("#download_csv_all").on("click", function(e){
						location.href="dba_export_csv.php?type=salesuser&list="+checklist+"&page_name=sales_user&action=submit&type_nam=userid";			
					});
					$("#upload_csv_btn").on("click", function(e){
						$("#upload_hover").empty();
						$("#upload_hover").css("display","block");
						$("#upload_hover").load("create_sales_user_csv_upload.php");
					});
					$("#upload_csv_btn").on("click", function(e){
		$("#overlay").css("display","block");
		});
		var checkss=0;
					function check_all()
					{
						if(checkss==0)
						{
							checkss=1;							
							$($(".table").dataTable().fnGetNodes()).find('.check_box1').each(function ()
							{
									$this = $(this);
									$this.find(".checker span").addClass("checked");
									$this.find(".check_box").attr('checked', 'checked');
									
								
							});

							$($(".table").dataTable().fnGetNodes()).find(':checkbox').each(function () {
									$this = $(this);
									$this.attr('checked', 'checked');
									var id=$this.val();								
									var ide = {
									row:id
									}
								checklistjson.push(ide);
								checklist.push(id);	
								
							});
							
						}
						else
						 {
							$(".check_box").attr("checked",false);
							$(".checker span").removeClass();
							checkss=0;
							$($(".table").dataTable().fnGetNodes()).find('.check_box1').each(function ()
							{
								$this = $(this);
								$this.find(".checker span").removeClass();
								$this.find(".check_box").attr('checked',false);
							});
								checklistjson=[];
								checklist=[];
							
						}
					
									
					}
</script>