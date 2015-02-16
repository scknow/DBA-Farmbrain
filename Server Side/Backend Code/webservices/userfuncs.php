<?php
include 'dbcon.php';
$action = $_REQUEST['action'];
if (isset($action))
{
	switch ($action)
	{
	case 'login_check':
		login_check();
		break;

	case 'forgot_password':
		forgot_password();
		break;

	case 'register_customer':
		register_customer();
		break;
	}
}

mysql_close();

function generatePassword($n)
{
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); 
    $alphaLength = strlen($alphabet) - 1; 
    for ($i = 0; $i < $n; $i++) {
        $x = rand(0, $alphaLength);
        $pass[] = $alphabet[$x];
    }
    return implode($pass); //turn the array into a string
}

function echo400($msg)
{
	$arr['status']=400;
	$arr['message']= $msg;
	echo json_encode($arr);
}

function register_customer()
{
	$err = "";
	$username = $_POST['username']; 
	if (!isset($username))
	{
		echo400("Username cant be blank");
		return;
	}
	$firstname = $_POST['firstname']; 
	$lastname = $_POST['lastname']; 
	if (!isset($firstname)||!isset($lastname))
	{
		echo400("Firstname and Lastname cant be blank");
		return;
	}
	$password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
	$businessname = $_POST['businessname']; 
	if (!isset($businessname))
	{
		echo400("Business name cant be blank");
		return;
	}
	$businessownername = $_POST['businessownername'];
	if (!isset($businessownername))
	{
		echo400("Business owner name cant be blank");
		return;
	}
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
	if (!isset($federalidnumber))
	{
		echo400("Federal ID is a required field");
		return;
	}
	$hoursofoperation1 = $_POST['hoursofoperation1']; 
	$hoursofoperation2 = $_POST['hoursofoperation2']; 
	$daysofoperation = $_POST['daysofoperation']; 
	$website = $_POST['website'];
}

function forgot_password()
{
	$user = $_REQUEST['username'];
	if (!isset($user)
	{
		$arr['status']=400;
		$arr['message']= "User credentials not found";
		echo json_encode($arr);
	}
	else
	{
		$sql = "SELECT * FROM user WHERE username = '".$user."'";
		$res = mysql_query($sql);
		if (mysql_num_rows($res)==0) 
		{
			//User not found in Customer user or admin table - invalid credentials
			$arr['status']=400;
			$arr['message']= "User credentials not found"; 
			echo json_encode($arr);
		}
		else 
		{
			//User found in admin table 
			$row = mysql_fetch_array($res);
			$arr['status']=200;
			$arr['message']= "Password has been sent to your email address";
			echo json_encode($arr);
			$password = generatePassword(8);
			//Save the updated password in the user table
			$sql = "UPDATE user SET password ='".$password."' WHERE username = '".$user."'";
			$res = mysql_query($sql);
			//Send email with password 
			mail($user,"Your DBA account password has been changed ", "Password changed to ".$password);
			
		}
	}
}

function login_check()
{
	//Check if the user credentials match 
	$user = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	if (!isset($user)||!isset($password))
	{
		$arr['status']=400;
		$arr['message']= "User credentials not found";
		echo json_encode($arr);
	}
	else
	{
		//TBD - MD5 encryption of password 
		//Check Customer user table first
		$sql = "SELECT * FROM user WHERE username = '".$user."' AND password = '".$password."'";
		$res = mysql_query($sql);
		if (mysql_num_rows($res)==0)
		{
			//If user not found in Customer User table look in Admin table 
			$sql = "SELECT * FROM admin WHERE username = '".$user."' AND password = '".$password."'";
			$res = mysql_query($sql);
			if (mysql_num_rows($res)==0) 
			{
				//User not found in Customer user or admin table - invalid credentials
				$arr['status']=400;
				$arr['message']= "Invalid user credentials"; 
				echo json_encode($arr);
			}
			else 
			{
				//User found in admin table 
				$row = mysql_fetch_array($res);
				$arr['status']=200;
				$arr['message']= "Login successful";
				$arr['logintype'] = "admin";
				$arr['data']['firstname'] = $row['firstname'];
				$arr['data']['lastname'] = $row['lastname'];
				$arr['data']['userid'] = $row['adminid'];
				echo json_encode($arr);
			}			
		}
		else
		{
			//User found in Customer Usertable 
			$row = mysql_fetch_array($res);
			if ($row['active'])
			{
				$arr['status']=200;
				$arr['message']= "Login successful";
				$arr['logintype'] = "user";
				$arr['data']['firstname'] = $row['firstname'];
				$arr['data']['lastname'] = $row['lastname'];
				$arr['data']['userid'] = $row['userid'];
				$arr['data']['customerid'] = $row['customerid'];
				$arr['data']['phone'] = $row['phone'];
				$arr['data']['defaultnotification'] = $row['defaultnotification'];					
				echo json_encode($arr);
			}
			else
			{
				$arr['status']=400;
				$arr['message'] = "User account is not active";
				echo json_encode($arr);
			}
		}
	}
}
?>
