<?php
include "connection.php";
if(isset($_REQUEST['submit'])){
	$eventname = $_POST['eventname']; 
	$startdate = $_POST['startdate']; 
	$enddate = $_POST['enddate'];
	$customergiveaway = $_POST['customergiveaway'];
	$supplierchargeable = $_POST['supplierchargeable'];
	$maxquantity = $_POST['maxquantity'];
	//echo $customersid;
	$sql = "INSERT INTO promotionalevent(eventname, startdate, enddate, customergiveaway, supplierchargeable, maxquantity) VALUES ('$eventname', '$startdate', '$enddate', '$customergiveaway', '$supplierchargeable', '$maxquantity')"; 
	$result = mysql_query($sql);
	
	$sql="SELECT MAX( eventid  ) FROM promotionalevent";
	$result=mysql_query($sql);
	$temp=mysql_fetch_array($result);
	$max_id = $temp['MAX( eventid  )'];
	$productid = $_POST['productid'];
	$productid = explode(",",$productid);
	//print_r($productid);
	
	for($i=0;$i<sizeof($productid);$i++){
		$sql = "INSERT INTO promotionaleventdetail(eventid,productid)VALUES('$max_id','$productid[$i]')";
		$result=mysql_query($sql);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/css.css" />
<link rel="stylesheet" type="text/css" href="styles.css" />
<title>Manage a Promotional Event</title>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.5.js" type="text/javascript"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"></script>
<script src="http://www.erichynds.com/examples/jquery-ui-multiselect-widget/src/jquery.multiselect.js" type="text/javascript"></script>
<script>
function cusch(){
var abc = $("#state").val();
$("#abc").val(abc);
}
</script>
</head>

<body>
<?
include "nav.php";
?>

<div class="left_form">
<div class="left_menu">
<div class="sidebar_nav">
<h3><a href="#">Manage Promotional Event
</a></h3>

<div class="inner_nav">
<ul>
<li><a href="manage_promotional_event.php">Create/Edit promotional Event</a></li>
</ul>
</div><!--inner_nav close-->
</div><!--sidebar close-->
</div><!--left_menu close-->
</div>
            <div class="right_form">
					<div class="table">
					<h3>Create a Promotional Event</h3>
                    		<div class="customer_group">
							<table border="0">
							<form method="post" id="all" action="#" enctype="multipart/form-data" >
							<tbody>
							<tr>
							<td>Promotional Event Name</td>
                            <td><input type="text" name="eventname" required /></td>
							</tr>
                            <tr>
							<td>Start Date</td>
                            <td><input type="date" name="startdate" required /></td>
							</tr>
                            <tr>
							<td>End Date</td>
                            <td><input type="date" name="enddate" required /></td>
							</tr>
                            <tr>
							<td>Customer give away</td>
                            <td><input type="number" name="customergiveaway" required /></td>
							</tr>
                            <tr>
							<td>Supplier Chargeable</td>
                            <td><input type="number" name="supplierchargeable" required /></td>
							</tr>
							<tr>
							<td>Max Quantity</td>
                            <td><input type="number" name="maxquantity" required /></td>
							</tr>
							<tr>
							<td>Selected Products</td>
							<td><select id="state" multiple onchange="cusch()" required >
							    <?
								include "connection.php";
								$sql = "SELECT * FROM productportfolio";
								$result = mysql_query($sql);
								while($row=mysql_fetch_array($result)){
									echo "<option value='".$row['productid']."'>".$row['productlabel']."</option>";
								}
								?>
							  </select></td>
							</tr>
							<tr style="display:none" >
							<td>products</td>
							<td><input id="abc" type="text" name="productid" />
							   </td>
							</tr>
                          	</tbody>
                            </table>
							<input class="bottom" type="submit" name="submit" value="Submit" />
							<a class="cancel" href="dashboard.php">Cancel</a>
							</form>
                            </div><!--customer_group_closed-->
                            <a href="../Manage Promotions/select_a_product_popup.html">Add</a>
                            </div><!--table closed-->
                            	<div class="drop_down">
                                </div>
                                
                             <div class="list_customer_group">
                             <table border="1">
<tbody>
<tr>
<th>Promotional Event Name</th>
<th>Date from</th>
<th>Date to</th>
</tr>
<tr>
<?php
	include "connection.php";
	$sql = "SELECT * FROM promotionalevent";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		echo "<tr><td>".$row['eventname']."</td><td>".$row['startdate']."</td><td>".$row['enddate']."</td></tr>";
	}
?>

</tbody>
</table>
</div><!--list_customer_group closed-->
</div>
</body>
                             
                                
                            
                           
                            

<body>
</body>
</html>
