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
		$is_error=0;
		$now =time();
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			
			if ((trim($data[1])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])=="")||(trim($data[8])=="")||(trim($data[10])==""))
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
			/* else if((strtotime($data[8]) < $now)||(strtotime($data[9]) < strtotime($data[8])))
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
			 */
			else
			{
				$price_id = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
				//$productid = ltrim(substr(trim($data[1]),-6),'0'); 
				
				$productid=trim($data[1]);
				
				$count=mysql_query("select * from productportfolio where productlabel LIKE '%$productid%'");
				
				
				if(mysql_num_rows($count)!=0)
				{
					$row=mysql_fetch_array($count);
					$productid=$row['productid'];
					$status = "true";
				}
				else
				{
					echo "in";
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
					$out .= $data[13] . ', ';
					$out .= $data[14] . ', ';
					$out .= $data[15] . ', ';
					$out .= $data[16] . ', ';
					$out .= "No such Product available";
					$out .= "\n";
					$status = "false";
					$is_error=1;
					// echo "No such brand regarding this  manufacture";
					//$out .= $data[6] . ', ';
					//$out .= "No such brand available ,";
					//$out .= "\n";
					// $status = "false";
				}
				
				$upc = trim($data[2]);
				//$supplier_id = ltrim(substr(trim($data[3]),-6),'0');
				
				$supplier_id=trim($data[3]);
				
				$count=mysql_query("select * from supplier where businessname LIKE '%$supplier_id%'");
				
				
				if(mysql_num_rows($count)!=0)
				{
					$row=mysql_fetch_array($count);
					$supplier_id=$row['supplierid'];
					$status = "true";
				}
				else
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
					$out .= $data[13] . ', ';
					$out .= $data[14] . ', ';
					$out .= $data[15] . ', ';
					$out .= $data[16] . ', ';
					$out .= "No such supplier exits";
					$out .= "\n";
					$status = "false";
					$is_error=1;
					// echo "No such brand regarding this  manufacture";
					//$out .= $data[6] . ', ';
					//$out .= "No such brand available ,";
					//$out .= "\n";
					// $status = "false";
				}
				
				
				$productname = trim($data[4]);
				$customergroup = trim($data[5]);
				
				if($customergroup=='all' || $customergroup=='All')
				{
					$customergroup=-1;
				}
				else
				{
					$count=mysql_query("select * from customergroup where customergroupname LIKE '%$customergroup%'");
				
					if(mysql_num_rows($count)!=0)
					{
						$row=mysql_fetch_array($count);
						$customergroup=$row['customergroupid'];
						$status = "true";
					}
					else
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
						$out .= $data[13] . ', ';
						$out .= $data[14] . ', ';
						$out .= $data[15] . ', ';
						$out .= $data[16] . ', ';
						$out .= "No such Customer group exits";
						$out .= "\n";
						$status = "false";
						$is_error=1;
					}
				
				}
				
				$customerid = ltrim(substr(trim($data[6]),-6),'0'); //trim($data[6]);
				
				if($customerid=='all' || $customerid=='-1' || $customerid=='All')
				{
					$customerid=-1;
				}
				
				
				$minodrqty = trim($data[7]);
				$datefrom = trim($data[8]);
				$dateto= trim($data[9]);
				$incrementodrqty = trim($data[10]);
				$price = trim($data[11]);
				$price=ltrim($price,"$");
				
				if($price!='')
				{
					if($dateto=='')
					{
						$dateto='9999-01-01';
					}
					if($is_error!=1)
					{
						if($price_id == '')
						{
							$sql = "INSERT INTO pricing(productid, upc, supplierid, productname, customergroup, customerid, minodrqty, datefrom, dateto, incrementodrqty, price, active) VALUES ('$productid', '$upc', '$supplier_id', '$productname', '$customergroup', '$customerid', '$minodrqty', '$datefrom', '$dateto', '$incrementodrqty', '$price', '1')";
							mysql_query($sql);
							
							$sql = "SELECT * FROM pricing WHERE supplierid='$supplier_id' AND customergroup='$customergroup' AND productid='$productid' AND customerid='$customerid' AND datefrom>='$datefrom' AND dateto<='$dateto'";
							
								$result = mysql_query($sql);
								while($row=mysql_fetch_array($result)){
									$sql1 = "UPDATE pricing SET dateto='$datefrom' WHERE id=".$row['id'];
									mysql_query($sql1);
								}
						}
						else
						{
						$sql = "update pricing set productid=$productid,upc=$upc, supplierid=$supplier_id, productname=$productname, customergroup=$customergroup, customerid=$customerid, minodrqty=$minodrqty, datefrom=$datefrom, dateto=$dateto, incrementodrqty=$incrementodrqty, price=$price, active='0' where id=$price_id";
						mysql_query($sql);
						}
					}
					
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
		}else
		{
			$supplierid = $_SESSION['supplierid'];
		}
		$productname = $_POST['productname']; 
		$minodrqty = $_POST['minodrqty'];
		$datefrom = $_POST['datefrom'];
		$dateto = $_POST['dateto'];
		
		if($dateto=="")
		{
			$dateto = "9999/12/31";
		}
		$price = $_POST['price'];
		$incrementodrqty = $_POST['incrementodrqty'];
		$active = $_POST['active'];
		$productid = $_POST['productid'];
		
		echo mysql_error();
		if($customergroup==-1)
		{
			$sql = "SELECT * FROM pricing WHERE supplierid='$supplierid' AND productid='$productid' AND datefrom<='$datefrom' AND dateto>='$datefrom'";
		}
		else{
			$sql = "SELECT * FROM pricing WHERE supplierid='$supplierid' AND customergroup='$customergroup' AND productid='$productid' AND datefrom<='$datefrom' AND dateto>='$datefrom'";
		}
		$result = mysql_query($sql);
		while($row=mysql_fetch_array($result))
		{
			$datefroms= date('Y/m/d', strtotime('-1 day', strtotime($datefrom)));
			
			$curdate=strtotime($datefroms);
			$mydate=strtotime($datefrom);

			if($curdate > $mydate)
			{
				$sql1 = "Delete from pricing WHERE id=".$row['id'];
			}
			else
			{
				$sql1 = "UPDATE pricing SET dateto='$datefroms' WHERE id=".$row['id'];
			}
			
			mysql_query($sql1);
			echo mysql_error();
		}
		$sql = "INSERT INTO pricing(productid, upc, supplierid, productname, customergroup, customerid, minodrqty, datefrom, dateto, incrementodrqty, price, active) VALUES ('$productid', '$upc', '$supplierid', '$productname', '$customergroup', '$customerid', '$minodrqty', '$datefrom', '$dateto', '$incrementodrqty', '$price', '$active')"; 
		$result = mysql_query($sql);
		header('Location: ' . basename($_SERVER['PHP_SELF']));
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
								  <th >	<input type="checkbox" onclick="check_all()"/></th>
								  <th>Product Id</th>
								  <th>UPC</th>
								  <th>Supplier</th>
								  <th>Product Name</th>
								  <th>Customer Group</th>
								  <th>Customer</th>
								  <th>Minimum Order Quantity</th>
								  <th>Incremental Order Quantity</th>
								  <th>Date from</th>
								  <th>Date to</th>							  
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
								$id=$row['id']."$$"."id"."$$".'pricing';
								
								$line_id=$row['productid'];
								echo "<tr id='$line_id'>";													
								echo "<td  class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['id']."') name='check[]' value='".$row['productid']."'></td>";
								$max_id=str_pad($row['productid'],6, '0',STR_PAD_LEFT);					
								echo "<td onclick=product_edit('$id');><a href='#'>DBAP{$max_id}</a></td>";
								
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
								echo "<td>{$row['incrementodrqty']}</td>";
								echo "<td>{$row['datefrom']}</td>";
								echo "<td>{$row['dateto']}</td>";
								
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
				<h3 id='heading'>Create Product Pricing</h3>
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
									<select name="supplier" id='supplier' required >
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
								
								<div id="productids" onclick="$('#overlay_box').show();$('#overlay_product').show();" required  class="products-selection normal_product" ></div>
								
								<div id="productids" class="products-selection edit_product" style='display:none'></div>
								<div id='product_selected_for_pricing' style='display: block;clear: both;'></div>	
									  
								</div>
							</div>

							<div class="control-group">
							<label class="control-label" for="inputError">Supplier side product name</label>
							<div class="controls">
								<input type="text" name="productname" id='productname'/>  
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
									<select id="state1" name="customerid" >
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
								<input id="incrementodrqty" type="text" name="incrementodrqty" onkeypress="return IsNumeric(event,'error12');" ondrop="return false;" onpaste="return false;" required/>	
								<span id="error12" style="color: Red; display: none">* Input digits (0 - 9)</span>
								
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
								<input type="text" name="dateto" id="dateto" value='9999-12-31' />
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Price(in USD)</label>
							<div class="controls">
								
								<input id="price" type="text" name="price" onkeypress="return IsNumeric1(event,'error11');" ondrop="return false;" onpaste="return false;" onchange='fix2()' required/>	
								<span id="error11" style="color: Red; display: none">* Input digits (0 - 9)</span> 
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
<a href="#" onclick="$('#overlay_box').hide();$('#overlay_product').hide(); return false;">Cancel</a>
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
					<label>Category</label>
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
					<label>Sub Category</label>
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
var checklist = new Array();
var checklistjson = new Array();
var time=0;
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
		$("div.myTools").html('<label>Customer Group</label><select id="customergroups">'+s+'</select>');
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
		url: "get_supplier_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		<?php if(isset($_SESSION['supplierid']))
		{
			$supplierid = $_SESSION['supplierid'];?>
			var s='';
			for(i=0;i<res.length;i++)
			{
				if(res[i].supplierid=='<?php echo $supplierid;0?>')
				{
					s=s+"<option value='"+res[i].supplierid+"'>"+res[i].businessname+"</option>";
				}
			}
			<?}else{?>
				var s='<option value="">All</option>';
				for(i=0;i<res.length;i++)
				{
					s=s+"<option value='"+res[i].supplierid+"'>"+res[i].businessname+"</option>";					
				}
			<?}?>
		
		$("div.myTools1").html('<label>Supplier</label><select id="suppliers">'+s+'</select>');
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
		$("div.myTools2").html('<label>Customer</label><select id="customers">'+s+'</select>');
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
		$("div.myTools3").html('<label>Product</label><select id="products">'+s+'</select>');
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
	
	/* var table=$('.datatable').dataTable();
	$("div.myTools2").html('<label>Start Date</label><input type="text" id="startD" placeholder="Start Date"/> <i>X</i>');
	$('#startD').datepicker({ 
			dateFormat: 'yy-mm-dd', 
			beforeShow : function(){
				$( this ).datepicker('option','maxDate', $('#EndD').val() );
			}
		});		
		$('input#startD').change( function() {
			std = $("#startD").val();
			end = $("#EndD").val();
			if(((std!='')||(end!=''))&&time==1)
			{
				$.ajax({
					type: "POST",
					url: "date_range.php",
					data: {sd:std, ed:end}
				})
				.done(function( msg ){
					$("#test_datatable").html(msg);
					time=0;
				});
			}
			else
			{
				$.ajax({
					type: "POST",
					url: "date_range.php",
					data: {sd:std, ed:end}
				})
				.done(function( msg ){
					$("#test_datatable").html(msg);
				});
			}
		
		});
	
	
	$("div.myTools3").html(' <label>End Date</label><input type="text" id="EndD" placeholder="End Date"/><i>X</i>');
		$('#EndD').datepicker({ 
			dateFormat: 'yy-mm-dd',
			beforeShow : function(){
				$( this ).datepicker('option','minDate', $('#startD').val() );
			}
		});
		$('input#EndD').change( function() {
			std = $("#startD").val();
			end = $("#EndD").val();
			if(((std!='')||(end!=''))&&time==1)
			{
				$.ajax({
					type: "POST",
					url: "date_range.php",
					data: {sd:std, ed:end}
				})
				.done(function( msg ){
					$("#test_datatable").html(msg);
					time=0;
				});
			}
			else
			{
				$.ajax({
					type: "POST",
					url: "date_range.php",
					data: {sd:std, ed:end}
				})
				.done(function( msg ){
					$("#test_datatable").html(msg);
				});
			}
		
		});
		 */
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
	label=label.trim().replace(/&&&/g, ' ');
	$("#productids").val(label);
	$("#productidh").val(id);
	$("#product_selected_for_pricing").html(label);	
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
					
					$("#add_edit").val(1);
					$("#heading").html("Edit product pricing");
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
						$("#supplier").val(obj['supplierid']);
						$("#productname").val(obj['productname']);
						$("#state").val(obj['customergroup']);
						$("#state1").val(obj['customerid']);
						$("#minodrqty").val(obj['minodrqty']);
						$("#incrementodrqty").val(obj['incrementodrqty']);
						$(".normal_product").hide();
						$(".edit_product").show();
						$(".edit_product").html(obj['productname']);
						
						$("#field_id").attr("disabled",true);						
						$("#supplier").attr("disabled",true);						
						$("#productname").attr("disabled",true);						
						$("#state").attr("disabled",true);						
						$("#state1").attr("disabled",true);						
						$("#minodrqty").attr("disabled",true);						
						$("#incrementodrqty").attr("disabled",true);
						$("#incrementodrqty").attr("disabled",true);						
						
						$("#datefrom").val(obj['datefrom']);	
						$("#dateto").val(obj['dateto']);
						$("#price").val(obj['price']);
						$("#price").attr("disabled",true);
						
						var StartDate=obj['datefrom'];
						var EndDate=obj['dateto'];
						
						var d = new Date();
						var n = d.getDate();
						var n1= parseInt(d.getMonth())+1;
						var n2 = d.getFullYear();
						var today_date=n2+'-'+n1+'-'+n;
						var TDate = new Date(today_date);
						var sDate = new Date(StartDate);
						var eeDate = new Date(EndDate);
						
						
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
						$("#heading").html("Create product pricing");
						$(".edit_product").hide();
						$(".normal_product").show();
						$("#field_id").attr("disabled",false);						
						$("#supplier").attr("disabled",false);						
						$("#productname").attr("disabled",false);						
						$("#state").attr("disabled",false);						
						$("#state1").attr("disabled",false);						
						$("#minodrqty").attr("disabled",false);						
						$("#incrementodrqty").attr("disabled",false);
						$("#incrementodrqty").attr("disabled",false);
						
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
					var r = confirm("Are you sure you want to delete these entries ?");
					if (r == true) 
					{
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
					}}
					
					$(function() {
						$( "#datefrom" ).datepicker({ dateFormat: "yy-mm-dd",minDate: 1, maxDate: "+36M +10D" });
						
						$( "#dateto" ).datepicker({ dateFormat: "yy-mm-dd",minDate: 1, maxDate: "+72M +10D" });
						
					
						//$("#dateto").datepicker("setDate", "1");
						
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
				label=label.trim().replace(/ /g, '&&&');
				str = str + "<div class='left'><input type='button' onclick=add_product('"+objt[i]['productid']+"','"+label+"') value='select' /><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><i>"+objt[i]['productdescription']+"</i></div>";
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
				label=label.trim().replace(/ /g, '&&&');
				str = str + "<div class='left'><input type='button' onclick=add_product("+objt[i]['productid']+",'"+label+"') value='select' /><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><i>"+objt[i]['productdescription']+"</i></div>";
		}
		$("#product_view").html(str);
	});
}
					$("#download_csv").on("click", function(e){
						//alert(checklist);
						download_csv_selected('pricing', checklist, 'pricing', 'submit', 'id');
						// location.href="dba_export_csv.php?type=pricing&list="+checklist+"&page_name=pricing&action=submit&type_nam=id";			
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
					
					var checkss=0;
					function check_all()
					{
						if(checkss==0)
						{
							checkss=1;							
							$($(".table").dataTable().fnGetNodes()).find('.check_box1').each(function ()
							{
									$this = $(this);
									$this.find(".checker span").addClass("checked");
									$this.find(".check_box").attr('checked', 'checked');
									
								
							});

							$($(".table").dataTable().fnGetNodes()).find(':checkbox').each(function () {
									$this = $(this);
									$this.attr('checked', 'checked');
									var id=$this.val();								
									var ide = {
									row:id
									}
								checklistjson.push(ide);
								checklist.push(id);	
								
							});
							
						}
						else
						 {
							$(".check_box").attr("checked",false);
							$(".checker span").removeClass();
							checkss=0;
							$($(".table").dataTable().fnGetNodes()).find('.check_box1').each(function ()
							{
								$this = $(this);
								$this.find(".checker span").removeClass();
								$this.find(".check_box").attr('checked',false);
							});
								checklistjson=[];
								checklist=[];
							
						}
					
									
					}
					function IsNumeric1(e,id) 
						{
							var keyCode = e.which ? e.which : e.keyCode
							var ret = ((keyCode >= 46 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
							document.getElementById(id).style.display = ret ? "none" : "inline";
							
							return ret;
						}
					//
					function fix2()
					{
						var price_enter=$("#price").val();
						price_enter=parseFloat(price_enter);
						price_enter=price_enter.toFixed(2);
						$("#price").val(price_enter);					
					}
					
			</script>