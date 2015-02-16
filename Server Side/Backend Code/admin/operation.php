<html>

<head>
	
</head>
<body onload="shoto()">
<?
include "connection.php";
include "header.php";
include "op_menu.php";
if(isset($_REQUEST['submit']))
{
	// $confirm_date=$_POST['confim_date'];
	$confirm_qty='';
	$substitutewithproductid='';
	$confimQty=0;
	$confirmedfinalprice_new=0;
	$ordr_id=$_POST['ordr_id_hidden'];
	// $confrm_Status=$_POST['confrm_Status'];
	$confirmedfinalprice=0;
	
	$order_status=$_POST['overall_status'];
	$confim_date_order=$_POST['confim_date'];
	$updated = false;
	$form_data = explode('&',$_POST['form_data']);
	// print_r($form_data);//die;
	for($i=0; $i<count($form_data);$i++)
	{
		$data = explode('=', $form_data[$i]);
		//echo $data[1];
		
		switch($data[0]){
			case "confim_date":
				$confirm_date=$data[1];
				break;
			case "subs_id":
				$substitutewithproductid=$data[1];
				break;
			case "ordr_id_hidden":
				$ordr_id=$data[1];
				break;
			case "confrm_Status":
				$confrm_Status=$data[1];
				break;
			case "order_pid":
				$order_pid=$data[1];
				$updated=true;
				break;
			case "cprrce":
				if($substitutewithproductid!='' && $substitutewithproductid != -1){
					$confirmedfinalprice=($substitutewithproductid)*$confimQty;
				}else{
					$confirmedfinalprice=$data[1];
				}
				break;
		}
		if($updated)
		{
			$confmr_qty="cqty".$order_pid;
			echo $confirm_qty=$_POST[$confmr_qty];
			
			if($confrm_Status==1)$order_statuss=1;
			else $order_statuss=0;
			
			mysql_query("update orderdetail set confirmedquantity='".$confirm_qty."',substitutewithproductid='".$substitutewithproductid."',confirmedstatus='".$confrm_Status."',confirmedfinalprice='".$confirmedfinalprice."' where orderdetailid='".$order_pid."'");
			
			
			
			// echo "update orderdetail set confirmedquantity='".$confirm_qty."',substitutewithproductid='".$substitutewithproductid."',confirmedstatus='".$confrm_Status."',confirmedfinalprice='".$confirmedfinalprice."' where orderdetailid='".$order_pid."'"."<br>";
			$updated = false;
			$confirmedfinalprice_new=$confirmedfinalprice_new+$confirmedfinalprice;
		}
		// mysql_query("update orderdetail set confirmedquantity='$confirm_qty',substitutewithproductid='$substitutewithproductid[0]',confirmedstatus='$confrm_Status',confirmedfinalprice='$confirmedfinalprice' where order_pid='$order_pid'");
		if($order_status==1 || $order_statuss==1)
		{
			mysql_query("update `order` set confirmationstatus='1',totalfinalordered='$confirmedfinalprice_new' ,totalpriceconfirmed='$confirmedfinalprice_new',confirmeddeliverydate='$confim_date_order' where orderid='$ordr_id'");			
			mysql_query("update orderdetail set confirmedstatus='1' where orderdetailid='".$order_pid."'");
			
					
		}
		else
		{
			mysql_query("update `order` set confirmationstatus='$order_status',totalfinalordered='$confirmedfinalprice_new' ,totalpriceconfirmed='$confirmedfinalprice_new' where orderid='$ordr_id'");
		}
	}
		$customer_id=get_customer_id_of_order($ordr_id);
		if($order_status==1)
		{
			mysql_query("Insert into notification (notificationdatetime,message,readstatus,notificatiototype,notificationto,orderid) VALUES(NOW(),'Your Order has been confirmed','0','Confirm order','$customer_id','$ordr_id')");	
		}		
			
		$ordr_id=str_pad($ordr_id,6, '0',STR_PAD_LEFT);
		$message="your order DBAO".$ordr_id." has been confirmed";
		//echo $data_string = "msg=".$msg_co."&customerId=".$customer_id;
		$data_string = "msg=".$message."&customerId_by=".$customer_id;
		$ch = curl_init('http://104.131.176.201/webservices/gcm_server_php/send_message.php');        
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                   
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type : text","Content-lenght:".strlen($data_string)));  
		$result = curl_exec($ch);
	
	// $confirm_date=$_POST['confim_date'];
	// $confirm_qty=$_POST['confirmedquantity'];
	// $substitutewithproductid=explode("%%%",$_POST['subs_id']);
	// $confimQty=$_POST['cqty'];
	// $ordr_id=$_POST['ordr_id_hidden'];
	// $confrm_Status=$_POST['confrm_Status'];
	// if($substitutewithproductid[1]!=''){$confirmedfinalprice=($substitutewithproductid[1])*$confimQty;}
	// else
	// {
		// $confirmedfinalprice=$_POST['cprrce'];
	// }
	// echo "<br />".$confirm_date." ".$confirm_qty." ".$substitutewithproductid." ".$confimQty." ".$ordr_id." ".$confrm_Status." ".$confirmedfinalprice;die;
	// mysql_query("update orderdetail set confirmedquantity='$confirm_qty',substitutewithproductid='$substitutewithproductid[0]',confirmedstatus='$confrm_Status',confirmedfinalprice='$confirmedfinalprice' where orderid='$ordr_id'");
	header('Location: ' . basename($_SERVER['PHP_SELF']));
}
function get_customer_id_of_order($id)
{
	$row=mysql_query("select * from `order` where orderid='$id'");
	$row_query=mysql_fetch_assoc($row);
	return $row_query['customerid'];
}

?>

			
			<div class="modal hide fade" id="myModal" style='width:100%;left:22%;'>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="hide()">close</button>
				<h3>Order Confirmation</h3>
			</div>
			<div class="modal-body">
				<div class="box-content">
				<form name="form1" id="form1" class="form-horizontal" method="post" id="all" action="#">
					<div class='left' style='margin-top: 20px;width:50%;float:left;'>
					<div class="control-group" style="margin-bottom:0;line-height: 15px;">
									<label class="control-label" for="inputError">Order Number</label>
									<div class="controls">
										<p id='PONUM1'></p>
									</div>
					 </div>
					<div class="control-group" style="margin-bottom: 0;line-height: 15px;">
									<label class="control-label" for="inputError">Customer</label>
									<div class="controls">
									<p id='customer_name'></p>
									</div>
					 </div> 
					<div class="control-group" style="margin-bottom: 0;line-height: 15px;">
									<label class="control-label" for="inputError">Requested Delivery Date</label>
									<div class="controls">
									<p id='date_req'></p>
									</div>
					 </div>
					 <div class="control-group" style="margin-bottom: 0;line-height: 15px;">
									<label class="control-label" for="inputError">Requested Qty.</label>
									<div class="controls">
									<p id='req_qty'></p>
									</div>
					 </div>
					<div class="control-group" style="margin-bottom: 0;line-height: 15px;">
									<label class="control-label" for="inputError">Order value</label>
									<div class="controls">
									<p id='order_value'></p>
									</div>
					 </div>
					</div>
					<div class='right' style='margin-top: 20px;width:50%;float:left;'>
					<div class="control-group" style="margin-bottom: 0;line-height: 15px;">
									<label class="control-label" for="inputError">Order Number</label>
									<div class="controls">
										<p id='PONUM2'></p>
									</div>
					 </div>
					<div class="control-group" style="margin-bottom: 0;line-height: 15px;">
									<label class="control-label" for="inputError">Customer</label>
									<div class="controls">
									<p id='customer_name1'></p>
									</div>
					 </div> 
					<div class="control-group" style="margin-bottom: 0;line-height: 15px;">
									<label class="control-label" for="inputError">Confirmed Delivery Date</label>
									<div class="controls">
									<input name="confim_date" type="text" id="confim_date" style='height: 28px;' value=''/> 
									</div>
					 </div>
					 <div class="control-group" style="margin-bottom: 0;line-height: 15px;">
									<label class="control-label" for="inputError">Confirmed Qty</label>
									<div class="controls">
									<input name="confim_qty" type="number" id="confim_qty" style='height: 28px;' value=''/> 
									</div>
					 </div>
					<div class="control-group" style="margin-bottom: 0;line-height: 15px;">
									<label class="control-label" for="inputError">Order value</label>
									<div class="controls">
									<p id='order_value1'></p>
									</div>
					 </div>
					 <div class="control-group" style="margin-bottom: 0;line-height: 15px;">
									<label class="control-label" for="inputError">Confirmed status</label>
									<div class="controls">
									<p><select name='overall_status'id='overall_status'><option value='0'>Pending</option><option value='1'>Confirmed</option><option value='2'>Received</option></select></p>
									</div>
					 </div>
					</div>
					
					<div style='border-bottom:2px solid black;height:3px;margin-top:5px;'></div>
				
						<table class="table table-striped table-bordered bootstrap-datatable" id='body_table'>
						  
					  </table>  
					  <!--<input type="hidden" name="tot_count" id="tot_count" value="" />-->
					  <input type="hidden" name="form_data" id="form_data" value="" />
				</div>
				
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal" onclick="hide()" >Close</a>
				<input type='submit' value='Submit' name='submit' id="submit" style='background-color: #4376de;background-image:-moz-linear-gradient(top, #4c7de0, #366ddc);background-image:-ms-linear-gradient(top, #4c7de0, #366ddc);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#4c7de0), to(#366ddc));background-image: -webkit-linear-gradient(top, #4c7de0, #366ddc);background-image:-o-linear-gradient(top, #4c7de0, #366ddc);background-image:linear-gradient(top, #4c7de0, #366ddc);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c7de0, endColorstr=#366ddc,GradientType=0);border-color: #366ddc #366ddc #1d4ba8;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);color: white;border-radius: 2px;height: 28px;width: 66px;font-size: 14px;' >
				<input type='hidden' id='ordr_id_hidden' name='ordr_id_hidden'>
				<!--<a href="#" class="btn btn-primary" onclick='submit_form()' >Submit</a>-->
			</div>
			</form> 
		</div>
		
			
			<div id="order_log" class="span10">
			<!-- content starts -->			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Order</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Order History</h2>
					</div>
					<div class="box-content" id="tabs">
					
						<ul>
						<li><a href="#tabs-1">All</a></li>
						<li><a href="#tabs-2">Pending</a></li>
						<li><a href="#tabs-3">Confirmed</a></li>
						<li><a href="#tabs-4">Promotional Order</a></li>
						<li><a href="#tabs-5">Received</a></li>
						
					  </ul>
					  <div id='tabs-1'>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
									<th>Sr no.</th>
								  <th>Order No</th>
								  <th>Customer id</th> 
								  <th>Supplier id</th>
								  <th>Total price(USD)</th>
								  <th>Requested Del Date</th>	  
								  <th>Status</th>
							  </tr>
						  </thead>   
						<tbody>
							<?php
							$imm=1;
							if(!isset($_SESSION['supplierid'])){
								$query=mysql_query("select * from `order` ORDER BY orderid DESC");
							}else{
								$supplierid = $_SESSION['supplierid'];
								$query=mysql_query("select * from `order` where supplierid=$supplierid ORDER BY orderid DESC");
							}
							if(mysql_num_rows($query)!=0)
							{
							while($row=mysql_fetch_array($query))
							{
								
								$Oid=$row['orderid'];
								$query1=mysql_query("select * from `orderdetail` where orderid='$Oid' and confirmedstatus='1' ORDER BY orderid DESC");
								
								$count1=mysql_num_rows($query1);
								
								$max_id=str_pad($row['customerid'],6, '0',STR_PAD_LEFT);
								$max_id1=str_pad($row['supplierid'],6, '0',STR_PAD_LEFT);
								$max_id2=str_pad($row['orderid'],6, '0',STR_PAD_LEFT);
								
								echo "<tr><td onclick=order_edit(".$row['orderid'].")>".$imm++."</td>";
								echo "<td onclick=order_edit(".$row['orderid'].")>DBAO".$max_id2."</td>";
								echo "<td>DBAC".$max_id."</td>";
								echo "<td>DBAS".$max_id1."</td>";
								echo "<td> $".format_change($row['totalfinal'])."</td>";
								echo "<td>".$row['reqdeldt']."</td>";
								if($row['active']==0)
								{
									echo "<td>cancelled</td></tr>";
								}
								else if($row['receivestatus']==1)
								{
									echo "<td>Received</td>";
								}
								else
								{
									if($count1==0)
									{
										echo "<td>Pending</td></tr>";
									}
									else
									{
										echo "<td>Confirmed</td></tr>";
									}
								}
							}
							}
														
							?>
						  
						</tbody>
					  </table>  
					  
					  </div>
					  <div id='tabs-2'>
					<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Order No</th>
								  <th>Customer id</th> 
								  <th>Supplier id</th>
								  <th>Total price(USD)</th>
								  <th>Requested Del Date</th>	  
								  <th>Status</th>
							  </tr>
						  </thead>   
						<tbody>
							<?php
							$imm=1;
							if(!isset($_SESSION['supplierid'])){
								$query=mysql_query("select * from `order` ORDER BY orderid DESC");
							}else{
								$supplierid = $_SESSION['supplierid'];
								$query=mysql_query("select * from `order` where supplierid=$supplierid ORDER BY orderid DESC");
							}
							if(mysql_num_rows($query)!=0)
							{
								while($row=mysql_fetch_array($query))
								{							
								$Oid=$row['orderid'];
								$query1=mysql_query("select * from `orderdetail` where orderid='$Oid' and confirmedstatus='0' ORDER BY orderid DESC");			
								$count1=mysql_num_rows($query1);
							
								if($count1!=0)
								{
									$max_id=str_pad($row['customerid'],6, '0',STR_PAD_LEFT);
									$max_id1=str_pad($row['customerid'],6, '0',STR_PAD_LEFT);
									$max_id2=str_pad($row['orderid'],6, '0',STR_PAD_LEFT);
									echo "<tr><td onclick=order_edit(".$row['orderid'].")>".$imm++."</td>";
									echo "<td onclick=order_edit(".$row['orderid'].")>DBAO".$max_id2."</td>";
									echo "<td>DBAC".$max_id."</td>";
									echo "<td>DBAS".$max_id1."</td>";
									echo "<td> $".format_change($row['totalfinal'])."</td>";
									echo "<td>".$row['reqdeldt']."</td>";
									echo "<td>pending</td></tr>";
								}
									
								}
							}
														
							?>
						  
						</tbody>
						</table> 
					  </div>
					  <div id='tabs-3'>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							   <tr>
								  <th Style="width:5%">Select</th>
								  <th>Order No</th>
								  <th>Customer</th>
								  <th>Order Value(USD)</th>
								  <th>Requested Del Date</th>				  
								  <th>Status</th>
							  </tr>
						  </thead>   
						<?php
							$imm=1;
							if(!isset($_SESSION['supplierid'])){
								$query=mysql_query("select * from `order` ORDER BY orderid DESC");
							}else{
								$supplierid = $_SESSION['supplierid'];
								$query=mysql_query("select * from `order` where supplierid=$supplierid ORDER BY orderid DESC");
							}
							if(mysql_num_rows($query)!=0)
							{
								while($row=mysql_fetch_array($query))
								{							
								$Oid=$row['orderid'];
								$query1=mysql_query("select * from `orderdetail` where orderid='$Oid' and confirmedstatus='1' and receivedquantity=0 ORDER BY orderid DESC");			
								$count1=mysql_num_rows($query1);
							
								if($count1!=0)
								{
									$max_id=str_pad($row['customerid'],6, '0',STR_PAD_LEFT);
									$max_id1=str_pad($row['customerid'],6, '0',STR_PAD_LEFT);
									$max_id2=str_pad($row['orderid'],6, '0',STR_PAD_LEFT);
									echo "<tr><td onclick=order_edit(".$row['orderid'].")>".$imm++."</td>";
									echo "<td onclick=order_edit(".$row['orderid'].")>DBAO".$max_id2."</td>";
									echo "<td>DBAC".$max_id."</td>";
									echo "<td>DBAS".$max_id1."</td>";
									echo "<td> $".format_change($row['totalfinal'])."</td>";
									echo "<td>".$row['reqdeldt']."</td>";
									echo "<td>Confirmed</td></tr>";
								}									
							}
							}
														
							?>
						  </table>  
					  </div>
					  <div id='tabs-4'>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							   <tr>
								  <th Style="width:5%">Select</th>
								  <th>Order No</th>
								  <th>Customer</th>
								  <th>Order Value(USD)</th>
								  <th>Requested Del Date</th>				  
								  <th>Status</th>
							  </tr>
						  </thead>   
						<tbody>
							
							<?php
							$imm=1;
							if(!isset($_SESSION['supplierid'])){
								$query=mysql_query("select * from `promotionaleventusage`");
							}else{
								$supplierid = $_SESSION['supplierid'];
								$query=mysql_query("select * from `promotionaleventusage` where supplierid=$supplierid ORDER BY orderid DESC");
							}
							if(mysql_num_rows($query)!=0)
							{
								while($row=mysql_fetch_array($query))
								{							
								$Oid=$row['eventusageid'];
								$query1=mysql_query("select * from `promotionalusagedetail` where usageid='$Oid'");			
								$count1=mysql_num_rows($query1);
							
								if($count1!=0)
								{
									$max_id=str_pad($row['customerid'],6, '0',STR_PAD_LEFT);
									$max_id1=str_pad($row['customerid'],6, '0',STR_PAD_LEFT);
									$max_id2=str_pad($row['eventusageid'],6, '0',STR_PAD_LEFT);
									echo "<tr><td onclick=order_edit(".$row['orderid'].")>".$imm++."</td>";
									echo "<td onclick=order_edit(".$row['eventusageid'].")>DBAO".$max_id2."</td>";
									echo "<td>DBAC".$max_id."</td>";
									echo "<td>DBAS".$max_id1."</td>";
									echo "<td>".$row['eventid']."</td>";
									echo "<td>".$row['confirmeddeliverydate']."</td>";
									echo "<td>Confirmed</td></tr>";
								}
									
								}
							}
														
							?>
						</tbody>
					  </table>  
					  </div>
					  <div id='tabs-5'>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							   <tr>
								  <th Style="width:5%">Select</th>
								  <th>Order No</th>
								  <th>Customer</th>
								  <th>Order Value(USD)</th>
								  <th>Requested Del Date</th>				  
								  <th>Status</th>
							  </tr>
						  </thead>   
						<?php
							$imm=1;
							if(!isset($_SESSION['supplierid'])){
								$query=mysql_query("select * from `order` where receivestatus=1 ORDER BY orderid DESC");
							}else{
								$supplierid = $_SESSION['supplierid'];
								$query=mysql_query("select * from `order` where receivestatus=1 and supplierid=$supplierid ORDER BY orderid DESC");
							}
							if(mysql_num_rows($query)!=0)
							{
								while($row=mysql_fetch_array($query))
								{							
								$Oid=$row['orderid'];
								$query1=mysql_query("select * from `orderdetail` where orderid='$Oid' ORDER BY orderid DESC");			
								$count1=mysql_num_rows($query1);
							
								if($count1!=0)
								{
									$max_id=str_pad($row['customerid'],6, '0',STR_PAD_LEFT);
									$max_id1=str_pad($row['customerid'],6, '0',STR_PAD_LEFT);
									$max_id2=str_pad($row['orderid'],6, '0',STR_PAD_LEFT);
									echo "<tr><td onclick=order_edit(".$row['orderid'].")>".$imm++."</td>";
									echo "<td onclick=order_edit(".$row['orderid'].")>DBAO".$max_id2."</td>";
									echo "<td>DBAC".$max_id."</td>";
									echo "<td>DBAS".$max_id1."</td>";
									echo "<td>$".format_change($row['totalfinal'])."</td>";
									echo "<td>".$row['reqdeldt']."</td>";
									echo "<td>Received</td></tr>";
								}
									
								}
							}
														
							?>
						  </table>  
					  </div>
					</div>
				</div><!--/span-->
				</div><!--/span-->			
			</div><!--/row-->		
		<!-- content ends -->
		
		</div><!--/#content.span10-->
		
		<? include "footer.php"?>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  
  <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <style>
  .form-horizontal .control-label {
float: left;
width: 200px;
padding-top: 5px;
text-align: right;
}
.form-horizontal .controls {
margin-left: 160px;
padding-top: 5px;
padding-left: 89px;
}
  </style>
<script>

function shoto()
{
	//alert("here");
	$( "#tabs" ).tabs();
	
	$( "#order_li" ).click(function() {
		$( "#order_ul" ).slideToggle(1000);						
	});
	$( "#inven_li" ).click(function() {
		$( "#inven_ul" ).slideToggle(1000);						
	});
	$( "#cash_li" ).click(function() {
		$( "#cash_ul" ).slideToggle(1000);						
	});
	$("#confim_date").datepicker({
	dateFormat:'yy-mm-dd'
	});
}

function show_condiv(id){
checklist = [];
checklistjson = [];
$("#order_log").hide();
$("#gr_log").hide();
$("#gi_log").hide();
$("#"+id).show();
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
	var str = JSON.stringify(checklistjson);
	//alert(str);
	$.ajax({
		type: "POST",
		url: "delete_check.php",
		data: {local:str, table:"PurchaseOrder_header", column:"PONUM"}
	})
	.done(function( msg ){
	//	alert(msg);
		
	});
	
	for(i=0;i<checklist.length;i++){
		$("#"+checklist[i]).hide();
	}
}
function order_edit(id){
					//alert(id);
					$("#add_edit").val(1);
					
					$("#myModal").show();
					$("#myModal").addClass('in');
					
					var $div = $('<div />').appendTo('body');
					$div.attr('class','modal-backdrop fade in');
					
					$.ajax({
						type: "GET",
						url: "edit_order.php",
						data: {d:id}
					})
					.done(function(msg) {
						obj = JSON.parse(msg);
						var str = "" + obj['orderid'];
						var pad = "000000";
						var ord="DBAO"+pad.substring(0, pad.length - str.length) + str;
						$("#ordr_id_hidden").val(obj['orderid']);
						$("#PONUM1").html(ord);
						$("#PONUM2").html(ord);
						if(obj['receivestatus']==1)
						{
							$("#overall_status").val(2);
						}
						else
						{
							$("#overall_status").val(obj['confirmationstatus']);
						}
						$("#order_value1").html("$"+obj['totalprice']);
						$("#date_req").html(obj['reqdeldt']);
						$("#confim_date").val(obj['reqdeldt']);
						$("#order_value").html("$"+obj['totalprice']);
						
						var customer_id=obj['customerid'];
						$.ajax({
						type: "POST",
						url: "get_customer_name.php",
						data: {customer:customer_id}
						}).done(function(msg) {
							$("#customer_name").html(msg);
							$("#customer_name1").html(msg);
						});
						
						var ordr=obj['orderid'];
						var dt=obj['reqdeldt'];
						$.ajax({
						type: "POST",
						url: "order_detail_test.php",
						data:{d:ordr,priceondate:dt}
						}).done(function(msg) 
						{
							var str=msg.split("&&");
							$("#body_table").html(str[0]);
							$("#req_qty").html(str[1]);
							$("#confim_qty").val(str[1]);
							$("#confim_qty").prop('disabled','true');
							$("#tot_count").attr("value", str[2]);
						});										
					});
				}
				function hide()
				{					
					$("#myModal").hide();
					$(".fade").removeClass('in');
					$( ".modal-backdrop" ).remove();					
				}
				function change_status(L_id)
				{
					status=$("#status_c").val();
					if(status!='select')
					{
					id=status+'&'+L_id;
					$.ajax({
						type: "GET",
						url: "change_status.php",
						data: {d:id}
					}).done(function(msg) {
					});
					}
				}
				function update_confirm_price()
				{
					var price=$("#price_val").val();
					var arry=price.split("%%%");
					var qty=$("#qty").val();
					if(arry.length!=1){total_price=parseInt(arry[1])*parseInt(qty)};
					$("#price").val(total_price);	
				}
				$("#submit").on("click", function(){
					var datastring = $("#form1").serialize();
					// alert(datastring);
					$("#form_data").attr("value", datastring);
				});
				</script>
</body>
</html>
<?php
function round_price($price)
{
	return round($price, 2); 
}
function format_change($currrency)
{
	return number_format((float)$currrency, 2, '.', '');
}
?>