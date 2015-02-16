<?php
include "connection.php";
session_start();

if(isset($_REQUEST['upload_csv'])){
	if (is_uploaded_file($_FILES['filename']['tmp_name']) && !empty($_FILES['filename']['tmp_name'])) {
		// echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		

		$emailval = '/([\w\-]+\@[\w\-]+\.[\w\-]+)/';
		$mob='/^\d+$/';
		
		//Import uploaded file to Database
		$handle = fopen($_FILES['filename']['tmp_name'], "r");
		$hdata = fgetcsv($handle, 1000, ",");
		$header ="";
		foreach($hdata as $h)
		{
			if(trim($h)!="")
			$header .= trim($h) . ', ';
		}
		$header .= 'Error Description';
		$status = "false";
		$msg = "";
		$line_no = 2;
		$out="";
		$now =time();
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			
			if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])=="")||(trim($data[8])=="")||(trim($data[10])=="")||(trim($data[11])==""))
			{
				$out .= $data[0] . ', ';
				$out .= $data[1] . ', ';
				$out .= $data[2] . ', ';
				$out .= $data[3] . ', ';
				$out .= $data[4] . ', ';
				$out .= $data[5] . ', ';
				$out .= $data[6] . ', ';
				$out .= $data[7] . ', ';
				$out .= $data[8] . ', ';
				$out .= $data[9] . ', ';
				$out .= $data[10] . ', ';
				$out .= $data[11] . ', ';
				$out .= $data[12] . ', ';
				$out .= "Some field is missing at line - " . $line_no . ', ';
				$out .= "\n";
			}	
			else if((strtotime($data[8]) < $now)||(strtotime($data[9]) < strtotime($data[8])))
			{			
				$msg .= "Some field is missing. Not uploading.<br> ";
				$out .= $data[0] . ', ';
				$out .= $data[1] . ', ';
				$out .= $data[2] . ', ';
				$out .= $data[3] . ', ';
				$out .= $data[4] . ', ';
				$out .= $data[5] . ', ';
				$out .= $data[6] . ', ';
				$out .= $data[7] . ', ';
				$out .= $data[8] . ', ';
				$out .= $data[9] . ', ';
				$out .= $data[10] . ', ';
				$out .= $data[11] . ', ';
				$out .= $data[12] . ', ';
				$out .=', ';
				$out .= "Date from can't be less than or equal to today's date". ', ';
				$out .= "\n";
			}
			else
			{
				$price_id = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
				$productid = ltrim(substr(trim($data[1]),-6),'0'); //trim($data[1]);
				$upc = trim($data[2]);
				$supplier_id = ltrim(substr(trim($data[3]),-6),'0'); //trim($data[3]);
				$productname = trim($data[4]);
				$customergroup = trim($data[5]);
				$customerid = ltrim(substr(trim($data[6]),-6),'0'); //trim($data[6]);
				$minodrqty = trim($data[7]);
				$datefrom = trim($data[8]);
				$dateto= trim($data[9]);
				$incrementodrqty = trim($data[10]);
				$price = trim($data[11]);
				
				if($dateto=='')
				{
					$dateto='9999-01-01';
				}
				if($price_id == ''){
					$sql = "INSERT INTO pricing(productid, upc, supplierid, productname, customergroup, customerid, minodrqty, datefrom, dateto, incrementodrqty, price, active) VALUES ('$productid', '$upc', '$supplier_id', '$productname', '$customergroup', '$customerid', '$minodrqty', '$datefrom', '$dateto', '$incrementodrqty', '$price', '0')";
					mysql_query($sql);
					
					$sql = "SELECT * FROM pricing WHERE supplierid='$supplier_id' AND customergroup='$customergroup' AND productid='$productid' AND datefrom<'$datefrom' AND dateto>'$datefrom'";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result)){
							$sql1 = "UPDATE pricing SET dateto='$datefrom' WHERE id=".$row['id'];
							mysql_query($sql1);
						}
				}else{
					$sql = "update pricing set productid=$productid,upc=$upc, supplierid=$supplier_id, productname=$productname, customergroup=$customergroup, customerid=$customerid, minodrqty=$minodrqty, datefrom=$datefrom, dateto=$dateto, incrementodrqty=$incrementodrqty, price=$price, active='0' where id=$price_id";
					mysql_query($sql);
				}
			}
		}
		if($out!=""){
			// echo "<script></script>";
			echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');alert('Uploaded but with some errors');</script>";
		}else{
			echo "<script>alert('File Uploaded Successully');</script>";
		}
		// echo $msg;
		fclose($handle);
	}else{
		echo "<script>alert('Please choose a file to upload');</script>";
	}
}
else if(isset($_REQUEST['submit'])){
	$customerid = $_POST['customerid']; 
	$customergroup = $_POST['customergroup']; 
	$upc = $_POST['upc']; 
	if(!isset($_SESSION['supplierid'])){
		$supplierid = $_POST['supplier'];
	}else{
		$supplierid = $_SESSION['supplierid'];
	}
	$productname = $_POST['productname']; 
	$minodrqty = $_POST['minodrqty'];
	$datefrom = $_POST['datefrom'];
	$dateto = $_POST['dateto'];
	if($dateto==""){
		$dateto = "9999/12/31";
	}
	$price = $_POST['price'];
	$incrementodrqty = $_POST['incrementodrqty'];
	$active = $_POST['active'];
	$productid = $_POST['productid'];
	$sql = "INSERT INTO pricing(productid, upc, supplierid, productname, customergroup, customerid, minodrqty, datefrom, dateto, incrementodrqty, price, active) VALUES ('$productid', '$upc', '$supplierid', '$productname', '$customergroup', '$customerid', '$minodrqty', '$datefrom', '$dateto', '$incrementodrqty', '$price', '$active')"; 
	$result = mysql_query($sql);
	echo mysql_error();
	
	$sql = "SELECT * FROM pricing WHERE supplierid='$supplierid' AND customergroup='$customergroup' AND productid='$productid' AND datefrom<'$datefrom' AND dateto>'$datefrom'";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$sql1 = "UPDATE pricing SET dateto='$datefrom' WHERE id=".$row['id'];
		mysql_query($sql1);
		echo mysql_error();
	}
	
}	

include "header.php";
include "menu.php";	
?>
<link href='css/css.css' rel='stylesheet'>
	<link href='css/own.css' rel='stylesheet'>	
	
			<!-- left menu starts -->
			<!-- left menu starts -->
			<div id='upload_hover'></div>
			<!-- left menu ends -->
			<div id="content" class="span10">
			<!-- content starts -->			
			<!-- bread crum -->
			<div class='bread'>
				<ul class="breadcrumb">
					<li class="step">
						<a href="index.php">Home</a>
					</li>
					<li class="step">
						<a href="#">Suppliers</a>
					</li>
					<li class="step">
						<a href="#" class="active1">Pricing</a>
					</li>
				</ul>
			</div>
			<!-- end bread crum -->
			
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
								  <th>Supplier</th>
								  <th>Product Name</th>
								  <th>Customer Group</th>
								  <th>Customer</th>
								  <th>Minimum Order Quantity</th>
								  <th>Date from</th>
								  <th>Date to</th>
								  <th>Incremental Order Quantity</th>
								  <th>Price</th>
								  <th>Active</th>
								  <th style='display:none;'>sid</th>
								  <th style="display:none;">cid</th>
								  <th style="display:none;">cgid</th>
								  <th style="display:none;">pid</th>
							  </tr>
						  </thead>   
						<tbody id="test_datatable">
						  <?php
						  include "connection.php";
							$sql="SELECT * FROM supplier";
							$result = mysql_query($sql);
							$sup_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$sup_arr[$row['supplierid']] = $row['businessname'];
							}
							$sql="SELECT * FROM customer";
							$result = mysql_query($sql);
							$cust_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$cust_arr[$row['customerid']] = $row['businessname'];
							}
							$sql="SELECT * FROM customergroup";
							$result = mysql_query($sql);
							$cg_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$cg_arr[$row['customergroupid']] = $row['customergroupname'];
							}
							if(!isset($_SESSION['supplierid'])){
								$sql="SELECT * FROM pricing";
							}else{
								$supplierid = $_SESSION['supplierid'];
								$sql="SELECT * FROM pricing WHERE supplierid=".$supplierid;
							}
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['productid']."$$"."productid"."$$".'pricing';
								$line_id=$row['productid'];
								echo "<tr id='$line_id'>";
								echo "<td onclick=checked_entries('".$row['productid']."')><input type='checkbox'/></td>";
								$max_id=str_pad($row['productid'],6, '0',STR_PAD_LEFT);
								echo "<td>DBAP{$max_id}</td>";
								echo "<td>{$row['upc']}</td>";
								echo "<td>{$sup_arr[$row['supplierid']]}</td>";
								echo "<td>{$row['productname']}</td>";
								if($row['customergroup']==-1){
									echo "<td>All</td>";
								}else{
									echo "<td>{$cg_arr[$row['customergroup']]}</td>";
								}
								if($row['customerid']==-1){
									echo "<td>All</td>";
								}else{
									echo "<td>{$cust_arr[$row['customerid']]}</td>";
								}
								echo "<td>{$row['minodrqty']}</td>";
								echo "<td>{$row['datefrom']}</td>";
								echo "<td>{$row['dateto']}</td>";
								echo "<td>{$row['incrementodrqty']}</td>";
								echo "<td>{$row['price']}</td>";
								if($row['active']){
									echo "<td>Yes</td>";
								}else{
									echo "<td>No</td>";
								}
								echo "<td style='display:none;'>{$row['supplierid']}</td>";
								echo "<td style='display:none;'>{$row['customerid']}</td>";
								echo "<td style='display:none;'>{$row['customergroup']}</td>";
								echo "<td style='display:none;'>{$row['productid']}</td>";
								echo "</tr>";
								
							}
						  ?>
						</tbody>
					  </table>  
					  <div>
						<button onclick="deletentries()" style="margin-right:10px"><a href="#">Delete Selected</a></button>
						<button style="margin-right:10px" id="download_csv"><a href="#">Download Selected</a></button>
						<button style="margin-right:10px" id="download_csv_all"><a href="#">Download All</a></button>
						<button id="upload_csv_btn" style="margin-right:10px"><a href="#">Upload</a></button>
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
							<div class="control-group" style="display:none">
								<label class="control-label" for="inputError">UPC</label>
								<div class="controls">
									<input name="upc" type="text" id="Upc" value="abc" required />  
								</div>
							</div>
							<?
							if(!isset($_SESSION['supplierid'])){
							?>
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
							<?
							}
							?>
							<div class="control-group" style="display:none">
								<label class="control-label" for="product_attribute">Product</label>
								<div class="controls">
									<input name="productid" id="productidh" onclick="$('#overlay_box').show();$('#overlay_product').show();" required />
									  
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="product_attribute">Product</label>
								<div class="controls">
									<input id="productids" onclick="$('#overlay_box').show();$('#overlay_product').show();" required />
									  
								</div>
							</div>

							<div class="control-group">
							<label class="control-label" for="inputError">Supplier side product name</label>
							<div class="controls">
								<input type="text" name="productname" />  
							</div>
							</div>

							
							<div class="control-group">
								<label class="control-label" for="product_attribute">Customer Group</label>
								<div class="controls">
									<select id="state" name="customergroup" >
									   <?php
									   //id="customer id" multiple
										include "connection.php";
										$sql = "SELECT * FROM customergroup";
										echo "<option value=''>select</option>";
										echo "<option value='-1'>All</option>";
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
									<select id="state" name="customerid" >
									   <?php
									   //id="customer id" multiple
										include "connection.php";
										$sql = "SELECT * FROM customer";
										echo "<option value=''>select</option>";
										echo "<option value='-1'>All</option>";
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
								<input id="minodrqty" type="text" name="minodrqty" onkeypress="return IsNumeric(event,'error');" ondrop="return false;" onpaste="return false;" required/>	
								<span id="error" style="color: Red; display: none">* Input digits (0 - 9)</span>
								 
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Incremental Order Quantity</label>
							<div class="controls">
								<input id="incrementodrqty" type="text" name="incrementodrqty" onkeypress="return IsNumeric(event,'error1');" ondrop="return false;" onpaste="return false;" required/>	
								<span id="error1" style="color: Red; display: none">* Input digits (0 - 9)</span>
								
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Date From</label>
							<div class="controls">
								<input type="text" name="datefrom" id="datefrom" required />
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Date To</label>
							<div class="controls">
								<input type="text" name="dateto" id="dateto" />
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Price(in USD)</label>
							<div class="controls">
								
								<input id="price" type="text" name="price" onkeypress="return IsNumeric(event,'error1');" ondrop="return false;" onpaste="return false;" required/>	
								<span id="error1" style="color: Red; display: none">* Input digits (0 - 9)</span> 
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
		
<div id="overlay_box" class="overlay">
</div>
<div id="overlay_product" class="product_popup">

<div class="header header-pop">
<p>SELECT A PRODUCT</p>
<div class="back">
<a href="#" onclick="$('#overlay_box').hide();$('#overlay_product').hide(); return false;">cancel</a>
</div><!--back closed-->
<div class="done">
			<a href="#" onclick="$('#overlay_box').hide();$('#overlay_product').hide(); product_list(); return false;" >Done</a>
			</div><!--done closed-->
			</div><!--content closed-->

<div class="header-copy"></div>

<!-------header finish-------->




<div class="main">
                   <div class="popup">
                    <ul>
                    <li>
                  <select name="category" id="category_id" onchange="get_subcat()" >
							<?
								include "connection.php";
								$sql = "SELECT * FROM productcategory";
								echo "<option value=''>Select</option>";
								$result = mysql_query($sql);
								while($row=mysql_fetch_array($result)){
									echo "<option value='".$row['productcategoryid']."'>".$row['productcategoryname']."</option>";
								}
							?>
                         </select>
                     </li>
                    <li>
                     	  <select name="subcat_id" id="subcat_id">
                           <option value="">Select</option>
                           </select>
                     </li>
					 <li>
                     	 <input name="srch" id="srch" placeholder="Search" />
                     </li>
                     </ul>
					 <div class="filter">
                     <a href="#" onclick="product_filter()" >Filter</a>
                     </div>
					 
                    <div class="filter">
                     <a href="#" onclick="all_product()" >All</a>
                    </div> 
                     </div><!-- popup-header-->
                     
                    
                     
                         		
 <div class="description" id="product_view">
	
 </div>
                 
                                
                             
</div><!--table closed-->
</div><!--main closed-->
<div id="overlay"></div>
<?php	
	include "footer.php";
	
?>
<script>

var ul1 = false;
var ul2 = false;
var ul3 = false;
var ul4 = false;
var ul5 = false;

	$(document).ready(function(){
			$( "#supplier_ul" ).show();
			$( "#i3" ).html('-');
			ul1 = true;
			var date = new Date();
						var today = date.getDate();
						var month = date.getMonth();
						var year = date.getFullYear();
						var cda = year+"-"+(month+1)+"-"+today;
			$( "#datefrom" ).val(cda);
			all_product();
		
		
		
		
	// $('.datatable').dataTable() 
				// .columnFilter({ 	
					// sPlaceHolder: "head:before",
					// aoColumns: [
						// { type: "text" },
				    	// { type: "date-range" },
                        // { type: "date-range" }
					// ]

				// });
		
	$.ajax({
		type: "POST",
		url: "get_supplier_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
			s=s+"<option value='"+res[i].supplierid+"'>"+res[i].businessname+"</option>";
		}
		$("div.myTools").html('<label>Supplier</label><select id="suppliers">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#suppliers').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 13, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 13, true ); 
			}
		});
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	$.ajax({
		type: "POST",
		url: "get_customer_group_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
			s=s+"<option value='"+res[i].customergroupid+"'>"+res[i].customergroupname+"</option>";
		}
		$("div.myTools1").html('<label>Customer Group</label><select id="customergroups">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#customergroups').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 15, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 15, true ); 
			}
		});
		
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	$.ajax({
		type: "POST",
		url: "get_customer_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
			s=s+"<option value='"+res[i].customerid+"'>"+res[i].businessname+"</option>";
		}
		$("div.myTools4").html('<label>Customer</label><select id="customers">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#customers').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 14, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 14, true ); 
			}
		});
		
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	$.ajax({
		type: "POST",
		url: "get_product_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
			s=s+"<option value='"+res[i].productid+"'>"+res[i].productlabel+"</option>";
		}
		$("div.myTools5").html('<label>Product</label><select id="products">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#products').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 16, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 16, true ); 
			}
		});
		
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	
	
	// var d = new Date();
	// var year = d.getFullYear() - 18 ;
	var table=$('.datatable').dataTable();
	$("div.myTools2").html('<label>Start</label><input type="text" id="startD" placeholder="Start Date"/> <i>X</i>');
	$('#startD').datepicker({ 
			dateFormat: 'yy-mm-dd', 
			beforeShow : function(){
				$( this ).datepicker('option','maxDate', $('#EndD').val() );
			}
		});		
		$('input#startD').change( function() {
			std = $("#startD").val();
			end = $("#EndD").val();
				$.ajax({
					type: "POST",
					url: "date_range.php",
					data: {sd:std, ed:end}
				})
				.done(function( msg ){
					$("#test_datatable").html(msg);
				});
		});
	
	
	$("div.myTools3").html(' <label>Start</label><input type="text" id="EndD" placeholder="End Date"/><i>X</i>');
		$('#EndD').datepicker({ 
			dateFormat: 'yy-mm-dd',
			beforeShow : function(){
				$( this ).datepicker('option','minDate', $('#startD').val() );
			}
		});
		$('input#EndD').change( function() {
			std = $("#startD").val();
			end = $("#EndD").val();
				$.ajax({
					type: "POST",
					url: "date_range.php",
					data: {sd:std, ed:end}
				})
				.done(function( msg ){
					$("#test_datatable").html(msg);
				});
		});
		finish_loading_filters();
	
});
		
$( "#supplier_li" ).click(function() {
	$( "#supplier_ul" ).slideToggle(1000);	
	if(ul1){
		$( "#i3" ).html('+');
		ul1 = false;
	}else{
		$( "#i3" ).html('-');
		ul1 = true;
	}
});
				
$( "#customer_li" ).click(function() {
	$( "#customer_ul" ).slideToggle(1000);	
	if(ul2){
		$( "#i2" ).html('+');
		ul2 = false;
	}else{
		$( "#i2" ).html('-');
		ul2 = true;
	}	
});
				
$( "#product_li" ).click(function() {
	$( "#product_ul" ).slideToggle(1000);	
	if(ul3){
		$( "#i1" ).html('+');
		ul3 = false;
	}else{
		$( "#i1" ).html('-');
		ul3 = true;
	}
});
					
$( "#node_li" ).click(function() {
	$( "#node_ul" ).slideToggle(700);
	if(ul4){
		$( "#i4" ).html('+');
		ul4 = false;
	}else{
		$( "#i4" ).html('-');
		ul4 = true;
	}
});

function add_product(id,label){
	$('#overlay_box').hide();
$('#overlay_product').hide();
label = label.replace("&&&", " ");
	$("#productids").val(label);
	$("#productidh").val(id);
	
}
		function delete_item(id)
				{
					var r = confirm("Are you sure you want to delete these entries ?");
					if (r == true) 
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
					function set_pro(id){
						$("#productid").val(id);
						$('#overlay_box').hide();
						$('#overlay_product').hide();
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
					
					$(function() {
						$( "#datefrom" ).datepicker({ dateFormat: "yy-mm-dd",minDate: 0, maxDate: "+36M +10D" });
						
						$( "#dateto" ).datepicker({ dateFormat: "yy-mm-dd",minDate: 1, maxDate: "+72M +10D" });
						
					});
function get_subcat(){
	var cid=$("#category_id").val();
	//alert(cid);
	$.ajax({
		type: "GET",
		url: "get_subcat.php",
		data: {id:cid}
	})
	.done(function( msg ) {
	//alert(msg);
		$("#subcat_id").html(msg);
	});
}

function product_filter(){
	var catid=$("#category_id").val();
	var subcatid=$("#subcat_id").val();
	var serch = $("#srch").val();
	$.ajax({
		type: "GET",
		url: "product_filter.php",
		data: {cat:catid, sub:subcatid, srch:serch}
	})
	.done(function( msg ) {
		//alert(msg)
		var objt = JSON.parse(msg);
		var str = "";
		for(i=0;i<objt.length;i++){
				var label = objt[i]['productlabel'].replace(" ", "&&&");
				str = str + "<div class='left'><input type='button' onclick=add_product('"+objt[i]['productid']+"','"+label+"') value='select' /><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><label>"+objt[i]['productdescription']+"</label></div>";
		}
		$("#product_view").html(str);
	});
}

function all_product(){
	var catid=$("#category_id").val();
	var subcatid=$("#subcat_id").val();
	$.ajax({
		type: "GET",
		url: "product_filter.php",
		data: {cat:"", sub:""}
	})
	.done(function( msg ) {
	//alert(msg);
		var objt = JSON.parse(msg);
		var str = "";
		for(i=0;i<objt.length;i++){
				var label = objt[i]['productlabel'].replace(' ', '&&&');
				str = str + "<div class='left'><input type='button' onclick=add_product("+objt[i]['productid']+",'"+label+"') value='select' /><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><label>"+objt[i]['productdescription']+"</label></div>";
		}
		$("#product_view").html(str);
	});
}
					$("#download_csv").on("click", function(e){
						location.href="dba_export_csv.php?type=pricing&list="+checklist+"&page_name=pricing&action=submit&type_nam=id";			
					});
					$("#download_csv_all").on("click", function(e){
						location.href="dba_export_csv.php?type=pricing&list=&page_name=pricing&action=submit&type_nam=id";			
					});
					$("#upload_csv_btn").on("click", function(e){
						$("#upload_hover").empty();
						$("#upload_hover").css("display","block");
						$("#upload_hover").load("price_csv_upload.php");
					});
					$("#upload_csv_btn").on("click", function(e){
		$("#overlay").css("display","block");
		});
					
					
			</script>