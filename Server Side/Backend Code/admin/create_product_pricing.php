<?php
include "connection.php";
session_start();
if(isset($_REQUEST['submit'])){
	$customerid = $_POST['customerid']; 
	$customergroup = $_POST['customergroup']; 
	$upc = $_POST['upc']; 
	$supplierid = $_POST['supplier'];
	$productname = $_POST['productname']; 
	$minodrqty = $_POST['minodrqty'];
	$datefrom = $_POST['datefrom'];
	$dateto = $_POST['dateto'];
	$price = $_POST['price'];
	$incrementodrqty = $_POST['incrementodrqty'];
	$active = $_POST['active'];
	$productid = $_POST['productid'];
	$sql = "INSERT INTO pricing(productid, upc, supplierid, productname, customergroup, customerid, minodrqty, datefrom, dateto, incrementodrqty, price, active) VALUES ('$productid', '$upc', '$supplierid', '$productname', '$customergroup', '$customerid', '$minodrqty', '$datefrom', '$dateto', '$incrementodrqty', '$price', '$active')"; 
	$result = mysql_query($sql);
	echo mysql_error();
}	

include "header.php";	
?>
			
			<!-- left menu starts -->
			<!-- left menu starts -->
<div class="span2 main-menu-span">
	<div class="well nav-collapse sidebar-nav">
		<ul class="nav nav-tabs nav-stacked main-menu">
			<li><a class="ajax-link" href="#"><i class="icon-eye-open"></i>
			<span class="hidden-tablet"> Master Data</span></a>
						<ul style='list-style:none;' style='padding-left:9px;' class='nav nav-tabs nav-stacked main-menu'>
							
							<li><a id='product_li' class="ajax-link" href="#" style='padding-left: 25px;background:rgb(243, 243, 243);'><i class="icon-eye-open"></i>					
							<span class="hidden-tablet">Product</span><i style='float: right;font-weight: bold;font-size: 19px;'>+</i></a>
								<ul style='list-style:none;margin:0;padding-left:4px; display:none' class='nav nav-tabs nav-stacked main-menu' id='product_ul'>
									<li><a class="ajax-link" href="create_edit_prod.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Product</span></a></li>
									<li><a class="ajax-link" href="create_prod_cat.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Category</span></a></li>
									<li><a class="ajax-link" href="create_prod_sub.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Sub Category</span></a></li>
								</ul>
							</li>
							
							<li><a id='customer_li' class="ajax-link" href="#" style='padding-left: 25px;background:rgb(243, 243, 243);'><i class="icon-eye-open"></i>					
							<span class="hidden-tablet">Customers</span><i style='float: right;font-weight: bold;font-size: 19px;'>+</i></a>
								<ul style='list-style:none;margin:0;padding-left:4px; display:none' class='nav nav-tabs nav-stacked main-menu' id='customer_ul'>
									<li><a class="ajax-link" href="product.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet"> Customers </span></a></li>
									<li><a class="ajax-link" href="product_group.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Users</span></a></li>
									<li><a class="ajax-link" href="customer_group.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Customer Group</span></a></li>
								</ul>
							</li>
							
							<li><a id='supplier_li' class="ajax-link" href="#" style='padding-left: 25px;background:rgb(243, 243, 243);'><i class="icon-eye-open"></i>					
							<span class="hidden-tablet">Suppliers</span><i style='float: right;font-weight: bold;font-size: 19px;'>+</i></a>
								<ul style='list-style:none;margin:0;padding-left:4px;' class='nav nav-tabs nav-stacked main-menu' id='supplier_ul'>
									<li><a class="ajax-link" href="sup_reg.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet"> Supplier</span></a></li>
									<li><a class="ajax-link" href="create_sales_user.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">User</span></a></li>
									<li><a class="ajax-link" href="product_group.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Customer Relation</span></a></li>
									<li><a class="ajax-link" href="pricing.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Pricing</span></a></li>
									<li><a class="ajax-link" href="product_group.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Promotions & Rebates</span></a></li>
									<li><a class="ajax-link" href="product_group.php" style='padding-left: 40px;background: rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Rebates</span></a></li>
								</ul>
							</li>
							
							<li><a class="ajax-link" href="#" id='node_li' style='padding-left: 25px;background:rgb(243, 243, 243);'><i class="icon-list-alt"></i>					
							<span class="hidden-tablet">Events</span><i style='float: right;font-weight: bold;font-size: 19px;'>+</i></a>
							<ul style='list-style:none;margin:0;display:none;' class='nav nav-tabs nav-stacked main-menu' style='padding-left:15px;display:none' id='node_ul'>
								<li><a class="ajax-link" href="node.php" style='padding-left: 40px;background:rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Manufacturer's Events</span></a></li>
							</ul></li>	
				</ul>
			</li>
		</ul>			
	</div><!--/.well -->
</div><!--/span-->
			
			<!-- left menu ends -->
			<div id="content" class="span10">
			<!-- content starts -->			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Supplier</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Price</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 113px;'><i class="icon-cog"></i> Add Price</a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th Style="width:5%">Select</th>
								  <th>Product Id</th>
								  <th>UPC</th>
								  <th>Supplier Id</th>
								  <th>Product Name</th>
								  <th>Customer Group Id</th>
								  <th>Customer Id</th>
								  <th>Minimum Order Quantity</th>
								  <th>Date from</th>
								  <th>Date to</th>
								  <th>Incremental Order Quantity</th>
								  <th>Price</th>
								  <th>Active</th>
							  </tr>
						  </thead>   
						<tbody>
						  <?php
							include "connection.php";
							$sql="SELECT * FROM pricing";
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['productid']."$$"."productid"."$$".'pricing';
								$line_id=$row['productid'];
								echo "<tr id='$line_id'>";
								echo "<td onclick=checked_entries('".$row['productid']."')><input type='checkbox'/></td>";
								echo "<td><a href='#' onclick=product_edit('$id')>{$row['productid']}</a></td>";
								echo "<td>{$row['upc']}</td>";
								echo "<td>{$row['supplierid']}</td>";
								echo "<td>{$row['productname']}</td>";
								echo "<td>{$row['customergroup']}</td>";
								echo "<td>{$row['customerid']}</td>";
								echo "<td>{$row['minodrqty']}</td>";
								echo "<td>{$row['datefrom']}</td>";
								echo "<td>{$row['dateto']}</td>";
								echo "<td>{$row['incrementodrqty']}</td>";
								echo "<td>{$row['price']}</td>";
								echo "<td>{$row['active']}</td>";
								echo "</tr>";
								
							}
						  ?>
						</tbody>
					  </table>  
					  <div>
						<button onclick="deletentries()" style="margin-right:10px"><a href="#">Delete Selected</a></button>
						<button style="margin-right:10px"><a href="download_csv_products.php">Download</a></button>
						<button onclick="" style="margin-right:10px"><a href="csv_upload_prdt.php">Upload</a></button>
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
				<h3>Create Product Pricing</h3>
			</div>
			<div class="modal-body">
				<div class="box-content">
				<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
					
						<fieldset>
							<div class="control-group">
							<label class="control-label" for="inputError">Upc</label>
							<div class="controls">
								<input name="upc" type="text" id="Upc" required />  
							</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="product_attribute">Supplier</label>
								<div class="controls">
									<select name="supplier" required >
									   <?php
									   //id="customer id" multiple
										include "connection.php";
										$sql = "SELECT * FROM supplier";
										echo "<option value=''>select</option>";
										$result = mysql_query($sql);
										while($row=mysql_fetch_array($result)){
											echo "<option value='".$row['supplierid']."'>".$row['businessname']."</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="product_attribute">Products</label>
								<div class="controls">
									<select name="productid" required >
									   <?php
									   //id="customer id" multiple
										include "connection.php";
										$sql = "SELECT * FROM productportfolio";
										echo "<option value=''>select</option>";
										$result = mysql_query($sql);
										while($row=mysql_fetch_array($result)){
											echo "<option value='".$row['productid']."'>".$row['productlabel']."</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="control-group">
							<label class="control-label" for="inputError">Assign product name</label>
							<div class="controls">
								<input type="text" name="productname" />  
							</div>
							</div>

							
							<div class="control-group">
								<label class="control-label" for="product_attribute">Customer Group</label>
								<div class="controls">
									<select id="state" name="customergroup" required >
									   <?php
									   //id="customer id" multiple
										include "connection.php";
										$sql = "SELECT * FROM customergroup";
										echo "<option value=''>select</option>";
										$result = mysql_query($sql);
										while($row=mysql_fetch_array($result)){
											echo "<option value='".$row['customergroupid']."'>".$row['customergroupname']."</option>";
										}
										?>
									  </select>
								</div>
							</div>
							
							
							<div class="control-group">
								<label class="control-label" for="product_attribute">Customer</label>
								<div class="controls">
									<select id="state" name="customerid" required >
									   <?php
									   //id="customer id" multiple
										include "connection.php";
										$sql = "SELECT * FROM customer";
										echo "<option value=''>select</option>";
										$result = mysql_query($sql);
										while($row=mysql_fetch_array($result)){
											echo "<option value='".$row['customerid']."'>".$row['businessname']."</option>";
										}
										?>
									</select>
								</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Minimum Order Quantity</label>
							<div class="controls">
								<input type="number" name="minodrqty" required />  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Incremental Order Quantity</label>
							<div class="controls">
								<input type="number" name="incrementodrqty" required />  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Date From</label>
							<div class="controls">
								<input type="date" name="datefrom" required />
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Date To</label>
							<div class="controls">
								<input type="date" name="dateto" required />
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Price(in USD)</label>
							<div class="controls">
								<input type="number" name="price" required />  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Active</label>
							<div class="controls">
								<select name="active" required><option value="1">Yes</option>
								<option value="0">No</option></select>
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
<?php	
	include "footer.php";
	
?>
		<script>
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
						$("#field_id").val(obj['Field']);						
						$("#product_name").val(obj['ProductName']);
						$("#product_des").val(obj['PRDCT']);
						$("#product_line").val(obj['ProductLine']);
						$("#base_price").val(obj['base_price_unit']);
						$("#p_unit").val(obj['packing_unit']);
						
						$(".select6 .chzn-single span").html(obj['ProductAttributes']);
						$(".select4 .chzn-single span").html(obj['ProductFamily']);
						$(".select2 .chzn-single span").html(obj['PRDTY']);
						$(".select1 .chzn-single span").html(obj['PRDGR']);	
						$(".select5 .chzn-single span").html(obj['UOM00']);
						$(".select3 .chzn-single span").html(obj['product_line']);
						
						$("#product_family").val(obj['ProductFamily']);
						$("#product_attribute").val(obj['ProductAttributes']);
											
						$("#product_type").val(obj['PRDTY']);
						$("#product_group").val(obj['PRDGR']);
						$("#product_unit").val(obj['UOM00']);
						$("#product_qty").val(obj['WGT00']);						
						$("#product_sfactor").val(obj['STCKF']);
						$("#product_hirearchy").val(obj['PRDHI']);
						$("#product_qr").val(obj['PRQRC']);
						$("#shelf_life").val(obj['PRSLF']);						
						$("#product_location").val(obj['PRLOC']);
						$("#nutri_detail").val(obj['PRNTL']);	
						$("#stock").val(obj['stock_stauts']);
					});
				}
				
				function hide()
				{					
					$("#myModal").hide();
					$(".fade").removeClass('in');
					$( ".modal-backdrop" ).remove();					
				}
				
				$( "#supplier_li" ).click(function() {
					$( "#supplier_ul" ).slideToggle(1000);						
				});
				
				$( "#customer_li" ).click(function() {
					$( "#customer_ul" ).slideToggle(1000);						
				});
				
				$( "#product_li" ).click(function() {
						$( "#product_ul" ).slideToggle(1000);						
					});
					
					$( "#node_li" ).click(function() {
						$( "#node_ul" ).slideToggle(700);
					});
					
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
						var str = JSON.stringify(checklistjson);
						//alert(str);
						$.ajax({
							type: "POST",
							url: "delete_check.php",
							data: {local:str, table:"Product", column:"ProductID"}
						})
						.done(function( msg ){
						//	alert(msg);
							
						});
						
						for(i=0;i<checklist.length;i++){
							$("#"+checklist[i]).hide();
						}
					}

			</script>