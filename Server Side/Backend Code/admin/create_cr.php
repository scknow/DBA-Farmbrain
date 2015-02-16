<?php
include "connection.php";
session_start();
if(isset($_REQUEST['submit'])){
	$customerid = $_POST['customerid']; 
	$sql = "SELECT * FROM customer WHERE customerid='$customerid' ";
	$result = mysql_query($sql);
	$row=mysql_fetch_array($result);
	$customerbusinessname = $row['businessname'];
	//echo $customerbusinessname;
	$salesuserid = $_SESSION['id'];
	$suppliersidecustomerid = $_POST['suppliersidecustomerid'];
	$minimumordervalue = $_POST['minimumordervalue'];
	$ordertolerancevalue = $_POST['ordertolerancevalue'];
	$supplierid = $_SESSION['sid'];
	//echo $customersid;
	$sql = "INSERT INTO suppliercustomer(supplierid, customerid, customerbusinessname, salesuserid, salesfirstname, saleslastname, suppliersidecustomerid, minimumordervalue, ordertolerancevalue) VALUES ('$supplierid', '$customerid', '$customerbusinessname', '$salesuserid', '', '', '$suppliersidecustomerid', '$minimumordervalue', '$ordertolerancevalue')"; 
	$result = mysql_query($sql);
	echo mysql_error();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/css.css" />
<link rel="stylesheet" type="text/css" href="one.css" />
<link rel="stylesheet" type="text/css" href="styles.css" />
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.5.js" type="text/javascript"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"></script>
<script src="http://www.erichynds.com/examples/jquery-ui-multiselect-widget/src/jquery.multiselect.js" type="text/javascript">

</script>
<link href="jquery-ui.css" rel="stylesheet" type="text/css" />
<title>Manage Suppliers</title>
<script type="text/javascript">
    $(document).ready(function() {
        $("#states").multiselect({
            close: function() {
                debugger;
                var values = new Array();
                $(this).multiselect("getChecked").each(function(index, item) {
                    values.push($(item).val());
                });
                $("input[id*=selectedValues]").val(values.join(","));
            }
        });
    });

function cusch(){
var abc = $("#state").val();
$("#abc").val(abc);
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
</script>
</head>
<body>
<?
include 'nav.php';
?>

<div class="left_form">
<div class="left_menu">
<div class="sidebar_nav">
<h3><a href="#">Manage Suppliers</a></h3>

<div class="inner_nav">
<ul>
<li><a href="suppl_reg_form.php">Create a Supplier</a></li>
<li><a href="create_sales_user.php">Create a Sales user</a></li>
<li><a href="list_of_suppliers_awaiting.php">Approve a Supplier</a></li>
<li><a href="list_of_suppliers.php">List of Suppliers</a></li>
</ul>
</div><!--inner_nav close-->
</div><!--sidebar close-->
</div><!--left_menu close-->
</div>

<div class="right_form">
<div class="table">
<h3>Create Customer service entry</h3>
<div class="customer_group">
<form method="post" id="all" action="#" enctype="multipart/form-data" >
<table border="0">
<tbody>
<tr>

<tr>
<td>Customers</td>
<td><select id="state"name="customerid" required >
   <?php
   //id="customer id" multiple
	include "connection.php";
	$sql = "SELECT * FROM customer";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		echo "<option value='".$row['customerid']."'>".$row['businessname']."</option>";
	}
	?>
  </select></td>
</tr>
<tr>
<td>Assign customer name</td>
<td><input type="text" name="suppliersidecustomerid" /></td>
</tr>
<tr>
<td>Minimum order value (in USD)</td>
<td><input type="number" name="minimumordervalue" required /></td>
</tr>
<tr>
<td>Oder tolerance value</td>
<td><input type="number" name="ordertolerancevalue" required /></td>
</tr>
<tr>
</tbody>
</table>
<input class="bottom" type="submit" name="submit" value="Submit" />
<a class="cancel" href="dashboard.php">Cancel</a>
</form>
</div><!--supplier_reg closed-->


<div class="list_customer_group">
<table>
<table border="0">
<tr>
<th></th>
<th></th>
</tr>
<?
	include "connection.php";
	$sql = "SELECT * FROM suppliercustomer WHERE supplierid=$_SESSION['sid']";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		echo "<tr><td>".$row['customerbusinessname']."</td><td><a href='#' class='another' >Edit</a></td></tr>";
	}
?>

</div><!--list_customer_group closed-->
</div><!--table closed-->
</div><!--main closed-->

</body>
</html>
