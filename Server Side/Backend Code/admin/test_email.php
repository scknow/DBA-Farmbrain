<?php
if($add_edit==1)
{
	$sql1="SELECT * FROM `help_support` where id='$id'";
	$TINUM="TCKT".($id+100000);
}
else
{	
	$id=$vh['MAX(id)'];
	$sql1="SELECT * FROM `help_support` where id='$id'";
	$TINUM="TCKT".($id+100000);
}
$result1 = mysql_query($sql1);
$row1 = mysql_fetch_array($result1);

$assigned['Gundeep Singh']='gundeep.singh@scknow.com';
$assigned['Gaurav Kohli']='Gaurav.kohli@scknow.com';
$assigned['Brian Carlson']='b.carlson@msn.com';
$assigned['Karan Checker']='karan.checker@scknow.com';
$assigned['Varinder Singh']='varinder@startupelves.com';
$assigned['Jatin']='jatin@startupelves.com';
$assigned['SNA Test team']='shrey.trikha@gmail.com';
$assigned['james']='james@scknow.com';
$email=$row1['TIATO'];

$email=$assigned[$email];
$email=$assigned[$email];

if($add_edit==1)
{	
	$to ="jatin@startupelves.com,gundeep.singh@scknow.com,Gaurav.kohli@scknow.com,karan.checker@scknow.com,".$email;
	$subject = 'Issue #'.$TINUM.' has been updated'; 
}
else
{
	$to ="jatin@startupelves.com,gundeep.singh@scknow.com,Gaurav.kohli@scknow.com,karan.checker@scknow.com,".$email;	
	$subject = 'Issue #'.$TINUM.' has been created and assigned to you'; 
}


//create a boundary string. It must be unique 
//so we use the MD5 algorithm to generate a random hash
$random_hash = md5(date('r', time())); 
//define the headers we want passed. Note that they are separated with \r\n
$headers = "From: no-reply@dba.co";
//add boundary string and mime type specification
$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\""; 
//define the body of the message.
ob_start(); //Turn on output buffering
?>


<?
if($add_edit==1)
{
?>
	<p> Issue # <?php echo $TINUM;?> has been updated </p>	
<?
}
else
{
?>
<p> Issue # <?php echo $TINUM;?> has been created and assigned to you </p>	
<?
}
?>

			<table id="customers">
			<tr><td>Issue category</td><td><?php echo $row1['TICAT'];?></td></tr>
			<tr><td>Issue Priority</td><td><?php echo $row1['TIPRI'];?></td></tr>
			<tr><td>Issue</td><td><?php echo $row1['TIDEC'];?></td></tr>
			<tr><td>Issue description</td><td><?php echo $row1['TIDET'];?></td></tr>
			<tr><td>Created by</td><td><?php echo $row1['CRTBY'];?></td></tr>	
			<tr><td>Created on</td><td><?php echo $row1['CRDAT'];?></td></tr>
			<tr><td>Current Status</td><td><?php echo $row1['TISTA'];?></td></tr>			
		</table>
	

<?
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email
//$mail_sent = @mail( $to, $subject, $message, $headers );

curl_post($to,$subject,$message);

function curl_post($email_to,$subject,$message)
{
$data_string = "msg=".$message."&email_to=".$email_to."&subject=".$subject;
$ch = curl_init('http://geri.in/farmly/PHPMailer-master/examples/dba_gmail.php');                                                               
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
$result = curl_exec($ch);
}