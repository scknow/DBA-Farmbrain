<?php	
include "connection.php";
function get_cutomer_name($id)
{
	$row=mysql_query("select * from customer where customerid='$id'");
	$row_query=mysql_fetch_assoc($row);
	return $row_query['businessname'];
}
function get_product_name($id)
{
	$row=mysql_query("select * from productportfolio where productid='$id'");
	$row_query=mysql_fetch_assoc($row);
	return $row_query['productlabel'];
}
function get_supplier_name($id)
{
	$row=mysql_query("select * from supplier where supplierid='$id'");
	$row_query=mysql_fetch_assoc($row);
	return $row_query['businessname'];
}
	include "header.php";
	include "op_menu.php";
?>
			
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
						<h2><i class="icon-user"></i>Rebate</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 125px;'><i class="icon-cog"></i> Add New Rebate</a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  
								  <th>Id</th>
								   <th>Order id</th>
								  <th>Product Name</th>
								  <th>Customer Name</th>
								  <th>Product Qty</th>
								  <th>Rebate value</th>
								  <th>Rebate date</th>
								</tr>
						  </thead>   
						 
						<tbody>
						  <?php
							include "connection.php";
							$sql="SELECT * FROM rebate";
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$customer_name=get_cutomer_name($row['customerid']);
								$product_name=get_product_name($row['productid']);
								$suppiler_name=get_supplier_name($row['supplierid']);
								$max_id=str_pad($row['rebateid'],6, '0',STR_PAD_LEFT);
								$order_id=str_pad($row['orderid'],6, '0',STR_PAD_LEFT);
								
								echo "<tr>";
								echo "<td>DBAR".$max_id;
								echo "</td>";
								echo "<td>DBAO".$order_id;
								echo "</td>";
								echo "<td>".$product_name;
								echo "</td>";
								echo "<td>".$customer_name;
								echo "</td>";
								echo "<td>".$row['quantity'];
								echo "</td>";
								echo "<td>".$row['rebatevalue'];
								echo "</td>";
								echo "<td>".$row['rebatedate'];
								echo "</td>";
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
				<h3>Promotion Event</h3>
			</div>
			<div class="modal-body">
				<div class="box-content">
				<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
						<fieldset>
							<div class="control-group">
							<label class="control-label" for="inputError">Product</label>
							<div class="controls">
								<select name="productid" id="productid" required > 
									<?
									include "connection.php";
									$sql = "SELECT * FROM productportfolio";
									echo "<option value=''>Select</option>";
									$result = mysql_query($sql);
									while($row=mysql_fetch_array($result)){
										echo "<option value='".$row['productid']."'>".$row['productlabel']."</option>";
									}
									?>
								</select>  
							</div>
							</div>	
							
							<div class="control-group">
							<label class="control-label" for="inputError">Supplier</label>
							<div class="controls">
								<select name="supplierid" id="supplierid" required > 
									<?
									include "connection.php";
									$sql = "SELECT * FROM supplier";
									echo "<option value=''>Select</option>";
									$result = mysql_query($sql);
									while($row=mysql_fetch_array($result)){
										echo "<option value='".$row['supplierid']."'>".$row['businessname']."</option>";
									}
									?>
								</select>  
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Type</label>
							<div class="controls">
								<select name="type" id="type" required > 
									<option value=''>Select</option>
									<option>INVOICE</option>
									<option>REBATE</option>
									<option>PRICE</option>
								</select>
							</div>
							</div>

							<div class="control-group">
							<label class="control-label" for="inputError">Date from</label>
							<div class="controls">
								<input type="date" name="datefrom" id="datefrom" required />
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Date to</label>
							<div class="controls">
								<input type="date" name="dateto" id="dateto" required />
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Minimum Order Quantity</label>
							<div class="controls">
								<input type="number" name="minimumorderquantity" id="minimumorderquantity" required />
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Percentage off</label>
							<div class="controls">
								<input type="number" name="percentageoff" id="percentageoff" value='0' onkeyup="setoff('valueoff')" required /> 
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Value off</label>
							<div class="controls">
								<input type="number" id="valueoff" onkeyup="setoff('percentageoff')" value='0' name="valueoff" required /> 
							</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="product_attribute">Promotion Text</label>
								<div class="controls">
									<textarea name="promotiontext" id="promotiontext" row='5' required > </textarea>
									
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
						$("#field_id").val(obj['promotionid']);
						
						$("#productid").val(obj['productid']);
						$("#supplierid").val(obj['supplierid']);
						$("#type").val(obj['type']);
						$("#datefrom").val(obj['datefrom']);
						$("#dateto").val(obj['dateto']);
						
						$("#minimumorderquantity").val(obj['minimumorderquantity']);
						$("#percentageoff").val(obj['percentageoff']);
						$("#valueoff").val(obj['valueoff']);	
						$("#promotiontext").val(obj['promotiontext']);
						
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
					function cusch(){
						var abc = $("#state").val();
						$("#abc").val(abc);
					}
					
					function setoff(id){
						$("#"+id).val(0);
					}

			</script>