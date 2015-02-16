<?
include "connection.php";
include "header.php";
include "rep_menu.php";
?>
<html>

<head>
	
</head>
<body>


			<div id="order_log" class="span10">
			<!-- content starts -->			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Report</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Report</h2>
						<!--<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 113px;'><i class="icon-cog"></i> Add New Product</a>
						</div>-->
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							<tr>
								<th>
								<td>
								<select id='customer_group'>
								<?php
								$query=mysql_query("select customerid,businessname from customer");
								echo "<option value='-1'>All</option>";
								while($row=mysql_fetch_array($query))
								{
									echo "<option value='".$row['customerid']."'>".$row['businessname']."</option>";
								}
								?>
								</select>
								</td>
								<td>
									<select id='customer_name'>
									<?php
									$query=mysql_query("select customergroupid,customergroupname from customergroup");
									echo "<option value='-1'>All</option>";
									while($row=mysql_fetch_array($query))
									{
										echo "<option value='".$row['customergroupid']."'>".$row['customergroupname']."</option>";
									}
									?>
									</select>
								</td>
								<td>
									<a class='btn btn-setting btn-info' onclick='call_submit()'>Filter</a>
								</td>
								</th>
							</tr>
							
							<tr>								  
								  <th colspan='2' rowspan='2'>Attributes (Expandable)</th> 
								  <th colspan='7' style='text-align:center;'>Values</th>
							</tr>
							  <tr>
								<th>Sales Receipts $</th>
								<th>DBA Total Commission</th>
								<th>Primary Agent</th>
								<th>Secondary Agent</th>
								<th>Sales Rep</th>
								<th>Others</th>
								<th>DBA Net Commissions</th>								
							  </tr>
							  <tr>
								<th>CustGrp</th>
								<th>Customer</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>								
							  </tr>
						  </thead>   
						<tbody id='data'>
						<?php
							//////////////
							$query=mysql_query("select SUM(totalfinalordered),businessname,customergroupname,totalcmsn,agentcmsn,seccmsn,repcmsn,othercmsn,netcmsn from customer,`order`,customergroup where `order`.customerid=customer.customerid and customer.customergroupid=customergroup.customergroupid group by `order`.customerid");
							if(mysql_num_rows($query)!=0)
							{
								while($row=mysql_fetch_array($query))
								{
									
									 $totalcmsn=round(($row['SUM(totalfinalordered)']*$row['totalcmsn'])/100,2);
									 $agentcmsn=round(($row['SUM(totalfinalordered)']*$row['agentcmsn'])/100,2);
									 $seccmsn=round(($row['SUM(totalfinalordered)']*$row['seccmsn'])/100,2);
									 $repcmsn=round(($row['SUM(totalfinalordered)']*$row['repcmsn'])/100,2);
									 $othercmsn=round(($row['SUM(totalfinalordered)']*$row['othercmsn'])/100,2);
									 $netcmsn=round(($row['SUM(totalfinalordered)']*$row['netcmsn'])/100,2);
									
									echo "<tr>";
									echo "<td>".$row['customergroupname']."</td>";
									echo "<td>".$row['businessname']."</td>";									
									echo "<td>".round($row['SUM(totalfinalordered)'],2)." $</td>";
									if($totalcmsn!=0){
									echo "<td>".round($totalcmsn,2)."(".$row['totalcmsn']."%)</td>";
									}
									else{
										echo "<td>0</td>";
									}
									if($agentcmsn!=0){
									echo "<td>".round($agentcmsn,2)."(".$row['agentcmsn']."%)</td>";	
									}
									else{echo "<td>0</td>";}
									if($seccmsn!=0){
									echo "<td>".round($seccmsn,2)."(".$row['seccmsn']."%)</td>";}
									else{
										echo "<td>0</td>";
									}
									if($repcmsn!=0){
									echo "<td>".round($repcmsn,2)."(".$row['repcmsn']."%)</td>";	}
									else{
										echo "<td>0</td>";
									}
									if($othercmsn!=0){
									echo "<td>".round($othercmsn,2)."(".$row['othercmsn']."%)</td>";}
									else{
										echo "<td>0</td>";
									}
									if($netcmsn!=0){
									echo "<td>".round($netcmsn,2)."(".$row['netcmsn']."%)</td>";}
									else{
										echo "<td>0</td>";
									}
									
									echo "</tr>";
								}
							}							
							?>
						  
						</tbody>
					  </table>  
					  
					  
					  
					</div>
				</div><!--/span-->
				</div><!--/span-->			
			</div><!--/row-->		
		<!-- content ends -->
		
		</div><!--/#content.span10-->
		
		<? include "footer.php"?>

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
var ul1 = false;
var ul2 = false;
var ul3 = false;
var ul4 = false;
var ul5 = false;

function call_submit(){
	var customer_group=$('#customer_group').val();
	var customer_name=$('#customer_name').val();	
	$.ajax({
		type: "POST",
		url: "commision_report_ajax.php",
		data: {group_id:customer_name,customer_id:customer_group}
	})
	.done(function( msg ){
		
		$("#data").html('');
		$("#data").html(msg);
		
				
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
							$("#price").val(obj['totalprice']);
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