<?php
include "connection.php";
session_start();

if(isset($_REQUEST['upload_csv'])){
	if (is_uploaded_file($_FILES['filename']['tmp_name']) && !empty($_FILES['filename']['tmp_name'])) {
		// echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		
		// echo "HERE";die;
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
		$err = false;
		$line_no=2;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			//echo $data[0];
			if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])=="")||(trim($data[8])=="")||(trim($data[9])=="")||(trim($data[11])=="")||(trim($data[12])=="")||(trim($data[13])=="")||(trim($data[14])=="")||(trim($data[15])=="")||(trim($data[16])=="")||(trim($data[17])=="")||(trim($data[18])=="")||(trim($data[19])=="")||(trim($data[21])=="")||(trim($data[22])=="")||(trim($data[23])=="")||(trim($data[25])=="")||(trim($data[26])==""))
			{
				$msg = "Some field is missing. Not uploading.<br> ";
				$out .= $data[0] . ', ';
				$out .= $data[1] . ', ';
				$out .= $data[2] . ', ';
				$out .= $data[3] . ', ';
				// $out .= $data[4] . ', ';
				$out .= $data[5] . ', ';
				$out .= $data[6] . ', ';
				$out .= $data[7] . ', ';
				$out .= $data[8] . ', ';
				$out .= $data[9] . ', ';
				// $out .= $data[10] . ', ';
				$out .= $data[11] . ', ';
				$out .= $data[12] . ', ';
				$out .= $data[13] . ', ';
				$out .= $data[14] . ', ';
				$out .= $data[15] . ', ';
				$out .= $data[16] . ', ';
				$out .= $data[17] . ', ';
				$out .= $data[18] . ', ';
				$out .= $data[19] . ', ';
				// $out .= $data[20] . ', ';
				$out .= $data[21] . ', ';
				$out .= $data[22] . ', ';
				$out .= $data[23] . ', ';
				// $out .= $data[24] . ', ';
				$out .= $data[25] . ', ';
				$out .= $data[26] . ', ';
				$out .= "Some field is missing at line - " . $line_no . ', ';
				$out .= "\n";
				$err=true;
			}
			else 
			{
				if (!filter_var(trim($data[11]), FILTER_VALIDATE_EMAIL))
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
				}
				else
				{
					$supplierid = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
					$businessname = trim($data[1]);
					$businessownername = trim($data[2]);
					$address1 = trim($data[3]);
					$address2 = trim($data[4]);
					$city = trim($data[5]);
					$state = trim($data[6]);
					$country = trim($data[7]);
					$zip = trim($data[8]);
					$phone = trim($data[9]);
					$fax = trim($data[10]);
					$email = trim($data[11]);
					$cellphone = trim($data[12]);
					$defaultnotification = trim($data[13]);
					$DUNS = trim($data[14]);
					$federalidnumber = trim($data[15]);
					$hoursofoperation1 = trim($data[16]);
					$hoursofoperation2 = trim($data[17]);
					$daysofoperation = trim($data[18]);
					$serviceradius	= trim($data[19]);
					$website = trim($data[20]);
					$businesspic = trim($data[21]);
					$listofdocuments = trim($data[22]);
					$suppliertype = trim($data[23]);
					$approved = 1; //trim($data[24]);
					$mov = trim($data[25]);
					$otv = trim($data[26]);
					$password=generateRandomString(); //random password
					
					if($supplierid == ''){
						$supplierid=0;
					}
					$sql = "select * from supplier where supplierid='".$supplierid."'";
					$res = mysql_query($sql);
					if(mysql_num_rows($res)>0){
						// echo "HERE";die;
						$sql = "UPDATE supplier SET businessname='$businessname', businessownername='$businessownername', address1='$address1', address2='$address2', city='$city', state='$state', country='$country', zip='$zip', phone='$phone', fax='$fax', email='$email', cellphone='$cellphone', defaultnotification='$defaultnotification', DUNS='$DUNS', federalidnumber='$federalidnumber', hoursofoperation1='$hoursofoperation1', hoursofoperation2='$hoursofoperation2', daysofoperation='$daysofoperation', serviceradius='$serviceradius', website='$website', suppliertype='$suppliertype', approved='$approved', mov='$mov', otv='$otv' WHERE supplierid='$supplierid'";
						$result = mysql_query($sql);
						$sql = "update suppliercustomer set supplierbusinessname='$businessname' where supplierid='$supplierid'";
						$result = mysql_query($sql);
						echo mysql_error();
					}else{
					// echo "HERE1";die;
						$sql = "INSERT INTO supplier(businessname, businessownername, address1, address2, city, state, country, zip, phone, fax, email, cellphone, defaultnotification, DUNS, federalidnumber, hoursofoperation1, hoursofoperation2, daysofoperation, serviceradius, website, businesspic, listofdocuments, suppliertype, approved,mov,otv) VALUES ('$businessname', '$businessownername', '$address1', '$address2', '$city', '$state', '$country', '$zip', '$phone', '$fax', '$email', '$cellphone', '$defaultnotification', '$DUNS', '$federalidnumber', '$hoursofoperation1', '$hoursofoperation2', '$daysofoperation', '$serviceradius', '$website', '$businesspic', '$listofdocuments', '$suppliertype', '$approved','$mov','$otv')";
						$result = mysql_query($sql);
						echo mysql_error();
						
						$sql = "INSERT INTO user(username, password, firstname, lastname, customerid, active, defaultnotification,ceid,phone)VALUES('$email', '$password', '$fname', '$lname', '$customerId', '1', '$defaultnotification','$ceid','$phone')";
						mysql_query($sql);
						echo mysql_error();
						
						//Mailer function
						$to=$email;
						$subject="Welcome to DBA-Farmbrain";
						$body="Username: ".$email."<br>password: ".$password;
						$headers = 'From: dba.com' . "\r\n" .
							'Reply-To: info@dba.com' . "\r\n" .
							'X-Mailer: PHP/' . phpversion();
						$headers.="MIME-Version: 1.0" . "\r\n";
						$headers.="Content-type:text/html;charset=iso-8859-1" . "\r\n";
							
						mail($to,$subject,$body,$headers);
						//end mailer
						
						$sql = "SELECT * FROM customer";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result)){
							$customerid = $row['customerid'];
							$customerbusinessname = $row['businessname'];
							$sql1 = "INSERT INTO suppliercustomer(supplierid, customerid, customerbusinessname, salesuserid, salesfirstname, saleslastname, suppliersidecustomerid, minimumordervalue, ordertolerancevalue, approve) VALUES ('$supplierid', '$customerid', '$customerbusinessname', '', '', '', '', '$mov', '$otv', 0)"; 
							$result1 = mysql_query($sql1);
							echo mysql_error();
						}
					}
				}
			}
			$line_no += 1;
		}
		if($err)
		{
			echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');alert('Uploaded but with some errors');</script>";
		}else{
			echo "<script>alert('Uploaded Successfully');</script>";
		}
		// echo $msg;
		fclose($handle);
	}else{
		echo "<script>alert('Please choose a file to upload');</script>";
	}
	
}
else if(isset($_REQUEST['submit'])){
		$username = $_POST['username']; 
		$firstname = $_POST['firstname']; 
		$lastname = $_POST['lastname']; 
		$password = substr(md5(uniqid(mt_rand(), true)), 0, 5); 
		$businessname = $_POST['businessname']; 
		$businessownername = $_POST['businessownername']; 
		$address1 = $_POST['address1'];
		$address2 = $_POST['address2'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$country = $_POST['country'];
		$zip = $_POST['zip'];
		$phone = $_POST['phone'];
		$fax = $_POST['fax'];
		$email = $_POST['email'];
		$cellphone = $_POST['cellphone'];
		$defaultnotification = $_POST['defaultnotification'];
		$DUNS = $_POST['DUNS'];
		$federalidnumber = $_POST['federalidnumber'];
		$hoursofoperation1 = $_POST['hoursofoperation1'];
		$hoursofoperation2 = $_POST['hoursofoperation2'];
		$daysofoperation = $_POST['dopr'];
		$status = $_POST['status'];
		$days = array("Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat");
		$dop='';
		foreach($days as $selected){
			switch($selected){
				case "Sun":
					$dop .= (in_array($selected, $daysofoperation)? "t" : "f");
					break;
				case "Mon":
					$dop .= (in_array($selected, $daysofoperation)? "t" : "f");
					break;
				case "Tue":
					$dop .= (in_array($selected, $daysofoperation)? "t" : "f");
					break;
				case "Wed":
					$dop .= (in_array($selected, $daysofoperation)? "t" : "f");
					break;
				case "Thur":
					$dop .= (in_array($selected, $daysofoperation)? "t" : "f");
					break;
				case "Fri":
					$dop .= (in_array($selected, $daysofoperation)? "t" : "f");
					break;
				case "Sat":
					$dop .= (in_array($selected, $daysofoperation)? "t" : "f");
					break;
				default:
			}
			// echo $selected."</br>";
		}
		
		$serviceradius = "";
		$website = $_POST['website'];
		$mov = $_POST['mov'];
		$otv = $_POST['otv'];
		//$suppliertype = "";
		$suppliertype = $_POST['suppliertype'];
		$approved = $_POST['approved'];
		$add_edit=$_POST['add_edit'];
		if($add_edit==0)
		{
			if(!file_exists($_FILES['businesspic']['tmp_name']) || !is_uploaded_file($_FILES['businesspic']['tmp_name']))
			{
				$businesspic='a';
			}
			else
			{
				$businesspic=upload_file('businesspic');
			}
			if(!file_exists($_FILES['listofdocuments']['tmp_name']) || !is_uploaded_file($_FILES['listofdocuments']['tmp_name']))
			{
			$listofdocuments='a';
			}else
			{
				$listofdocuments=upload_file1('listofdocuments');
			}
			$sql = "INSERT INTO supplier(businessname, businessownername, address1, address2, city, state, country, zip, phone, fax, email, cellphone, defaultnotification, DUNS, federalidnumber, hoursofoperation1, hoursofoperation2, daysofoperation, serviceradius, website, businesspic, listofdocuments, suppliertype, approved,mov,otv,active) VALUES ('$businessname', '$businessownername', '$address1', '$address2', '$city', '$state', '$country', '$zip', '$phone', '$fax', '$email', '$cellphone', '$defaultnotification', '$DUNS', '$federalidnumber', '$hoursofoperation1', '$hoursofoperation2', '$dop', '$serviceradius', '$website', '$businesspic', '$listofdocuments', '$suppliertype', '$approved','$mov','$otv','$status')";
		
			$result = mysql_query($sql);
			echo mysql_error();
			
			$sql="SELECT MAX(supplierid) FROM supplier";
			$result=mysql_query($sql);
			$temp=mysql_fetch_array($result);
			$supplierid = $temp['MAX(supplierid)'];
		
			$sql = "INSERT INTO salesuser(username, password, firstname, lastname, supplierid, active, defaultnotification) VALUES ('$username', '$password', '$firstname', '$lastname', '$supplierid', '1', '$defaultnotification')"; 
			$result = mysql_query($sql);
			
			
			$sql="SELECT MAX( userid  ) FROM salesuser";
			$result=mysql_query($sql);
			$temp=mysql_fetch_array($result);
			$max_id = $temp['MAX( userid  )'];
			
			$sql = "INSERT INTO access_level(salesuserid,customerid)VALUES('$max_id','0')";
			$result=mysql_query($sql);
			
			$to=$username;
			$subject="You have been added to the DBA account";
			$body="Username: ".$username."<br>password: ".$password;
			
				
			//mail($to,$subject,$body,$headers);
			if($suppliertype=='LITE')
			{
				$subject="You have been added to the DBA account";
				curl_post_lite($to,$subject,$body,$username,$password,$businessname);				
			}
			else
			{
				curl_post($to,$subject,$body,$username,$password,$businessname);
			}
			$sql = "SELECT * FROM customer";
			$result = mysql_query($sql);
			while($row=mysql_fetch_array($result)){
				$customerid = $row['customerid'];
				$customerbusinessname = $row['businessname'];
				
				$sql1 = "INSERT INTO suppliercustomer(supplierid, customerid, customerbusinessname, salesuserid, salesfirstname, saleslastname, suppliersidecustomerid, minimumordervalue, ordertolerancevalue, approve) VALUES ('$supplierid', '$customerid', '$customerbusinessname', '', '', '', '', '$mov', '$otv', 0)"; 
				$result1 = mysql_query($sql1);
				echo mysql_error();
				}
		}
		else
		{	
			$id=$_POST['field_id'];
			if(!file_exists($_FILES['businesspic']['tmp_name']) || !is_uploaded_file($_FILES['businesspic']['tmp_name']))
			{}
			else
			{	$businesspic=upload_file('businesspic');
				$sql1 = "UPDATE supplier SET businesspic='$businesspic' where supplierid='$id'";
				mysql_query($sql1);
			}
			if(!file_exists($_FILES['listofdocuments']['tmp_name']) || !is_uploaded_file($_FILES['listofdocuments']['tmp_name']))
			{}
			else
			{
				$listofdocuments=upload_file1('listofdocuments');
				$sql1 = "UPDATE supplier SET listofdocuments='$listofdocuments' where supplierid='$id'";
				mysql_query($sql1);
			}
			
			
			$sql = "UPDATE supplier SET businessname='$businessname', businessownername='$businessownername', address1='$address1', address2='$address2', city='$city', state='$state', country='$country', zip='$zip', phone='$phone', fax='$fax', email='$email', cellphone='$cellphone', defaultnotification='$defaultnotification', DUNS='$DUNS', federalidnumber='$federalidnumber', hoursofoperation1='$hoursofoperation1', hoursofoperation2='$hoursofoperation2', daysofoperation='$dop', serviceradius='$serviceradius', website='$website', suppliertype='$suppliertype', approved='$approved', mov='$mov', otv='$otv',active='$status' WHERE supplierid='$id'";
			$result = mysql_query($sql);
			echo mysql_error();
			
		}
		header('Location: http://104.131.176.201/admin/sup_reg.php');
	}
function upload_file($arg)
{
		$image_name_new = "a";
		$temp = explode(".", $_FILES[$arg]["name"]);
		$allowedExts = array("gif", "jpeg", "jpg", "png");		
		$extension = end($temp);
		if ((($_FILES[$arg]["type"] == "image/gif")
		|| ($_FILES[$arg]["type"] == "image/jpeg")
		|| ($_FILES[$arg]["type"] == "image/jpg")		
		|| ($_FILES[$arg]["type"] == "image/png"))
		&& ($_FILES[$arg]["size"] < 200000)
		&& in_array($extension, $allowedExts)) {
		  if ($_FILES[$arg]["error"] > 0) {
			echo "Return Code: " . $_FILES[$arg]["error"] . "<br>";
		  } 
		  else
		  {			
			$image_name=rand(1,100000);
			$image_name_new=$arg."_".$image_name.".".$extension;			
			if (file_exists("upload/" . $_FILES[$arg]["name"])) {
			  echo $_FILES[$arg]["name"] . " already exists. ";
			} 
			else 
			{
			  move_uploaded_file($_FILES[$arg]["tmp_name"],"upload/".$image_name_new);			  
			}
		  }
		}
		return $image_name_new;
	}
function upload_file1($arg)
{		
		$image_name_new = "a";
		$temp = explode(".", $_FILES[$arg]["name"]);
		$allowedExts = array("docx", "pdf");		
		$extension = end($temp);
	
		  if ($_FILES[$arg]["error"] > 0) {
			echo "Return Code: " . $_FILES[$arg]["error"] . "<br>";
		  } 
		  else
		  {			
			$image_name=rand(1,100000);
			$image_name_new=$arg."_".$image_name.".".$extension;			
			if (file_exists("upload/" . $_FILES[$arg]["name"])) {
			  echo $_FILES[$arg]["name"] . " already exists. ";
			} 
			else 
			{
			  move_uploaded_file($_FILES[$arg]["tmp_name"],"upload/".$image_name_new);			  
			}
		  }
		
		return $image_name_new;
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
		$data_string = "msg=".$message."&email_to=".$email_to."&subject=".$subject."&username=".$uname."&password=".$pass."&name=".$name;
		
		$ch = curl_init('http://104.131.176.201/PHPMailer-master/examples/test_mail.php');                                                               
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
		$result = curl_exec($ch);
	}
	
function curl_post_lite($email_to,$subject,$message,$uname,$pass,$name)
{
	$data_string = "msg=".$message."&email_to=".$email_to."&subject=".$subject."&username=".$uname."&password=".$pass."&name=".$name;
	
	$ch = curl_init('http://104.131.176.201/PHPMailer-master/examples/lite_user_supplier.php');                                                               
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
						<a href="#" class="active1">Supplier</a>
					</li>
				</ul>
			</div>
			<!-- end bread crum -->
	<div class="row-fluid sortable">		
			<div class="box span12">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-user"></i>Supplier</h2>
					<div class="box-icon">
					<?php if(isset($_SESSION["superadmin"]) && $_SESSION["superadmin"] == 1){ ?>
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 120px;'><i class="icon-cog"></i> Add Supplier</a>
					<?php } ?>
					</div>
				</div>
				<div class="box-content">
					<table class="table table-striped table-bordered bootstrap-datatable datatable">
						<thead>
							<tr>
								<th><input type="checkbox" onclick="check_all()"/></th>
								<th>Id</th>
								<th>Supplier Name</th>
								<th>City</th>
								<th>State</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Notify By</th>
								<th>Type</th>
								<th>Approve</th>
								<th>Status</th>
							  </tr>
						</thead>   
						<tbody>
							<?php
							include "connection.php";
							if(!isset($_SESSION['supplierid'])){
								$sql="SELECT * FROM supplier ORDER BY supplierid DESC";
							}else{
								$supplierid = $_SESSION['supplierid'];
								$sql="SELECT * FROM supplier WHERE supplierid='$supplierid'  ORDER BY supplierid DESC";
							}
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['supplierid']."$$"."supplierid"."$$".'supplier';
								$line_id=$row['supplierid'];
								echo "<tr id='$line_id'>";
								
								echo "<td  class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['supplierid']."') name='check[]' value='".$row['supplierid']."'></td>";
								
								
								$max_id=str_pad($row['supplierid'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$id')>DBAS{$max_id}</a></td>";
								echo "<td>{$row['businessname']}</td>";
								echo "<td>{$row['city']}</td>";
								echo "<td>{$row['state']}</td>";
								echo "<td>{$row['cellphone']}</td>";
								echo "<td>{$row['email']}</td>";
								echo "<td>{$row['defaultnotification']}</td>";
								echo "<td>{$row['suppliertype']}</td>";
								if($row['approved']){
									echo "<td>Yes</td>";
								}
								else{
									echo "<td id='ab".$row['supplierid']."' ><a href='#' class='btn btn-info' onclick=approve_customer('".$row['supplierid']."') style='height: 19px;width: 80px;'><i class='icon-cog'></i>Approve</a></td>";
								}
								if($row['active']==1){
									echo "<td>Active</td>";
								}
								else{
									echo "<td>Inactive</td>";
								}
								
								echo "</tr>";
								
							}
							?>
						</tbody>
					</table>  
					<div>
					<?php
					if(!isset($_SESSION["supplierid"])){
					?>
						<button onclick="deletentries()" style="margin-right:10px"><a href="#">Delete Selected</a></button>						
						<button style="margin-right:10px" id="download_csv"><a href="#">Download Selected</a></button>
						<button style="margin-right:10px" id="download_csv_all"><a href="#">Download All</a></button>						
						<button id="upload_csv_btn" style="margin-right:10px"><a href="#">Upload</a></button>
					<?php
					}
					?>
					</div>
				</div>
			</div><!--/span-->			
	</div>
</div><!--/#content.span10-->


<hr>

<div class="modal hide fade" id="myModal">
	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick='hide()'>Close</button>
				<h3>Supplier Registration Form</h3>
	</div>
	<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
	<div class="modal-body">
		<div class="box-content">
		<fieldset>
				<div id="su">
				
					<div class="control-group">
							<label class="control-label" for="inputError">Sales Mgr's Email Id</label>
							<div class="controls">
								<input id="eml" type="email" name="eml" onkeyup="usr_pop()" required />  
							</div>
					</div>
				
				<div class="control-group">
					<label class="control-label" for="inputError">Username</label>
					<div class="controls">
						<input name="username" id="partner_user_id" type="email"required readonly /> 
						<p id="alreaytag" style="color:red; display:none">User id already exist</p>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >First Name</label>
					<div class="controls">
						<input name="firstname" id="firstname" type="text"  required />  
					</div>
				</div>	
				
				<div class="control-group">
					<label class="control-label" >Last Name</label>
					<div class="controls">
						<input name="lastname" id="lastname" type="text" required />  
					</div>
				</div>	
				</div>
				<div class="control-group">
					<label class="control-label" >Notify By</label>
					<div class="controls">
						<select name="defaultnotification" id="defaultnotification" required >
							<option value="">Select</option>
							<option selected>Email</option>
							<option>Phone</option>						
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Supplier Name</label>
					<div class="controls">
						<input name="businessname" id="businessname" type="text" required />  
					</div>
				</div>	
				
				<div class="control-group">
					<label class="control-label" >Business Owner Name</label>
					<div class="controls">
						<input name="businessownername" id="businessownername" type="text" />  
					</div>
				</div>	
				
				<div class="control-group">
					<label class="control-label" >Address1</label>
					<div class="controls">
						<input name="address1" id="address1" type="text" required />  
					</div>
				</div>	
				
				<div class="control-group">
					<label class="control-label" >Address2</label>
					<div class="controls">
						<input name="address2" id="address2" type="text" />  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Zip</label>
					<div class="controls">
						<input name="zip" id="zip" type="text" onkeyup="zipcode('zip')" pattern=".{5}"  title="5 digits minimum" required />  
					</div>
				</div>	
				
				<div class="control-group">
					<label class="control-label" >City</label>
					<div class="controls">
						<input name="city" id="citys" type="text" required />  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >State</label>
					<div class="controls">
						<input name="state" id="states" type="text" onkeypress="return IsNumeric2(event,'error11');" ondrop="return false;" onpaste="return false;" required/>	
						<span id="error11" style="color: Red; display: none">* Input character (a-z,A-Z)</span>   
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Country</label>
					<div class="controls">
						<input name="country" id="country" value="United States" type="text" required />  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Fax</label>
					<div class="controls">
						<input name="fax" id="fax" type="text" />  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Email</label>
					<div class="controls">
						<input name="email" id="email" type="text" required />  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Phone</label>
					<div class="controls">
						<input name="phone" id="phone" type="text"  pattern=".{14}" required title="10 characters minimum"/>  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Cell Phone</label>
					<div class="controls">
						<input name="cellphone" id="cellphone" type="text"  pattern=".{14}" title="10 characters minimum" />  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >DUNS</label>
					<div class="controls">
						<input name="DUNS" id="DUNS" type="text" />  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Federal ID number</label>
					<div class="controls">
						<input name="federalidnumber" id="federalidnumber" type="text" required />  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Hours of operation</label>
					<div class="controls">
						<input name="hoursofoperation1" id="hoursofoperation1" type="time" style="width:29%" />  
						<input name="hoursofoperation2" id="hoursofoperation2" type="time" style="width:29%" />  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Days of operation</label>
					<div class="controls">
						<!-- <input name="daysofoperation" id="daysofoperation" type="text" />   -->
						<div id="daysofoperation"></div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Website</label>
					<div class="controls">
						<input name="website" id="website" type="text" />  
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Minimum Order Value</label>
					<div class="controls">
						<input name="mov" id="mov" type="number" required />  
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Order Tolerance Value (%)</label>
					<div class="controls">
						<input name="otv" id="otv" type="text" value='0' onkeypress="return IsNumeric1(event,'error1');" ondrop="return false;" onpaste="return false;" required/>	
						<span id="error1" style="color: Red; display: none">* Input digits (0 - 9)</span> 
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Picture</label>
					<div class="controls">
						<input name="businesspic" type="file" onchange="readURL(this);"/> 
						<img id="blah" src="#" alt="your image" style='display:none;'/>						
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Document</label>
					<div class="controls">
						<input name="listofdocuments" type="file" /> 
						<a href='#' id='download_doc' style='display:none;' target='_blank' onclick='redirect()'>Download File</a>						
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Supplier Type</label>
					<div class="controls">
						<select name="suppliertype" id="suppliertype" >
							<option>LITE</option>
							<option>PROFESSIONAL</option>			
						</select>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Approved</label>
					<div class="controls">
						<select name="approved" id="approved" >
							<option value="1">Yes</option>
							<option value="0">No</option>			
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Status</label>
					<div class="controls">
						<select name="status" id="status" >
							<option value="1">Active</option>
							<option value="0">Inactive</option>			
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
var checkss1 = 0;

	$(document).ready(function(){
			$( "#supplier_ul" ).show();
			$( "#i3" ).html('-');
			ul1 = true;
			var add_chk = getParameterByName('add');//alert(add_chk);
			if(add_chk == 1){
				// add_new_function();//alert("ASD");
				// $(".modal-backdrop").addClass("fade");
				// $(".modal-backdrop").addClass("in");
				$("#myModal").addClass("in");
				$("#myModal").css("display","block");	
				$( "body" ).append('<div class="modal-backdrop fade in"></div>');
			}
	
			var s='<option value="">All</option><option value="PROFESSIONAL">Professional</option><option value="LITE">Lite</option>';
						
			$("div.myTools").html('<label>Supplier Type</label><select id="stype">'+s+'</select>');
			var table=$('.datatable').dataTable();
			$('select#stype').change( function() { 
				if($(this).val()==''){
					table.fnFilter( $(this).val(), 8, true ); 
				}else{
					table.fnFilter( "^"+ $(this).val() +"$", 8, true ); 
				}
			});
			
			$.ajax({
				type: "POST",
				url: "get_state.php",
				data: {action:'sup',action1:'state'}
			})
			.done(function( msg ){
				
				res = JSON.parse(msg);
				
				// console.log(res[0].productcategoryid);
				var s='<option value="">All</option>';
				for(i=0;i<res.length;i++){
					s=s+"<option value='"+res[i].state+"'>"+res[i].state+"</option>";
				}
				$("div.myTools1").html('<label>State</label><select id="state">'+s+'</select>');
				var table=$('.datatable').dataTable();
				$('select#state').change( function() { 
					if($(this).val()==''){
						table.fnFilter( $(this).val(), 4, true ); 
					}else{
						table.fnFilter( "^"+ $(this).val() +"$", 4, true ); 
					}
				});
			});
			
			$.ajax({
				type: "POST",
				url: "get_state.php",
				data: {action:'sup',action1:'city'}
			})
			.done(function( msg ){
				
				res = JSON.parse(msg);
				
				var s1='<option value="">All</option>';
				for(i=0;i<res.length;i++){
				
					s1=s1+"<option value='"+res[i].city+"'>"+res[i].city+"</option>";
				}
				$("div.myTools2").html('<label>City</label><select id="city">'+s1+'</select>');
				var table=$('.datatable').dataTable();
				$('select#city').change( function() { 
					if($(this).val()==''){
						table.fnFilter( $(this).val(), 3, true ); 
					}else{
						table.fnFilter( "^"+ $(this).val() +"$", 3, true ); 
					}
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
function approve_customer(id){
			var retVal = confirm("Do you want to approve the supplier ?");
			if( retVal == true ){
				$.ajax({
					type: "GET",				
					url: "approve_customer.php",
					data:{d:id, t:'supplier',c:'supplierid'}
				}).done(function( msg )
				{	
					//alert(msg);
						$("#ab"+id).html("Yes");
				});
			  return true;
			}else{
			  return false;
			}
			
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
					}
				}	
				function product_edit(id){
					// alert(id);
					$("#add_edit").val(1);
					
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
						$("#su").hide();
						$("#status").val(obj['active']);
						$("#field_id").val(obj['supplierid']);	
						$("#eml").val("abc@g.com");
						$("#partner_user_id").val("abc@g.com");
						$("#password").val("abc");
						$("#firstname").val("first");
						$("#lastname").val("last");
						
						$("#businessname").val(obj['businessname']);
						$("#businessownername").val(obj['businessownername']);
						$("#address1").val(obj['address1']);
						$("#address2").val(obj['address2']);
						$("#citys").val(obj['city']);
						
						$("#state").val(obj['state']);
						$("#country").val(obj['country']);					
						$("#zip").val(obj['zip']);
						zipcode(obj['zip'])
						$("#phone").val(obj['phone']);
						$("#fax").val(obj['fax']);
						$("#email").val(obj['email']);
						$("#blah").show();
						if(obj['businesspic']=='a')
						{
							$('#blah').attr('src',"upload/default-user.png").width(70);
						}
						else
						{
							$('#blah').attr('src',"upload/"+obj['businesspic']).width(70);
						}	
						//alert(obj['listofdocuments']);
						var doc=obj['listofdocuments'];
						if(doc!='a')
						{
							$("#download_doc").show();
							var url_doc_download=obj['listofdocuments'];
							$("#download_doc").attr("href", "upload/"+url_doc_download);
						}
						$("#cellphone").val(obj['cellphone']);
						$("#defaultnotification").val(obj['defaultnotification']);
						$("#DUNS").val(obj['DUNS']);
						$("#federalidnumber").val(obj['federalidnumber']);	
						$("#hoursofoperation1").val(obj['hoursofoperation1']);
						$("#hoursofoperation2").val(obj['hoursofoperation2']);
						var dop = obj['daysofoperation'];
						
						
						var s = '';
						s=s+"<input value='All' type='checkbox' id='all_chk' onclick='check_all_days()'>All";
						var true_count=0;
						var days = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];
						for (var i = 0; i < 7; i++) 
						{
							if(dop.charAt(i) == 't')
							{
								s=s+"<input name='dopr[]' value='"+days[i]+"' type='checkbox' class='days_of_operation' class='chk_box_all' checked>"+days[i];
								true_count++;
							}
							else if(dop.charAt(i) == 'f')
							{
								s=s+"<input name='dopr[]' value='"+days[i]+"' class='chk_box_all' type='checkbox'>"+days[i];
							}
							else
							{
								s=s+"<input name='dopr[]' value='"+days[i]+"' class='chk_box_all' type='checkbox'>"+days[i];
							}
						}
						
						/* var s = '';
						var days = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];
						for (var i = 0; i < 7; i++) {
							// console.log(dop.charAt(i));
							if(dop.charAt(i) == 't'){
								s=s+"<input name='dopr[]' value='"+days[i]+"' type='checkbox' checked>"+days[i];
							}else if(dop.charAt(i) == 'f'){
								s=s+"<input name='dopr[]' value='"+days[i]+"' type='checkbox'>"+days[i];
							}
							else{
								s=s+"<input name='dopr[]' value='"+days[i]+"' type='checkbox'>"+days[i];
							}
						} */
						$("#daysofoperation").html(s);
						$("#website").val(obj['website']);	
						$("#suppliertype").val(obj['suppliertype']);
						$("#approved").val(obj['approved']);
						$("#mov").val(obj['mov']);
						$("#otv").val(obj['otv']);
					});
				}
				
				function hide()
				{					
					$("#myModal").hide();
					$(".fade").removeClass('in');
					$( ".modal-backdrop" ).remove();					
				}
					
				function add_new_function()
					{						
						$("#add_edit").val(0);
						$("#su").show();
						$("#download_doc").hide();
						$(".select1 .chzn-single span").html('select');
						$(".select2 .chzn-single span").html('select');
						$(".select3 .chzn-single span").html('select');
						$(".select4 .chzn-single span").html('select');
						$(".select5 .chzn-single span").html('select');
						$(".select6 .chzn-single span").html('select');
						$(".chzn-drop").css('display','block');
						var s = '';
						s=s+"<input value='All' type='checkbox' id='all_chk' onclick='check_all_days()'>All";
						var days = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];
						for (var i = 0; i < 7; i++) 
						{
							if(i==6 || i==0)
							{
								s=s+"<input name='dopr[]' value='"+days[i]+"' type='checkbox' class='chk_box_all'>"+days[i];								
							}
							else
							{
								s=s+"<input name='dopr[]' value='"+days[i]+"' type='checkbox' class='chk_box_all' checked>"+days[i];		
							}
						}
						$("#daysofoperation").html(s);
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
						console.log(checklist);
						console.log(checklistjson);
					}

					function deletentries(){
					var r = confirm("Are you sure you want to delete these entries ?");
					if (r == true) 
					{
						var str = JSON.stringify(checklistjson);
						//alert(str);
						$.ajax({
							type: "POST",
							url: "deactivate_check.php",
							data: {local:str, table:"supplier", column:"supplierid"}
						})
						.done(function( msg ){
						//	alert(msg);
							location.redirect();
						});
						
						
					}	}
					
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
					
					function zipcode(id){
						var zip = $("#"+id).val();
						$.ajax({
							type: "GET",
							url: "getinfo.php",
							data:{zip:zip}
						}).done(function( msg )
						{	
							if((msg!=0)||(msg!=2))
							{
								var obj = JSON.parse(msg);
								
								var states = obj[2];
								var city = obj[1];
								
								$("#citys").val(city);
								$("#states").val(states);
							}
						});
					}
					$("#download_csv").on("click", function(e){
						download_csv_selected('supplier',checklist,'supplier','submit','supplierid');
						// if(checklist.length == 0){
							// alert("Please select a record.");
						// }else{
							// location.href="dba_export_csv.php?type=supplier&list="+checklist+"&page_name=supplier&action=submit&type_nam=supplierid";
						// }
					});
					$("#download_csv_all").on("click", function(e){
						//var chklst = json.stringify(checklistjson);
			location.href="dba_export_csv.php?type=supplier&list=&page_name=supplier&action=submit&type_nam=supplierid";			
		});
		$("#upload_csv_btn").on("click", function(e){
			$("#upload_hover").empty();
			$("#upload_hover").css("display","block");
			$("#upload_hover").load("supplier_csv_upload.php");
		});
		$("#upload_csv_btn").on("click", function(e){
		$("#overlay").css("display","block");
		});
		function readURL(input) {
						$('#blah').show();
						if (input.files && input.files[0]) {
							var reader = new FileReader();

							reader.onload = function (e) {
								$('#blah')
									.attr('src', e.target.result)
									.width(70)
							};

							reader.readAsDataURL(input.files[0]);
						}
					}
		function redirect()
		{
			var href = $("#download_doc").attr('href');
			// alert(url);
			window.location.assign("http://antloc.com/dba/admin/"+href)
		}
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
					function IsNumeric1(e,id) 
						{
							var keyCode = e.which ? e.which : e.keyCode
							var ret = ((keyCode >= 46 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
							document.getElementById(id).style.display = ret ? "none" : "inline";
						
							return ret;
						}
					function IsNumeric2(e,id) 
						{
							var keyCode = e.which ? e.which : e.keyCode
							var ret = ((keyCode >= 65 && keyCode <= 122) || specialKeys.indexOf(keyCode) != -1);
							document.getElementById(id).style.display = ret ? "none" : "inline";
						
							return ret;
						}
						function check_all_days()
				{
					if(checkss1==0)
					{
						$(".chk_box_all").attr('checked', 'checked');
						checkss1=1;
					}
					else
					{
						$(".chk_box_all").prop('checked',false);
						checkss1=0;
					}
				}
				
					
		</script>