<?php
include "connection.php";
if(isset($_REQUEST['add_line']))
{
	session_start();
	$tbl_name="Product_Type"; // Table name
	// username and password sent from form 
	
	$ClientID = $_SESSION['cid'];
	$name=$_POST['line_name'];
	$desc=$_POST['line_des'];
	$add_edit=$_POST['add_edit'];
	if($add_edit==0)
	{
		$sql = "INSERT INTO $tbl_name (ClientID,ProductTYPE,Language) VALUES ('$ClientID','$name','$desc')";
	}
	else
	{
		$id=$_POST['field_id'];
		$sql = "update $tbl_name set ProductTYPE='$name',Language='$desc' where id='$id'";
	}
	
	$result=mysql_query($sql);
	}

include "header.php";
?>
			
			<!-- left menu starts -->
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a class="ajax-link" href="#"><i class="icon-eye-open"></i>						
						<span class="hidden-tablet"> Master Data</span></a>
						<ul style='list-style:none;' style='padding-left:9px;' class='nav nav-tabs nav-stacked main-menu'>
							<li><a class="ajax-link" href="list_client_user.php" style='padding-left: 25px;background:rgb(238, 238, 238);'><i class="icon-eye-open"></i>					
							<span class="hidden-tablet">Partner</span></a></li>
							<li><a id='product_li' class="ajax-link" href="#" style='padding-left: 25px;background:rgb(238, 238, 238);'><i class="icon-eye-open"></i>					
							<span class="hidden-tablet">Product</span><i style='float: right;font-weight: bold;font-size: 19px;'>+</i></a>
							<ul style='list-style:none;margin:0;padding-left:4px;display:none' class='nav nav-tabs nav-stacked main-menu' id='product_ul'>
								<li><a class="ajax-link" href="product.php" style='padding-left: 40px;background: rgb(255, 255, 255);'><i class="icon-eye-open"></i><span class="hidden-tablet">Product</span></a></li>
								<li><a class="ajax-link" href="product_group.php" style='padding-left: 40px;background: rgb(255, 255, 255);'><i class="icon-eye-open"></i><span class="hidden-tablet">Product Group</span></a></li>								
								<li><a class="ajax-link" href="product_type.php" style='padding-left: 40px;background: rgb(255, 255, 255);'><i class="icon-eye-open"></i><span class="hidden-tablet">Product Type</span></a></li>
								<li><a class="ajax-link" href="product_line.php" style='padding-left: 40px;background:rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Product Line</span></a></li>
								<li><a class="ajax-link" href="product_family.php" style='padding-left: 40px;background: rgb(255, 255, 255);'><i class="icon-eye-open"></i><span class="hidden-tablet">Product Family</span></a></li>
								<li><a class="ajax-link" href="product_attribute.php" style='padding-left: 40px;background:rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Product Attribute</span></a></li>
								<li><a class="ajax-link" href="unit_of_master.php" style='padding-left: 40px;background:rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Unit of Measure</span></a></li>
							</ul>
							</li>							
							
							<li><a class="ajax-link" href="#" id='node_li' style='padding-left: 25px;background:rgb(238, 238, 238);'><i class="icon-list-alt"></i>					
							<span class="hidden-tablet">Nodes</span><i style='float: right;font-weight: bold;font-size: 19px;'>+</i></a>
							<ul style='list-style:none;margin:0;display:none;' class='nav nav-tabs nav-stacked main-menu' style='padding-left:15px;display:none' id='node_ul'>
								<li><a class="ajax-link" href="node.php" style='padding-left: 40px;background:rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Node</span></a></li>
								<li><a class="ajax-link" href="handling.php" style='padding-left: 40px;background:rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Handling Units</span></a></li>
								<li><a class="ajax-link" href="equipment.php" style='padding-left: 40px;background:rgb(243, 243, 243);'><i class="icon-eye-open"></i><span class="hidden-tablet">Equipment</span></a></li>
							</ul>
							<li><a class="ajax-link" href="price.php" style='padding-left: 25px;background:rgb(238, 238, 238);'><i class="icon-eye-open"></i>					
							<span class="hidden-tablet">Pricing</span></a></li>
							</li>							
							
							
						</ul>
						</li>
						
						</ul>
						
				</div><!--/.well -->
			</div><!--/span-->
			
			<!-- left menu ends -->
			<div id="content" class="span10" style='width: 78%;background: url("images/bg.png");min-height: 600px;float: left;'>
			<!-- content starts -->		
					
				
		<!-- content ends -->
		</div><!--/#content.span10-->
				
		<hr>

		

		<? include "footer.php"?>
		<script>
		function delete_item(id)
				{
					$("#"+id).hide();
					data='table_name=Product_Type&field_name=id&id='+id;
					$.ajax({
									type: "POST",				
									url: "delete_entery.php",
									data:data
									}).done(function( msg )
										{	
											//alert(msg);
										});
				}	
				function line_edit(id){
					$("#add_edit").val(1);
					$.ajax({
						type: "GET",
						url: "edit.php",
						data: {d:id}
					})
					.done(function(msg) {
						obj = JSON.parse(msg);
						$("#field_id").val(obj['id']);
						$("#line_name").val(obj['ProductTYPE']);
						$("#line_des").val(obj['Language']);
						
					});
				}
				$( "#product_li" ).click(function() {
				$( "#product_ul" ).slideToggle(1000);
				});
				
				$( "#node_li" ).click(function() {
					$( "#node_ul" ).slideToggle(1000);
				});
				function add_new_function()
				{			
					
					$("#add_edit").val(0);
					$("#all")[0].reset();					
				}
		</script>