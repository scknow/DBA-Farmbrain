<?php
include "connection.php";

if(isset($_REQUEST['upload_csv'])){
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
			if(trim($h)!="")
				$header .= trim($h) . ', ';
		}
		$header .= 'Error Description';
		$status = "true";
		$msg = "";
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			
			if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])=="")||(trim($data[8])=="")||(trim($data[9])=="")||(trim($data[10])=="")||(trim($data[11])=="")||(trim($data[12])=="")||(trim($data[13])=="")||(trim($data[14])=="")||(trim($data[15])=="")||(trim($data[16])=="")||(trim($data[17])=="")||(trim($data[18])=="")||(trim($data[19])=="")||(trim($data[20])=="")||(trim($data[21])=="")||(trim($data[22])=="")||(trim($data[23])=="")||(trim($data[24])=="")||(trim($data[25])=="")||(trim($data[26])=="")||(trim($data[27])=="")||(trim($data[28])=="")||(trim($data[29])=="")||(trim($data[30])=="")||(trim($data[31])=="")||(trim($data[32])=="")||(trim($data[33])=="")||(trim($data[34])=="")||(trim($data[35])=="")||(trim($data[36])=="")||(trim($data[37])=="")||(trim($data[38])==""))
			{
				// $msg = "<br> ";
				$out .= trim($data[0]) . ', ';
					$out .= trim($data[1]) . ', ';
					$out .= trim($data[2]) . ', ';
					$out .= trim($data[3]) . ', ';
					$out .= trim($data[4]) . ', ';
					$out .= trim($data[5]) . ', ';
					$out .= trim($data[6]) . ', ';
					$out .= trim($data[7]) . ', ';
					$out .= trim($data[8]) . ', ';
					$out .= trim($data[9]) . ', ';
					$out .= trim($data[10]) . ', ';
					$out .= trim($data[11]) . ', ';
					$out .= trim($data[12]) . ', ';
					$out .= trim($data[13]) . ', ';
					$out .= trim($data[14]) . ', ';
					$out .= trim($data[15]) . ', ';
					$out .= trim($data[16]) . ', ';
					$out .= trim($data[17]) . ', ';
					$out .= trim($data[18]) . ', ';
					$out .= trim($data[19]) . ', ';
					$out .= trim($data[20]) . ', ';
					$out .= trim($data[21]) . ', ';
					$out .= trim($data[22]) . ', ';
					$out .= trim($data[23]) . ', ';
					$out .= trim($data[24]) . ', ';
					$out .= trim($data[25]) . ', ';
					$out .= trim($data[26]) . ', ';
					$out .= trim($data[27]) . ', ';
					$out .= trim($data[28]) . ', ';
					$out .= trim($data[29]) . ', ';
					$out .= trim($data[30]) . ', ';
					$out .= trim($data[31]) . ', ';
					$out .= trim($data[32]) . ', ';
					$out .= trim($data[33]) . ', ';
					$out .= trim($data[34]) . ', ';
					$out .= trim($data[35]) . ', ';
					$out .= trim($data[36]) . ', ';
					$out .= trim($data[37]) . ', ';
					$out .= trim($data[38]) . ', ';
					$out .= trim($data[39]) . ', ';
					$out .= "Some field is missing. Not uploading." . ', ';
					$out .= "\n";
			}		
			else
			{
				$cutomer_id = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
				$name = trim($data[1]);
				$businessownername = trim($data[2]);
				$bill_to_address1 = trim($data[3]);
				$bill_to_address2 = trim($data[4]);
				$billTocity = trim($data[5]);
				$billtostate = trim($data[6]);
				$billtocountry = trim($data[7]);
				$billtozip = trim($data[8]);
				$billtophone= trim($data[9]);
				$billtofax = trim($data[10]);
				$billtoemail = trim($data[11]);
				$billtocellphone = trim($data[12]);
				$shiptoaddress1 = trim($data[13]);
				$shiptoaddress2 = trim($data[14]);
				$shiptocity = trim($data[15]);			
				$shiptostate = trim($data[16]);
				$shiptocountry = trim($data[17]);
				$shiptozip = trim($data[18]);
				$shiptophone = trim($data[19]);
				$shiptofax = trim($data[20]);
				$shiptoemail = trim($data[21]);
				$shiptocellphone = trim($data[22]);
				$defaultnotification = trim($data[23]);
				$DUNS = trim($data[24]);
				$federalidnumber = trim($data[25]);
				$hoursofoperation1 = trim($data[26]);
				$hoursofoperation2 = trim($data[27]);
				$daysofoperation = trim($data[28]);
				$website = trim($data[29]);
				$customergroupid= ltrim(substr(trim($data[30]),-6),'0'); //trim($data[30]);
				$approved = 0; //trim($data[31]);			
				$totalcmsn = trim($data[32]);
				$agentcmsn = trim($data[33]);
				$repcmsn = trim($data[34]);
				$seccmsn = trim($data[35]);
				$othercmsn= trim($data[36]);
				$netcmsn = trim($data[37]);
				$ddays = trim($data[38]);
				$nhrs = trim($data[39]);
				
				$count=mysql_query("select * from customergroup where customergroupid='$customergroupid'");
				
				if(mysql_num_rows($count)!=0)
				{
					$row=mysql_fetch_array($count);
					$customergroupid=$row['customergroupid'];
				}
				else
				{
					$out .= trim($data[0]) . ', ';
					$out .= trim($data[1]) . ', ';
					$out .= trim($data[2]) . ', ';
					$out .= trim($data[3]) . ', ';
					$out .= trim($data[4]) . ', ';
					$out .= trim($data[5]) . ', ';
					$out .= trim($data[6]) . ', ';
					$out .= trim($data[7]) . ', ';
					$out .= trim($data[8]) . ', ';
					$out .= trim($data[9]) . ', ';
					$out .= trim($data[10]) . ', ';
					$out .= trim($data[11]) . ', ';
					$out .= trim($data[12]) . ', ';
					$out .= trim($data[13]) . ', ';
					$out .= trim($data[14]) . ', ';
					$out .= trim($data[15]) . ', ';
					$out .= trim($data[16]) . ', ';
					$out .= trim($data[17]) . ', ';
					$out .= trim($data[18]) . ', ';
					$out .= trim($data[19]) . ', ';
					$out .= trim($data[20]) . ', ';
					$out .= trim($data[21]) . ', ';
					$out .= trim($data[22]) . ', ';
					$out .= trim($data[23]) . ', ';
					$out .= trim($data[24]) . ', ';
					$out .= trim($data[25]) . ', ';
					$out .= trim($data[26]) . ', ';
					$out .= trim($data[27]) . ', ';
					$out .= trim($data[28]) . ', ';
					$out .= trim($data[29]) . ', ';
					$out .= trim($data[30]) . ', ';
					$out .= trim($data[31]) . ', ';
					$out .= trim($data[32]) . ', ';
					$out .= trim($data[33]) . ', ';
					$out .= trim($data[34]) . ', ';
					$out .= trim($data[35]) . ', ';
					$out .= trim($data[36]) . ', ';
					$out .= trim($data[37]) . ', ';
					$out .= trim($data[38]) . ', ';
					$out .= trim($data[39]) . ', ';
					$out .= "No Customer group of this name available" . ', ';
					$out .= "\n";
					// die;
				}
				
				if($cutomer_id != ''){
					$sql = "UPDATE customer SET businessname='$name', businessownername='$businessownername', billtoaddress1='$bill_to_address1', billtoaddress2='$bill_to_address2', billtocity='$billTocity', billtostate='$billtostate', billtocountry='$billtocountry', billtozip='$billtozip', billtophone='$billtophone', billtofax='$billtofax', billtoemail='$billtoemail', billtocellphone='$billtocellphone', shiptoaddress1='$shiptoaddress1', shiptoaddress2='$shiptoaddress2', shiptocity='$shiptocity', shiptostate='$shiptostate', shiptocountry='$shiptocountry', shiptozip='$shiptozip', shiptophone='$shiptophone', shiptofax='$shiptofax', shiptoemail='$shiptoemail', shiptocellphone='$shiptocellphone', defaultnotification='$defaultnotification', DUNS='$DUNS', federalidnumber='$federalidnumber', hoursofoperation1='$hoursofoperation1', hoursofoperation2='$hoursofoperation2', daysofoperation='$daysofoperation', website='$website', customergroupid='$customergroupid', approved='$approved',totalcmsn='$totalcmsn', agentcmsn='$agentcmsn', repcmsn='$repcmsn', seccmsn='$seccmsn', othercmsn='$othercmsn', netcmsn='$netcmsn', ddays='$ddays', nhrs='$nhrs' WHERE customerid='$cutomer_id'";
					//echo $sql;
					$result = mysql_query($sql);
					
					echo mysql_error();
				}else{
					$sql = "INSERT INTO customer(businessname, businessownername, billtoaddress1, billtoaddress2, billTocity, billtostate, billtocountry, billtozip, billtophone, billtofax, billtoemail, billtocellphone, shiptoaddress1, shiptoaddress2, shiptocity, shiptostate, shiptocountry, shiptozip, shiptophone, shiptofax, shiptoemail, shiptocellphone, defaultnotification, DUNS, federalidnumber, hoursofoperation1, hoursofoperation2, daysofoperation, website,customergroupid, approved, totalcmsn, agentcmsn, repcmsn, seccmsn, othercmsn, netcmsn, ddays, nhrs) VALUES ('$name', '$businessownername', '$bill_to_address1', '$bill_to_address2', '$billtocity', '$billtostate', '$billtocountry', '$billtozip', '$billtophone', '$billtofax', '$billtoemail', '$billtocellphone', '$shiptoaddress1', '$shiptoaddress2', '$shiptocity', '$shiptostate', '$shiptocountry', '$shiptozip', '$shiptophone', '$shiptofax', '$shiptoemail', '$shiptocellphone', '$defaultnotification', '$DUNS', '$federalidnumber', '$hoursofoperation1', '$hoursofoperation2', '$daysofoperation', '$website','$customergroupid', '$approved','$totalcmsn', '$agentcmsn', '$repcmsn', '$seccmsn', '$othercmsn', '$netcmsn', '$ddays', '$nhrs')";
					mysql_query($sql);
					mysql_error();
					
					$sql="SELECT MAX( customerid  ) FROM customer";
					$result=mysql_query($sql);
					$temp=mysql_fetch_array($result);
					$max_id = $temp['MAX( customerid  )'];
				
					$sql = "SELECT * FROM supplier";
					$result = mysql_query($sql);
					while($row=mysql_fetch_array($result))
					{
						$supplierid = $row['supplierid'];
						$sql1 = "INSERT INTO suppliercustomer(supplierid, customerid, customerbusinessname, salesuserid, salesfirstname, saleslastname, suppliersidecustomerid, minimumordervalue, ordertolerancevalue, approve) VALUES ('$supplierid', '$max_id', '$name', '', '', '', '', '0', '0', 0)";
						$result1 = mysql_query($sql1);
						echo mysql_error();
					}
				
					mysql_query($sql);	
				}
			}
		}
		if($out!=""){
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
}
else if(isset($_REQUEST['submit'])){
		$username = $_POST['username']; 
		$firstname = $_POST['firstname']; 
		$lastname = $_POST['lastname']; 
		$password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
		$businessname = $_POST['businessname']; 
		$businessownername = $_POST['businessownername'];
		$billtoaddress1 = $_POST['billtoaddress1'];
		$billtoaddress2 = $_POST['billtoaddress2'];
		$billtocity = $_POST['billtocity'];
		$billtostate = $_POST['billtostate'];
		$billtocountry = $_POST['billtocountry'];
		$billtozip = $_POST['billtozip'];
		$billtophone = $_POST['billtophone'];
		$billtofax = $_POST['billtofax'];
		$billtoemail = $_POST['billtoemail'];
		$billtocellphone = $_POST['billtocellphone'];
		$shiptoaddress1 = $_POST['shiptoaddress1']; 
		$shiptoaddress2 = $_POST['shiptoaddress2'];
		$shiptocity = $_POST['shiptocity'];
		$shiptostate = $_POST['shiptostate'];
		$shiptocountry = $_POST['shiptocountry'];
		$shiptozip = $_POST['shiptozip'];
		$shiptophone = $_POST['shiptophone'];
		$shiptofax = $_POST['shiptofax'];
		$shiptoemail = $_POST['shiptoemail'];
		$shiptocellphone = $_POST['shiptocellphone'];
		$defaultnotification = $_POST['defaultnotification'];
		$DUNS = $_POST['DUNS'];
		$federalidnumber = $_POST['federalidnumber'];
		$hoursofoperation1 = $_POST['hoursofoperation1']; 
		$hoursofoperation2 = $_POST['hoursofoperation2']; 
		// $daysofoperation = $_POST['daysofoperation']; 
		$daysofoperation = $_POST['dopr'];
		
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
		// echo $dop;
		// var_dump($daysofoperation);echo "EASDA";die;
		$website = $_POST['website'];
		
		$totalcmsn = $_POST['totalcmsn'];
		$agentcmsn = $_POST['agentcmsn'];
		$repcmsn = $_POST['repcmsn'];
		$seccmsn = $_POST['seccmsn'];
		$othercmsn = $_POST['othercmsn'];
		$netcmsn = $_POST['netcmsn'];
		$ddays = $_POST['ddays'];
		$nhrs = $_POST['nhrs'];
		
		$add_edit=$_POST['add_edit'];
		
		$customergroupid = $_POST['customergroupid'];
		
		if($add_edit==0)
		{		
			$approved = 1;
			$status = 1;
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
			}
			else
			{
				$listofdocuments=upload_file1('listofdocuments');
			}
			
		
			$sql = "INSERT INTO customer(businessname, businessownername, billtoaddress1, billtoaddress2, billtocity, billtostate, billtocountry, billtozip, billtophone, billtofax, billtoemail, billtocellphone, shiptoaddress1, shiptoaddress2, shiptocity, shiptostate, shiptocountry, shiptozip, shiptophone, shiptofax, shiptoemail, shiptocellphone, defaultnotification, DUNS, federalidnumber, hoursofoperation1, hoursofoperation2, daysofoperation, website, businesspic, listofdocuments, customergroupid, approved, totalcmsn, agentcmsn, repcmsn, seccmsn, othercmsn, netcmsn, ddays, nhrs,active) VALUES ('$businessname', '$businessownername', '$billtoaddress1', '$billtoaddress2', '$billtocity', '$billtostate', '$billtocountry', '$billtozip', '$billtophone', '$billtofax', '$billtoemail', '$billtocellphone', '$shiptoaddress1', '$shiptoaddress2', '$shiptocity', '$shiptostate', '$shiptocountry', '$shiptozip', '$shiptophone', '$shiptofax', '$shiptoemail', '$shiptocellphone', '$defaultnotification', '$DUNS', '$federalidnumber', '$hoursofoperation1', '$hoursofoperation2', '$dop', '$website', '$businesspic', '$listofdocuments', '$customergroupid', '$approved','$totalcmsn', '$agentcmsn', '$repcmsn', '$seccmsn', '$othercmsn', '$netcmsn', '$ddays', '$nhrs',1)";
			//echo $sql;
			mysql_query($sql);
			echo mysql_error();
			
			$sql="SELECT MAX( customerid  ) FROM customer";
			$result=mysql_query($sql);
			$temp=mysql_fetch_array($result);
			$max_id = $temp['MAX( customerid  )'];
			
			$sql = "INSERT INTO user(username, password, firstname, lastname, customerid, active) VALUES ('$username', '$password', '$firstname', '$lastname', '$max_id', '1')"; 
			$result = mysql_query($sql);
			
			$to=$username;
			$subject="DBA user password";
			$body="Username:".$username."<br>password:".$password;
			
			$headers = 'From: dba.com' . "\r\n" .
				'Reply-To: info@dba.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
			$headers.="MIME-Version: 1.0" . "\r\n";
			$headers.="Content-type:text/html;charset=iso-8859-1" . "\r\n";
				
			// mail($to,$subject,$body,$headers);
			curl_post($to,$subject,$body);
			$sql = "SELECT * FROM supplier";
			$result = mysql_query($sql);
			while($row=mysql_fetch_array($result)){
				$supplierid = $row['supplierid'];
				$sql1 = "INSERT INTO suppliercustomer(supplierid, customerid, customerbusinessname, salesuserid, salesfirstname, saleslastname, suppliersidecustomerid, minimumordervalue, ordertolerancevalue, approve) VALUES ('$supplierid', '$max_id', '$businessname', '', '', '', '', '0', '0', 0)"; 
				//echo $sql1;
				$result1 = mysql_query($sql1);
				echo mysql_error();
			}
			
		}
		else
		{
			$approved = $_POST['approved'];
			$id=$_POST['field_id'];
			$status = $_POST['status'];
			if(!file_exists($_FILES['businesspic']['tmp_name']) || !is_uploaded_file($_FILES['businesspic']['tmp_name']))
			{}
			else
			{			
				$businesspic=upload_file('businesspic');
				$sql = "UPDATE customer SET businessname='$businessname', businessownername='$businessownername', billtoaddress1='$billtoaddress1', billtoaddress2='$billtoaddress2', billtocity='$billtocity', billtostate='$billtostate', billtocountry='$billtocountry', billtozip='$billtozip', billtophone='$billtophone', billtofax='$billtofax', billtoemail='$billtoemail',businesspic='$businesspic', billtocellphone='$billtocellphone', shiptoaddress1='$shiptoaddress1', shiptoaddress2='$shiptoaddress2', shiptocity='$shiptocity', shiptostate='$shiptostate', shiptocountry='$shiptocountry', shiptozip='$shiptozip', shiptophone='$shiptophone', shiptofax='$shiptofax', shiptoemail='$shiptoemail', shiptocellphone='$shiptocellphone', defaultnotification='$defaultnotification', DUNS='$DUNS', federalidnumber='$federalidnumber', hoursofoperation1='$hoursofoperation1', hoursofoperation2='$hoursofoperation2', daysofoperation='$dop', website='$website', customergroupid='$customergroupid', approved='$approved',totalcmsn='$totalcmsn', agentcmsn='$agentcmsn', repcmsn='$repcmsn', seccmsn='$seccmsn', othercmsn='$othercmsn', netcmsn='$netcmsn', ddays='$ddays', nhrs='$nhrs',active='$status' WHERE customerid='$id'";
			}
			if(!file_exists($_FILES['listofdocuments']['tmp_name']) || !is_uploaded_file($_FILES['listofdocuments']['tmp_name']))
			{
				
			}
			else
			{				
				$listofdocuments=upload_file1('listofdocuments');
			
				$sql = "UPDATE customer SET businessname='$businessname', businessownername='$businessownername', billtoaddress1='$billtoaddress1', billtoaddress2='$billtoaddress2', billtocity='$billtocity', billtostate='$billtostate', billtocountry='$billtocountry', billtozip='$billtozip', billtophone='$billtophone', billtofax='$billtofax', billtoemail='$billtoemail',listofdocuments='$listofdocuments', billtocellphone='$billtocellphone', shiptoaddress1='$shiptoaddress1', shiptoaddress2='$shiptoaddress2', shiptocity='$shiptocity', shiptostate='$shiptostate', shiptocountry='$shiptocountry', shiptozip='$shiptozip', shiptophone='$shiptophone', shiptofax='$shiptofax', shiptoemail='$shiptoemail', shiptocellphone='$shiptocellphone', defaultnotification='$defaultnotification', DUNS='$DUNS', federalidnumber='$federalidnumber', hoursofoperation1='$hoursofoperation1', hoursofoperation2='$hoursofoperation2', daysofoperation='$dop', website='$website', customergroupid='$customergroupid', approved='$approved',totalcmsn='$totalcmsn', agentcmsn='$agentcmsn', repcmsn='$repcmsn', seccmsn='$seccmsn', othercmsn='$othercmsn', netcmsn='$netcmsn', ddays='$ddays', nhrs='$nhrs',active='$status' WHERE customerid='$id'";
			}
			
			if($sql=='')
			{
				$sql = "UPDATE customer SET businessname='$businessname', businessownername='$businessownername', billtoaddress1='$billtoaddress1', billtoaddress2='$billtoaddress2', billtocity='$billtocity', billtostate='$billtostate', billtocountry='$billtocountry', billtozip='$billtozip', billtophone='$billtophone', billtofax='$billtofax', billtoemail='$billtoemail',billtocellphone='$billtocellphone', shiptoaddress1='$shiptoaddress1', shiptoaddress2='$shiptoaddress2', shiptocity='$shiptocity', shiptostate='$shiptostate', shiptocountry='$shiptocountry', shiptozip='$shiptozip', shiptophone='$shiptophone', shiptofax='$shiptofax', shiptoemail='$shiptoemail', shiptocellphone='$shiptocellphone', defaultnotification='$defaultnotification', DUNS='$DUNS', federalidnumber='$federalidnumber', hoursofoperation1='$hoursofoperation1', hoursofoperation2='$hoursofoperation2', daysofoperation='$dop', website='$website', customergroupid='$customergroupid', approved='$approved',totalcmsn='$totalcmsn', agentcmsn='$agentcmsn', repcmsn='$repcmsn', seccmsn='$seccmsn', othercmsn='$othercmsn', netcmsn='$netcmsn', ddays='$ddays', nhrs='$nhrs',active='$status' WHERE customerid='$id'";
			}
			$result = mysql_query($sql);
			
			echo mysql_error();
		}
		header('Location: ' . basename($_SERVER['PHP_SELF']));
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
		if ((($_FILES[$arg]["type"] == "image/docx")
		|| ($_FILES[$arg]["type"] == "image/pdf")|| ($_FILES[$arg]["type"] == "image/doc"))
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
	function curl_post($email_to,$subject,$message)
	{
		$subject="Welcome to Dutch Bakers Associated";
		$data_string = "msg=".$message."&email_to=".$email_to."&subject=".$subject;
		$ch = curl_init('http://104.131.176.201/PHPMailer-master/examples/dba_gmail.php');                                                               
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
		$result = curl_exec($ch);
	}
	include "header.php";
	
?>
			
			<!-- left menu starts -->
			<!-- left menu starts -->
<?
include "menu.php";
?>
			<div id='upload_hover'></div>
			<!-- left menu ends -->
			<div id="content" class="span10">
			<!-- bread crum -->
			<div class='bread'>
				<ul class="breadcrumb">
					<li class="step">
						<a href="index.php">Home</a>
					</li>
					<li class="step">
						<a href="#" class="active1">Customer</a>
					</li>
				</ul>
			</div>
			<!-- end bread crum -->
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Customer</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 125px;'><i class="icon-cog"></i> Add Customer</a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th Style="width:5%"><input type='checkbox' onclick='check_all()'></th>
								  <th>Id</th>
								  <th>Business Name</th>
								  <th>City</th>
								  <th>State</th>
								  <th>Phone</th>
								  <th>Group Name</th>
								  <th>Approve</th>  
								  <th>status</th>
								  <th style="display:none">gid</th>
							  </tr>
						  </thead>   
						<tbody>
						  <?php
							include "connection.php";
							$sql="SELECT * FROM customergroup";
							//echo $sql;
							$result = mysql_query($sql);
							$cg_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$cg_arr[$row['customergroupid']] = $row['customergroupname'];
							}
							$sql="SELECT * FROM customer ORDER BY customerid DESC";
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['customerid']."$$"."customerid"."$$".'customer';
								$line_id=$row['customerid'];
								echo "<tr id='$line_id'>";
								
								
								echo "<td class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['customerid']."') name='check[]' value='".$row['customerid']."'></td>";
								
								$max_id=str_pad($row['customerid'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$id')>DBAC{$max_id}</a></td>";
								echo "<td>{$row['businessname']}</td>";
								echo "<td>".$row['shiptocity']."</td>";
								echo "<td>{$row['shiptostate']}</td>";
								echo "<td>{$row['shiptocellphone']}</td>";
								echo "<td>{$cg_arr[$row['customergroupid']]}</td>";
								if($row['approved']){
									echo "<td>Yes</td>";
								}else{
									echo "<td id='ab".$row['customerid']."' ><a href='#' class='btn btn-info' onclick=approve_customer('".$row['customerid']."') style='height: 19px;width: 80px;'><i class='icon-cog'></i>Approve</a></td>";
								}
								if($row['active']==0)
								{
									echo "<td>Inactive</td>"; 
								}
								else
								{
									echo "<td>Active</td>";
								}
								echo "<td style='display:none;'>{$row['customergroupid']}</td>";
								echo "</tr>";
								
							}
							?>
						</tbody>
					  </table>  
					  <div>
						<button onclick="deletentries()" style="margin-right:10px"><a href="#">DEACTIVE </a></button>
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
				<h3>Customer Registration Form</h3>
			</div>
			<div class="modal-body">
				<div class="box-content">
				<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
					
						<fieldset>
						<div id="su">
							<div class="control-group">
							<label class="control-label" for="inputError">Email</label>
							<div class="controls">
								<input id="eml" type="email" name="eml" onblur="usr_pop()" required />  
							</div>
							</div>
							<div class="control-group">
							<label class="control-label" for="inputError">Username</label>
							<div class="controls">
								<input id="partner_user_id" type="email" name="username" required readonly /><p id="alreaytag" style="color:red; display:none">User id already exist</p>  
							</div>
							</div>	
							<div class="control-group">
							<label class="control-label" for="inputError">First Name</label>
							<div class="controls">
								<input name="firstname" type="text" id="firstname" required />  
							</div>
							</div>	
							
							
							<div class="control-group">
							<label class="control-label" for="inputError">Last Name</label>
							<div class="controls">
								<input name="lastname" id="lastname" type="text" required />  
							</div>
							</div>

							</div>
							<div class="control-group">
								<label class="control-label" for="product_attribute">Customer Group</label>
								<div class="controls">
									<select id="customergroupid" name="customergroupid" required >
									<?
									include "connection.php";
									$sql = "SELECT * FROM customergroup";
									echo "<option value=''>Select</option>";
									$result = mysql_query($sql);
									while($row=mysql_fetch_array($result)){
										echo "<option value='".$row['customergroupid']."'>".$row['customergroupname']."</option>";
									}
									?>
								  </select>
								</div>
							</div>

							<div class="control-group">
							<label class="control-label" for="inputError">Business Name</label>
							<div class="controls" >
								<input name="businessname" id="businessname" type="text" id="Business Name" required />  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Business Owner Name</label>
							<div class="controls">
								<input name="businessownername" id="businessownername" type="text" />  
							</div>
							</div>
							
							<div class="control-group" style="color:black; padding: 10px;background: url(../admin/images/grey.png);border-right: 1px solid rgb(204, 204, 204);border-left: 1px solid rgb(204, 204, 204);background-size: 100% 100%;">
							
							 <a href="#" style="color:black; display:block;" onclick="tog()">Billing Address<span id="badd"> <img src="images/right-arrrow.png"></span></a>
							</div>
							<div id="shipto" style="display:none">
								<div class="control-group">
								<label class="control-label" for="inputError">Address Line1</label>
								<div class="controls">
									<input name="billtoaddress1" type="text" id="bill_ad1" required/>  
								</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" for="inputError">Address Line2</label>
								<div class="controls">
									<input name="billtoaddress2" type="text" id="bill_ad2" />  
								</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" for="inputError">Zip code</label>
								<div class="controls">
								<input id="bill_zip" type="text" name="billtozip" onkeypress="return IsNumeric(event,'error3');" ondrop="return false;" onpaste="return false;" onchange="zipcode('bill_zip')" pattern=".{5}"  title="5 digits required minimum" required/>
								<span id="error3" style="color: Red; display: none">* Input digits (0 - 9)</span>
							 
								</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" for="inputError">City</label>
								<div class="controls">
									<input name="billtocity" type="text" id="bill_city" required />  
								</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" for="inputError">State</label>
								<div class="controls">
									<input name="billtostate" type="text" id="bill_state" required />  
								</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" for="inputError">Country</label>
								<div class="controls">
									<input name="billtocountry" type="text" id="bill_country" value="United States" required />  
								</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" for="inputError">Fax</label>
								<div class="controls">
									<input name="billtofax" type="text" id="bill_fax" />  
								</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" for="inputError">Email</label>
								<div class="controls">
									<input name="billtoemail" type="Email" id="bill_email"  />  
								</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" for="inputError">Phone</label>
								<div class="controls">
									
									<input name="billtophone" type="text" id="bill_phone" />  
								</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" for="inputError">Cell Phone</label>
								<div class="controls">
									<input name="billtocellphone" type="text" id="bill_cellphone" required/>  
								</div>
								</div>
							</div>
							<div class="control-group">
							
							<div class="controls">
								 
							</div>
							</div>
							<div class="control-group" style="padding: 10px;background:url(../admin/images/grey.png);background-size: 100% 100%;border-right: 1px solid rgb(204, 204, 204);border-left: 1px solid rgb(204, 204, 204);">
							 <a href="#" style="color:black; display:block;" onclick="tog1()"><span id="sadd"><img src='images/right-arrrow.png' style='float:right'> </span>Shipping Address</a>
							 
							 <label class="control-label" for="inputError" style='position: absolute; right: 35px;top: 3px;'><input type="checkbox" onclick="fill_address()" style='top: 0;padding-top: 0;'/>Copy bill address</label>
							 
							</div>
							<div id="billto" style="display:none">
							<div class="control-group">
							<label class="control-label" for="inputError">Address Line1</label>
							<div class="controls">
								<input name="shiptoaddress1" type="text" id="ship_ad1" required />  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Address Line2</label>
							<div class="controls">
								<input name="shiptoaddress2" type="text" id="ship_ad2"  />  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Zip code</label>
							<div class="controls">
								<input id="ship_zip" type="text" name="shiptozip" onkeypress="return IsNumeric(event,'error4');" ondrop="return false;" onpaste="return false;" onchange="zipcode('ship_zip')" pattern=".{5}"  title="5 digits required minimum" required/>	
							<span id="error4" style="color: Red; display: none">* Input digits (0 - 9)</span>
							 
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">City</label>
							<div class="controls">
								<input name="shiptocity" type="text" id="ship_city" required />  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">State</label>
							<div class="controls">
								<input name="shiptostate" type="text" id="ship_state" required/>  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Country</label>
							<div class="controls">
								<input type="text" name="shiptocountry" id="ship_country" value="United States" required />  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Fax</label>
							<div class="controls">
								<input name="shiptofax" type="text" id="ship_fax"  />  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Email</label>
							<div class="controls">
								<input name="shiptoemail" type="email" id="ship_email"/>  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Phone</label>
							<div class="controls">
								<input name="shiptophone" type="text" id="ship_phone" pattern=".{14}"  title="10 digits minimum"/>  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Cell Phone</label>
							<div class="controls">
								<input name="shiptocellphone" type="text" id="ship_cellphone"  pattern=".{14}" required title="10 digits minimum"/>  
							</div>
							</div>
							</div>
							<div class="control-group" style='margin-top: 23px;border-top: 2px solid silver;padding: 10px;'>
								<label class="control-label" >Default Notification Type</label>
								<div class="controls">
									<select id="defaultnotification" name="defaultnotification"  required >
										<option value="">select</option>
										<option>App </option>
										<option>Email</option>
										<option>Phone</option>
									</select>
								</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">DUNS</label>
							<div class="controls">
								<input id="DUNS" name="DUNS" type="text" />  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Federal Id Number</label>
							<div class="controls">
								<input id="federalidnumber" name="federalidnumber" type="text"  required />  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Receiving hours</label>
							<div class="controls">
								<input id="hoursofoperation1" name="hoursofoperation1" type="time" i style="width:29%" />		
								<input id="hoursofoperation2" name="hoursofoperation2" type="time" style="width:29%" />	
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Receiving days </label>
							<div class="controls">
								<!--<input id="daysofoperation" name="daysofoperation" type="text" />-->
								<div id="daysofoperation"></div>
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Delivery Instructions</label>
							<div class="controls">
								<input name="ddays" type="text" id="ddays"/>  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Website</label>
							<div class="controls">
								<input id="website" name="website" type="text" /> 
								 								
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Picture</label>
							<div class="controls">
								<input name="businesspic" type="file" id="businesspic" onchange="readURL(this);" /> 
								<img id="blah" src="#" alt="your image" style='display:none;'/>								
							</div>
							</div>
							<div class="control-group">
							<label class="control-label" for="inputError">Document</label>
							<div class="controls" id='docs_for_download'>
								<input id="listofdocuments" name="listofdocuments" type="file" /> 
								
								<a href='#' id='download_doc' style='display:none;' target='_blank' onclick="redirect()">Download File</a>	
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Total DBA Commission(in %)</label>
							<div class="controls">
								<input id="totalcmsn" type="text" name="totalcmsn" onkeypress="return IsNumeric(event,'error5');" ondrop="return false;" onpaste="return false;" onkeyup="net_cmsn()" required/>	
								<span id="error5" style="color: Red; display: none">* Input digits (0 - 9)</span>
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Supplier Rep Commission(in %)</label>
							<div class="controls">
								<input id="repcmsn" type="text" name="repcmsn" onkeypress="return IsNumeric(event,'error6');" ondrop="return false;" onpaste="return false;" onkeyup="net_cmsn()" required/>	
								<span id="error6" style="color: Red; display: none">* Input digits (0 - 9)</span>								
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Primary DBA Agent Commission(in %)</label>
							<div class="controls" >
								<input id="agentcmsn" type="text" name="agentcmsn" onkeypress="return IsNumeric(event,'error7');" ondrop="return false;" onpaste="return false;" onkeyup="net_cmsn()" required/>	
								<span id="error7" style="color: Red; display: none">* Input digits (0 - 9)</span>
							 
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Secondary DBA Agent Commission(in %)</label>
							<div class="controls">
								<input id="seccmsn" type="text" name="seccmsn" onkeypress="return IsNumeric(event,'error8');" ondrop="return false;" onpaste="return false;" onkeyup="net_cmsn()" required/>	
								<span id="error8" style="color: Red; display: none">* Input digits (0 - 9)</span>
								
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Other Commission(in %)</label>
							<div class="controls">
								<input id="othercmsn" type="text" name="othercmsn" onkeypress="return IsNumeric(event,'error8');" ondrop="return false;" onpaste="return false;" onkeyup="net_cmsn()" required/>	
								<span id="error8" style="color: Red; display: none">* Input digits (0 - 9)</span>
							 	</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Net DBA Service Commission(in %)</label>
							<div class="controls">
								<input name="netcmsn" type="number" id="netcmsn" value="0" required readonly="readonly" />  
							</div>
							</div>
							
						
							
							<div class="control-group">
							<label class="control-label" for="inputError">Advanced Shipping Notification hours</label>
							<div class="controls">
								
								<select id='nhrs' name='nhrs'>
								<option>12</option>
								<option>24</option>
								<option>36</option>
								<option>48</option>
								</select>
								
							</div>
							</div>
							<?php 
							if($_SESSION["superadmin"]==1)
							{
								?>
								<div class="control-group" style='display:none;' id='approve_customer_status'>
									<label class="control-label" for="inputError">Approve</label>
									<div class="controls">
										<select id="approved" name="approved">
											<option value="1" selected>Yes</option>
											<option value="0">No</option>
										</select>  
									</div>
								</div>
							<?}else{?>
							<div class="control-group">
									<label class="control-label" for="inputError">Approve</label>
									<div class="controls">
										<select id="approved" name="approved">
											<option value="1" selected>Yes</option>
											<option value="0">No</option>
										</select>  
									</div>
								</div>
							<?}?>
						<?php 
						if($_SESSION["superadmin"]==1)
						{
						?>	
							<div class="control-group" style='display:none;' id='status_customer'>
							<label class="control-label" >Status</label>
							<div class="controls">
								<select name="status" id="status" required >
								   <option value='1' selected>Active</option>
								   <option value='0'>Inactive</option>
								</select> 
							</div>
							</div>
						<?}else{?>
							<div class="control-group" >
							<label class="control-label" >Status</label>
							<div class="controls">
								<select name="status" id="status" required >
								   <option value='1' selected>Active</option>
								   <option value='0'>Inactive</option>
								</select> 
							</div>
							</div>
						<?}?>
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
var checkss1=0;
			function add_new_function()
				{					//alert();	
					$("#add_edit").val(0);
					$("#su").show();
					$("#blah").hide();
					$("#download_doc").hide();
					$("#approve_customer_status").hide();
					$("#status_customer").hide();
		
		
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
$(document).ready(function(){
	$( "#customer_ul" ).show();
	$( "#i3" ).html('-');
	ul3 = true;	
	$.ajax({
		type: "POST",
		url: "get_customer_group_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
			s=s+"<option value='"+res[i].customergroupname+"'>"+res[i].customergroupname+"</option>";
		}
		$("div.myTools").html('<label>Group Name</label><select id="group">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#group').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 6, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 6, true ); 
			}
		});

	});
	
	
	$.ajax({
		type: "POST",
		url: "get_state.php",
		data: {action:'custome',action1:'state'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
		
			s=s+"<option value='"+res[i].shiptostate+"'>"+res[i].shiptostate+"</option>";
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
		data: {action:'custome',action1:'city'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		
		var s1='<option value="">All</option>';
		for(i=0;i<res.length;i++){
		
			s1=s1+"<option value='"+res[i].shiptocity+"'>"+res[i].shiptocity+"</option>";
		}
		$("div.myTools3").html('<label>City</label><select id="city">'+s1+'</select>');
		var table=$('.datatable').dataTable();
		$('select#city').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 3, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 3, true ); 
			}
		});
		
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
		function approve_customer(id){
			var retVal = confirm("Do you want to approve the customer ?");
			if( retVal == true ){
				$.ajax({
					type: "GET",				
					url: "approve_customer.php",
					data:{d:id, t:'customer',c:'customerid'}
				}).done(function( msg )
				{	
					// alert(msg);
						$("#ab"+id).html("Yes");
				});
			  return true;
			}else{
			  return false;
			}
		
			// alert("If you want to approve, please update the 'Customer Group' and 'Approve status'");
			// product_edit(id);
		}
		
		function net_cmsn(){
			var t = parseInt($("#totalcmsn").val());
			var a = parseInt($("#agentcmsn").val());
			var r = parseInt($("#repcmsn").val());
			var s = parseInt($("#seccmsn").val());
			var o = parseInt($("#othercmsn").val());
			var n = parseInt($("#netcmsn").val());
			//alert(t+"--"+a+"---"+r+"---"+s+"---"+o)
			var k = a+r+s+o;
			var p = t-k;
			//alert(p);
			if(p<=0){
				alert("Net commission cannot be less zero");
			}
			else{
				$("#netcmsn").val(p);
			}
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
	function product_edit(id)
	{
		$("#add_edit").val(1);
		$("#myModal").show();
		$("#approve_customer_status").show();
		$("#status_customer").show();
		
		$("#myModal").addClass('in');
		$("#blah").hide();
		var $div = $('<div />').appendTo('body');
		$div.attr('class','modal-backdrop fade in');
		$.ajax({
			type: "GET",
			url: "edit.php",
			data: {d:id}
		}).done(function( msg )
		{
						//alert(msg);
						obj = JSON.parse(msg);
						$("#su").hide();
						$("#field_id").val(obj['customerid']);
						
						$("#partner_user_id").val("abc@g.com");
						$("#eml").val("abc@g.com");
						$("#firstname").val("first");
						$("#lastname").val("last");
						$("#status").val(obj['active']);
						
						$("#businessname").val(obj['businessname']);
						$("#businessownername").val(obj['businessownername']);
						$("#bill_ad1").val(obj['billtoaddress1']);
						$("#bill_ad2").val(obj['billtoaddress2']);
						$("#bill_city").val(obj['billtocity']);
						
						$("#bill_state").val(obj['billtostate']);
						$("#bill_country").val(obj['billtocountry']);
						$("#bill_zip").val(obj['billtozip']);
						$("#bill_phone").val(obj['billtophone']);
						$("#bill_fax").val(obj['billtofax']);
						$("#bill_email").val(obj['billtoemail']);
						$("#bill_cellphone").val(obj['billtocellphone']);
						$("#DUNS").val(obj['DUNS']);
						$("#ship_ad1").val(obj['shiptoaddress1']);
						$("#ship_ad2").val(obj['shiptoaddress2']);
						$("#ship_city").val(obj['shiptocity']);	
						$("#ship_state").val(obj['shiptostate']);
						$("#ship_country").val(obj['shiptocountry']);
						$("#ship_zip").val(obj['shiptozip']);	
						$("#ship_phone").val(obj['shiptophone']);
						$("#ship_fax").val(obj['shiptofax']);
						$("#ship_email").val(obj['shiptoemail']);
						$("#ship_cellphone").val(obj['shiptocellphone']);
						$("#defaultnotification").val(obj['defaultnotification']);
						$("#DUNS").val(obj['DUNS']);
						$("#federalidnumber").val(obj['federalidnumber']);
						$("#hoursofoperation1").val(obj['hoursofoperation1']);
						$("#hoursofoperation2").val(obj['hoursofoperation2']);
						
						$("#blah").show();
						if(obj['businesspic']=='a' || obj['businesspic']=='')
						{
							$('#blah').attr('src',"upload/default-user.png").width(70);
							
						}
						else
						{
							$('#blah').attr('src',"upload/"+obj['businesspic']).width(70);
						}
						var doc=obj['listofdocuments'];
						if(doc!='a')
						{
							$("#download_doc").show();
							var url_doc_download=obj['listofdocuments'];
							$("#download_doc").attr("href", "upload/"+url_doc_download);
						}
						// $("#daysofoperation").val(obj['daysofoperation']);
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
						
						if(true_count==7)
						{
							checkss1=1;
							$("#all_chk").attr('checked',true);
						}
						$("#daysofoperation").html(s);						
						
						$("#website").val(obj['website']);
						$("#customergroupid").val(obj['customergroupid']);
						$("#approved").val(obj['approved']);
						$("#totalcmsn").val(obj['totalcmsn']);
						$("#agentcmsn").val(obj['agentcmsn']);
						$("#repcmsn").val(obj['repcmsn']);
						$("#seccmsn").val(obj['seccmsn']);
						$("#othercmsn").val(obj['othercmsn']);
						$("#netcmsn").val(obj['netcmsn']);
						$("#ddays").val(obj['ddays']);
						$("#nhrs").val(obj['nhrs']);
					});
				}
	function hide()
	{					
					$("#myModal").hide();
					$(".fade").removeClass('in');
					$( ".modal-backdrop" ).remove();					
				}
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
	var checklist = new Array();
	var checklistjson = new Array();
	function checked_entries(id)
	{
		var index = checklist.indexOf(id);
		if(index==-1){
		var ide = 
		{
			row:id
		}
		checklistjson.push(ide);
		checklist.push(id);
	}
	else{
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
				url: "deactivate_check.php",
				data: {local:str, table:"customer", column:"customerid"}
				})
				.done(function( msg ){
				location.reload();
				});
				
	}
	}
	function search_uniq(){
		var str = $("#partner_user_id").val();
		//alert(str);
		$.ajax({
			type: "GET",
			url: "search_partner.php",
			data: {term:str}
			}).done(function( msg )
			{//alert(msg);
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
					var smad = false;
					function fill_address(){
						var ad1 = $("#bill_ad1").val();
						var ad2 = $("#bill_ad2").val();
						var city = $("#bill_city").val();
						var state = $("#bill_state").val();
						var country = $("#bill_country").val();
						var zip = $("#bill_zip").val();
						var phone = $("#bill_phone").val();
						var fax = $("#bill_fax").val();
						var cell = $("#bill_cellphone").val();
						var email = $("#bill_email").val();
						
						if(!smad){
							$("#ship_ad1").val(ad1);
							$("#ship_ad2").val(ad2);
							$("#ship_city").val(city);
							$("#ship_state").val(state);
							$("#ship_zip").val(zip);
							$("#ship_country").val(country);
							$("#ship_phone").val(phone);
							$("#ship_cellphone").val(cell);
							$("#ship_fax").val(fax);
							$("#ship_email").val(email);
							smad = true;
						}else{
							$("#ship_ad1").val('');
							$("#ship_ad2").val('');
							$("#ship_city").val('');
							$("#ship_state").val('');
							$("#ship_zip").val('');
							$("#ship_country").val('');
							$("#ship_phone").val('');
							$("#ship_cellphone").val('');
							$("#ship_fax").val('');
							$("#ship_email").val('');
							smad = false;
						}
					}
					
					function usr_pop()
					{
						var x = document.getElementById("eml").value;
						var atpos = x.indexOf("@");
						var dotpos = x.lastIndexOf(".");
						if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) 
						{
							$("#eml").focus();
							$("#eml").css('border','1px solid red');
							
							return false;
						}
						else
						{
							$("#eml").css('border','none');
							$("#partner_user_id").val($("#eml").val());
							search_uniq();
						}
					}
					var badd_tog=0;
					var sadd_tog=0;
					function tog(){
						$("#shipto").slideToggle("slow","swing");
						if(badd_tog == 0){
							$("#badd").html("<img src='images/down-arrrow.png'>");
							badd_tog=1;
						}else{
							$("#badd").html("<img src='images/right-arrrow.png'>");
							badd_tog=0;
						}
					}
					function tog1(){
						$("#billto").slideToggle("slow","swing");
						if(sadd_tog == 0){
							$("#sadd").html("<img src='images/down-arrrow.png' style='float:right'>");
							sadd_tog=1;
						}else{
							$("#sadd").html("<img src='images/right-arrrow.png' style='float:right'>");
							sadd_tog=0;
						}
					}
					
					function zipcode(id){
						var zip_code=$("#"+id).val();
							$.ajax({
									type: "GET",
									url: "getinfo.php",
									data: {zip:zip_code}
								})
								.done(function( msg )
								{
									
									if((msg!=0)||(msg!=2))
									{
										var obj = JSON.parse(msg);
										if(id=="bill_zip")
										{
											$("#bill_city").val(obj[1]);
											$("#bill_state").val(obj[2]);
										}else{
												$("#ship_city").val(obj[1]);
												$("#ship_state").val(obj[2]);
											}
											
										}
									});
					}
					$("#download_csv").on("click", function(e){
						download_csv_selected('customer', checklist, 'customer', 'submit', 'customerid');
						// location.href="dba_export_csv.php?type=customer&list="+checklist+"&page_name=customer&action=submit&type_nam=customerid";			
					});
					$("#download_csv_all").on("click", function(e){
						location.href="dba_export_csv.php?type=customer&list=&page_name=customer&action=submit&type_nam=customerid";			
					});
					$("#upload_csv_btn").on("click", function(e){
						$("#upload_hover").empty();
						$("#upload_hover").css("display","block");
						$("#upload_hover").load("customer_reg_form_csv.php");
					});
					$("#upload_csv_btn").on("click", function(e){
						$("#overlay").css("display","block");
					});
					function getParameterByName(name) {
						name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
						var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
							results = regex.exec(location.search);
						return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
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
			<style>
				#uniform-undefined
				{
					top: 0px;
					padding-top: 0px;
				}
			</style>