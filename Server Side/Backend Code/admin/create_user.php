<?php
include "connection.php";

if (isset($_POST['upload_csv'])) {
	if (is_uploaded_file($_FILES['filename']['tmp_name']) && !empty($_FILES['filename']['tmp_name'])) {
		// echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
	

		$emailval = '/([\w\-]+\@[\w\-]+\.[\w\-]+)/';
		$mob='/^\d+$/';
		
		//Import uploaded file to Database
		$handle = fopen($_FILES['filename']['tmp_name'], "r");
		$hdata = fgetcsv($handle, 1000, ",");
		$header ="";
		foreach($hdata as $h)
		{
			//if(trim($h)!="")
			$header .= trim($h) . ', ';
		}
		$header .= 'Error Description';
		$status = "true";
		$msg = "";
		$line_no=2;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{	
			
			if((trim($data[1])=="")||($data[2]=="")||($data[3]=="")||($data[4]==""))
			{
				foreach($data as $h)
				{
					//if(trim($h)!="")
						$out .= trim($h) . ', ';
				}
				$msg = "Some important field is missing. Not uploading.<br> ";
				$status = "false";
				$out .= "Error at row - ". $line_no;
				$out .= "\n";
			}
			else if (!ctype_digit(trim($data[5])) OR strlen(trim($data[5])) != 10)
			{
				foreach($data as $h)
				{
					//if(trim($h)!="")
						$out .= trim($h) . ', ';
				}
				$msg.="Check your Mobile number. Not uploading.<br> ";
				$status = "false";
				$out .= "Error at row - ". $line_no;
				$out .= "\n";
				//break;
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
					$out .= "Check your email. Error at row - ". $line_no;
					$out .= "\n";
					//break;
				}
				else
				{
					$user_id = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
					$username = trim($data[1]);
					$fname = trim($data[2]);
					$lname = trim($data[3]);
					$customerId = trim($data[4]);
					$phone = trim($data[5]);
					$notifyId = trim($data[6]);
					$defaultnotification = trim($data[7]);
					$ceid = trim($data[8]);
					$password=generateRandomString();
					
					if(trim($data[0])=='')
					{			
						$sql = "INSERT INTO user(username, password, firstname, lastname, customerid, active, defaultnotification,ceid,phone)VALUES('$username', '$password', '$fname', '$lname', '$customerId', '1', '$defaultnotification','$ceid','$phone')";
					
						mysql_query($sql);
						echo mysql_error();
						
						$to=$username;
						$subject="Welcome to DBA-Farmbrain";
						$body="Username: ".$username."<br>password: ".$password;
						$headers = 'From: dba.com' . "\r\n" .
							'Reply-To: info@dba.com' . "\r\n" .
							'X-Mailer: PHP/' . phpversion();
						$headers.="MIME-Version: 1.0" . "\r\n";
						$headers.="Content-type:text/html;charset=iso-8859-1" . "\r\n";
							
						mail($to,$subject,$body,$headers);
					}
					else
					{
						$sql = "UPDATE user SET username='$username', password='$password', firstname='$firstname', lastname='$lastname', customerid='$customerid', active='$active', defaultnotification='$defaultnotification' WHERE userid='$id' ";
						mysql_query($sql);
					}
					$msg="Upload successfully";
				}
			}
			$line_no++;
		}
		if($out!="")
		{
			// echo "<script></script>";
			echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');alert('Uploaded but with some errors');</script>";
		}else{
			echo "<script>alert('Uploaded Successfully');</script>";
		}
		// echo $msg;
		fclose($handle);
	}else{
		echo "<script>alert('Please choose a file to upload');</script>";
	}
	//view upload form
}
else if(isset($_REQUEST['submit'])){
		$username = $_POST['username'];
		$password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$customerid = $_POST['customerid'];
		$defaultnotification = $_POST['defaultnotification'];
		$ceid = $_POST['ceid'];
		$phone = $_POST['phone'];
		$active = $_POST['active'];
		$add_edit=$_POST['add_edit'];
		if($add_edit==0){
			$sql = "INSERT INTO user(username, password, firstname, lastname, customerid, active, defaultnotification,ceid,phone)VALUES('$username', '$password', '$firstname', '$lastname', '$customerid', '$active', '$defaultnotification','$ceid','$phone')";
			mysql_query($sql);
			echo mysql_error();
			
			$to=$username;
			$subject="Welcome to DBA-Farmbrain";
			// $body="Username: ".$username."<br>password: ".$password;
			$body = $firstname." ".$lastname."<br /><br />
			Welcome to Farmbrain (DBA).<br /><br />
			Please download the app by clicking this link.<br /><br />
			You have been registered as a Customer User for ". $firstname ." ". $lastname ."<br /><br />
			Your user credentials are - <br />".
			$username ."<br />".
			$password ."<br /><br />
			Please change this password once you login. <br /><br />
			Best,<br /><br />
			Farmbrain DBA <br />";
			$headers = 'From: dba.com' . "\r\n" .
				'Reply-To: info@dba.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			$headers.="MIME-Version: 1.0" . "\r\n";
			$headers.="Content-type:text/html;charset=iso-8859-1" . "\r\n";
				
			//mail($to,$subject,$body,$headers);
			curl_post($to,$subject,$body);
		}
		else{
		
			$id=$_POST['field_id'];
			$sql = "UPDATE user SET username='$username', password='$password', firstname='$firstname', lastname='$lastname', customerid='$customerid', active='$active', defaultnotification='$defaultnotification' WHERE userid='$id' ";
			mysql_query($sql);
		}
		header('Location: ' . basename($_SERVER['PHP_SELF']));;
	}	
	include "header.php";
	include "menu.php";
	
	function curl_post($email_to,$subject,$message)
	{
		$subject="Welcome to Dutch Bakers Associated";
		$data_string = "msg=".$message."&email_to=".$email_to."&subject=".$subject;
		$ch = curl_init('http://http://104.131.176.201/PHPMailer-master/examples/dba_gmail.php');                                                               
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
		$result = curl_exec($ch);
	}

?>

			<div id='upload_hover'></div>
			<!-- left menu ends -->
			<div id="content" class="span10">
			<!-- content starts -->
			<!-- bread crum -->
			<div class='bread'>
				<ul class="breadcrumb">
					<li class="step">
						<a href="index.php">Home</a>
					</li>
					<li class="step">
						<a href="#">Customers</a>
					</li>
					<li class="step">
						<a href="#" class="active1">Customer User</a>
					</li>
				</ul>
			</div>
			<!-- end bread crum -->
			
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Customer User</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 113px;'><i class="icon-cog"></i> Add User</a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th><input type="checkbox" onclick="check_all()"/></th>
								  <th>User ID</th>
								  <th>Customer Name</th>
								  <th>Full Name</th>
								  <th>Phone</th>
								  <th>Email</th>
								  <th>Notify By</th>
								  <th style="display:none;">cid</th>
							  </tr>
						  </thead>   
						<tbody>
						  <?php
							include "connection.php";
							$sql="SELECT * FROM customer";
							//echo $sql;
							$result = mysql_query($sql);
							$cust = array();
							while ($row = mysql_fetch_array($result))
							{
								$cust[$row['customerid']] = $row['businessname'];
							}
							$sql="SELECT * FROM user ORDER BY userid DESC";
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['userid']."$$"."userid"."$$".'user';
								$line_id=$row['userid'];
								echo "<tr id='$line_id'>";
								
								echo "<td  class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['userid']."') name='check[]' value='".$row['userid']."'></td>";
								
								$max_id=str_pad($row['userid'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$id')>DBACU{$max_id}</a></td>";
								//echo "<td>{$row['username']}</td>";
								echo "<td>{$cust[$row['customerid']]}</td>";
								echo "<td>".$row['lastname'].", ".$row['firstname']."</td>";
								echo "<td>{$row['phone']}</td>";
								echo "<td>{$row['username']}</td>";								
								//echo "<td>{$row['ceid']}</td>";
								
								/* if($row['active']==1){
									echo "<td>Active</td>";
								}else{
									echo "<td>Deactive</td>";
								} */
								
								echo "<td>{$row['defaultnotification']}</td>";
								echo "<td style='display:none;'>{$row['customerid']}</td>";
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
			</div><!--/row-->		
		<!-- content ends -->
		</div><!--/#content.span10-->
				
		<hr>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick='hide()'>Close</button>
				<h3>Create a Customer User</h3>
			</div>
			<div class="modal-body">
				<div class="box-content">
				<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
					
						<fieldset>
							<div class="control-group">
							<label class="control-label" for="inputError">Email Id</label>
							<div class="controls">
								<input id="eml" type="email" name="eml" onkeyup="usr_pop()" required />  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Username</label>
							<div class="controls">
								 <input id="partner_user_id" type="email" name="username" required readonly /><p id="alreaytag" style="color:red; display:none">User id already exist</p>  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Password (Auto generated)</label>
							<div class="controls">
								<input type="button" id="regen_pass" value="Regenerate Password" name="regen_pass" style='display:none;'/>
								<input id="pwd_txt" type="password" value="123456789" onkeyup="usr_pop()" readonly />
								<label id="pwd_regen_msg" style='display:none;color:red;'></label>
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">First Name</label>
							<div class="controls">
								<input type="text" id="firstname" name="firstname" required /> 
							</div>
							</div>
							
							
							<div class="control-group">
							<label class="control-label" for="inputError">Last Name</label>
							<div class="controls">
								<input type="text" id="lastname" name="lastname" required />  
							</div>
							</div>
							
							
							<div class="control-group">
								<label class="control-label" for="product_attribute">Customer</label>
								<div class="controls">
									<select name="customerid" id="customerid" required >
									<?
									include "connection.php";
									$sql = "SELECT * FROM customer";
									echo "<option value=''>Select</option>";
									$result = mysql_query($sql);
									while($row=mysql_fetch_array($result)){
										echo "<option value='".$row['customerid']."'>".$row['businessname']."</option>";
									}
									?>
								  </select>
								</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">User Employer ID</label>
							<div class="controls">
								<input type="text" id="ceid" name="ceid"/>  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Phone</label>
							<div class="controls">
								<input type="text" id="phone" name="phone" pattern=".{14}" required title="10 characters minimum"/>  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Active</label>
							<div class="controls">
								<select name="active" id="active" >
									<option value="1">Yes</option><option value="0">No</option></select>  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Notify By</label>
							<div class="controls">
								<select name="defaultnotification" id="defaultnotification" required >
									<option value="">Select</option>
									<option selected>In-App</option>
									<option>Email</option>
									<option>Fax</option>
									<option>Phone</option>
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
<?php	
	include "footer.php";
	
?>
<script>
var ul1 = false;
var ul2 = false;
var ul3 = false;
var ul4 = false;
var ul5 = false;

$(document).ready(function(){
	$( "#customer_ul" ).show();
	$( "#i2" ).html('-');
	ul2 = true;
	$.ajax({
		type: "POST",
		url: "get_customer_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
			s=s+"<option>"+res[i].businessname+"</option>";
		}
		
		$("div.myTools").html('<label>Customer</label><select id="customers">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#customers').change( function() { 
			if($(this).val()=='')
			{
				table.fnFilter( $(this).val(), 2, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 2, true ); 
			}
		});
		
		
		
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	var add_chk=getParameterByName('add');
		//alert(add_chk);
		if(add_chk == 1){
			$("#myModal").addClass("in");
			$("#myModal").css("display","block");	
			$( "body" ).append('<div class="modal-backdrop fade in"></div>');
		}
		
	$("#regen_pass").click(function(){
		$.ajax({
		type: "POST",
		url: "regen_pass.php",
		data: {action:'regen_pass', username:$("#partner_user_id").val(),field_id:$("#field_id").val(),type:"user",firstname:$("#firstname").val(),lastname:$("#lastname").val()}
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
function getParameterByName(name) {
						name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
						var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
							results = regex.exec(location.search);
						return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
					}
					
		function delete_item(id)
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
				}	
				function product_edit(id){
					//alert(id);
					$("#add_edit").val(1);
					$("#regen_pass").css("display","block");
					$("#pwd_txt").css("display","none");
					$("#pwd_regen_msg").css("display","block");
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
						$("#eml").val(obj['username']);
						$("#partner_user_id").val(obj['username']);
						$("#password").val(obj['password']);
						$("#firstname").val(obj['firstname']);
						$("#lastname").val(obj['lastname']);
						$("#customerid").val(obj['customerid']);
						$("#active").val(obj['active']);
						$("#defaultnotification").val(obj['defaultnotification']);
						$("#ceid").val(obj['ceid']);
						$("#phone").val(obj['phone']);
						
					});
				}
				
				function hide()
				{					
					$("#myModal").hide();
					$(".fade").removeClass('in');
					$( ".modal-backdrop" ).remove();	
					$("#regen_pass").css("display","none");
					$("#pwd_txt").css("display","block");
					$("#pwd_regen_msg").css("display","none");
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
							url: "deactive_check.php",
							data: {local:str, table:"user", column:"userid"}
						})
						.done(function( msg ){
						//	alert(msg);
							
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
					
					
					function usr_pop(){
						$("#partner_user_id").val($("#eml").val());
						search_uniq();
					}
					$("#download_csv").on("click", function(e){
						download_csv_selected('user', checklist, 'user', 'submit', 'userid');
						// location.href="dba_export_csv.php?type=user&list="+checklist+"&page_name=user&action=submit&type_nam=userid";
					});
					$("#download_csv_all").on("click", function(e){
						location.href="dba_export_csv.php?type=user&list=&page_name=user&action=submit&type_nam=userid";
					});
					$("#upload_csv_btn").on("click", function(e){
						$("#upload_hover").empty();
						$("#upload_hover").css("display","block");
						$("#upload_hover").load("create_user_upload_csv.php");
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