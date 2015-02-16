<html>

<head>
	
</head>
<body>
<?
include "connection.php";
include "header.php";
include "rep_menu.php";

?>

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
					<div class="box-content" id="tabs">
					
					  <div id='tabs-1'>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						<thead>
							<tr>
								
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
									<select id='category_name'>
										<?php
										$query=mysql_query("select productcategoryid,productcategoryname from productcategory");
										echo "<option value='-1'>All</option>";
										while($row=mysql_fetch_array($query))
										{
											echo "<option value='".$row['productcategoryid']."'>".$row['productcategoryname']."</option>";
										}
										?>
									</select>
								</td>
								<td>
									<select id='manufacturer_name'>
									<?php
									$query=mysql_query("select manufid,manufname from manufacturer");
									echo "<option value='-1'>All</option>";
									while($row=mysql_fetch_array($query))
									{
										echo "<option value='".$row['manufid']."'>".$row['manufname']."</option>";
									}
									?>
									</select>
								</td>
								<td>
									<a class='btn btn-setting btn-info' onclick='call_submit()'>Filter</a>
								</td>
								
							</tr>
							
							  <tr>
								  <th colspan='7'></th>
								  <th colspan='3'>Current Month</th> 
								  <th colspan='3'>Previous Month</th>
								  <th colspan='3'>MOM Variance (%)</th>
							  </tr>
							  <tr>
								<th>Customer</th>
								<th>Mfg</th>
								<th>Supplier</th>
								<th>Category</th>
								<th>SubCategory</th>
								<th>Brand</th>
								<th>Product</th>
								<th>Qty</th>
								<th>$</th>
								<th>AVG price</th>
								<th>Qty</th>
								<th>$</th>
								<th>AVG price</th>
								<th>Qty</th>
								<th>$</th>
								<th>AVG price</th>
							  </tr>
						  </thead>   
						<tbody id='data'>
							<?php
							///////////Query building//
							//(Incomplete)
							//(How to derive relation to get Current/Previous month Data)(DataBase tables don't have proper relations)
							//////////////
							$query='';
							
							$querys=mysql_query("select productid from orderdetail,`order` where order.customerid=1 group by productid");
							while($row_productId=mysql_fetch_array($querys))
							{
								$p_id=$row_productId['productid'];
								if(!isset($_SESSION['supplierid'])){
									$query = mysql_query("select orderdetail.productid,productcategoryname,productlabel,productmanufacturer,brand,SUM(confirmedfinalprice) AS price ,AVG(confirmedfinalprice) AS AVG_PRICE,SUM(quantity) AS QTY,manufname,brandname,customer.businessname,supplier.businessname As supplier_name from `order`,orderdetail,productportfolio,productcategory,manufacturer,brand,customer,supplier where `order`.customerid=1 and `order`.orderid=orderdetail.orderid and orderdetail.productid=$p_id and productportfolio.productid=$p_id and productcategory.productcategoryid=productportfolio.productcategoryid and productportfolio.productmanufacturer=manufacturer.manufid and `order`.customerid=customer.customerid and `order`.supplierid=supplier.supplierid  and `order`.`creationtime` > CURDATE() - INTERVAL 1 MONTH GROUP BY productid");
									
									$query1 = mysql_query("select orderdetail.productid,productcategoryname,productlabel,productmanufacturer,brand,SUM(confirmedfinalprice) AS price ,AVG(confirmedfinalprice) AS AVG_PRICE,SUM(quantity) AS QTY,manufname,brandname,customer.businessname,supplier.businessname As supplier_name from `order`,orderdetail,productportfolio,productcategory,manufacturer,brand,customer,supplier where `order`.customerid=1 and `order`.orderid=orderdetail.orderid and orderdetail.productid=$p_id and productportfolio.productid=$p_id and productcategory.productcategoryid=productportfolio.productcategoryid and productportfolio.productmanufacturer=manufacturer.manufid and `order`.customerid=customer.customerid and `order`.supplierid=supplier.supplierid  and month(creationtime)=month(NOW()) GROUP BY productid");
									
								}else{
									$supplierid = $_SESSION['supplierid'];
									$query = mysql_query("select orderdetail.productid,productcategoryname,productlabel,productmanufacturer,brand,SUM(confirmedfinalprice) AS price ,AVG(confirmedfinalprice) AS AVG_PRICE,SUM(quantity) AS QTY,manufname,brandname,customer.businessname,supplier.businessname As supplier_name from `order`,orderdetail,productportfolio,productcategory,manufacturer,brand,customer,supplier where `order`.customerid=1 and `order`.orderid=orderdetail.orderid and orderdetail.productid=$p_id and productportfolio.productid=$p_id and productcategory.productcategoryid=productportfolio.productcategoryid and productportfolio.productmanufacturer=manufacturer.manufid and `order`.customerid=customer.customerid and `order`.supplierid=supplier.supplierid  and `order`.`creationtime` > CURDATE() - INTERVAL 1 MONTH GROUP BY productid");
									
									$query1 = mysql_query("select orderdetail.productid,productcategoryname,productlabel,productmanufacturer,brand,SUM(confirmedfinalprice) AS price ,AVG(confirmedfinalprice) AS AVG_PRICE,SUM(quantity) AS QTY,manufname,brandname,customer.businessname,supplier.businessname As supplier_name from `order`,orderdetail,productportfolio,productcategory,manufacturer,brand,customer,supplier where `order`.customerid=1 and `order`.orderid=orderdetail.orderid and orderdetail.productid=$p_id and productportfolio.productid=$p_id and productcategory.productcategoryid=productportfolio.productcategoryid and productportfolio.productmanufacturer=manufacturer.manufid and `order`.customerid=customer.customerid and `order`.supplierid=supplier.supplierid  and month(creationtime)=month(NOW()) GROUP BY productid");
									
								}
							
								// echo $query;
								if(mysql_num_rows($query)!=0 || mysql_num_rows($query1)!=0)
								{
									$row=mysql_fetch_array($query);									
									$row1=mysql_fetch_array($query1);
									
									if(mysql_num_rows($query)!=0)
									{
										
										echo "<tr>";
										echo "<td>".$row['businessname']."</td>";
										echo "<td>".$row['manufname']."</td>";
										echo "<td>".$row['supplier_name']."</td>";
										echo "<td>".$row['productcategoryname']."</td>";
										echo "<td>".$row['businessname']."</td>";
										echo "<td>".$row['brandname']."</td>";
										echo "<td>".$row['productlabel']."</td>";
									
									}
									else
									{
										echo "<tr>";
										echo "<td>".$row['businessname']."</td>";
										echo "<td>".$row['manufname']."</td>";
										echo "<td>".$row['supplier_name']."</td>";
										echo "<td>".$row['productcategoryname']."</td>";
										echo "<td>".$row['businessname']."</td>";
										echo "<td>".$row['brandname']."</td>";
										echo "<td>".$row['productlabel']."</td>";
									
									}
									
									
									if(mysql_num_rows($query)!=0)
									{	
										echo "<td>".$current_qty=$row['QTY']."</td>";
										echo "<td>".$current_price=$row['price']."</td>";
										echo "<td>".$current_avg_price=round($row['AVG_PRICE'], 2)."</td>";
									}
									else									
									{
										$current_qty=0;
										$current_price=0;
										$current_avg_price=0;
										
										echo "<td>".$prev_qty."</td>";
										echo "<td>".$prev_price."</td>";
										echo "<td>".$prev_avg_price."</td>";

									}
									if(mysql_num_rows($query1)!=0)
									{
										echo "<td>".$prev_qty=$row1['QTY']."</td>";
										echo "<td>".$prev_price=$row1['price']."</td>";
										echo "<td>".$prev_avg_price=round($row1['AVG_PRICE'], 2)."</td>";
									}
									else
									{
										$prev_qty=0;
										$prev_price=0;
										$prev_avg_price=0;
										
										echo "<td>".$prev_qty."</td>";
										echo "<td>".$prev_price."</td>";
										echo "<td>".$prev_avg_price."</td>";
									}
									
										$mom_qty=abs($prev_qty-$current_qty);
										$mom_price=abs($prev_price-$current_price);
										$mom_avg_price=abs($prev_avg_price-$current_avg_price);
										
										echo "<td>".$mom_qty."</td>";
										echo "<td>".$mom_price."</td>";
										echo "<td>".round($mom_avg_price, 2)."</td>";
										echo "</tr>";
																}
							}														
							?>
						  
						</tbody>
					  </table>  
					  
					  </div>
					  
					  
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

function call_submit(){
	var customer_group=$('#customer_group').val();
	var customer_name=$('#customer_name').val();
	var category_name=$('#category_name').val();
	var manufacturer_name=$('#manufacturer_name').val();	
	$.ajax({
		type: "POST",
		url: "movement_report_ajax.php",
		data: {group_id:customer_name,customer_id:customer_group,category_name:category_name,manufact_name: manufacturer_name}
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