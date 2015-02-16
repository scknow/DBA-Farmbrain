<?php
include "connection.php";
if(isset($_REQUEST['submit']))
{
	$name = $_POST['name'];
	$customergroup = $_POST['customergroup'];
	$pro_data = $_POST['pro_data'];
	$customer_id = $_POST['customersid'];
	$jso = stripslashes($pro_data);
	$arr = json_decode($jso, true);
	$add_edit=$_POST['add_edit'];
	if($add_edit==0)
	{
		$sql = "INSERT INTO orderprofile(name, type, customerid, dateofcreation, customergroup)VALUES ('$name', 'global','$customer_id',NOW(), '$customergroup')";
		mysql_query($sql);
		echo mysql_error();
	
		$sql="SELECT MAX( id ) FROM orderprofile";
		$result=mysql_query($sql);
		$temp=mysql_fetch_array($result);
		$max_id = $temp['MAX( id )'];
		for($i=0;$i<sizeof($arr);$i++){
			$productid = $arr[$i]['id'];
			$defaultquantity = $arr[$i]['qty']; 
			$substitu = $arr[$i]['subs'];
			$substituteproductids = '';
			for($k=0;$k<sizeof($substitu);$k++){
				if($k==0){
					$substituteproductids = $substitu[$k];
				}else{
					$substituteproductids = $substituteproductids.",".$substitu[$k] ;
				}
			}
			$prem = $arr[$i]['prem']; 
			$premv = $arr[$i]['premv']; 
			$sql = "INSERT INTO orderprofiledetail(orderprofileid, productid, defaultquantity, substituteproductids)VALUES ('$max_id', '$productid', '$defaultquantity','$substituteproductids')";
			mysql_query($sql);
			echo mysql_error();
			$sql1="SELECT MAX( orderprofiledetailid ) FROM orderprofiledetail";
			$result1=mysql_query($sql1);
			$temp1=mysql_fetch_array($result1);
			$max_id1 = $temp1['MAX( orderprofiledetailid )'];
			
			for($j=0;$j<sizeof($prem);$j++){
				$supplierid = $prem[$j];
				$supplierpremium = $premv[$j];
				$sql = "INSERT INTO orderprofiledetailsupplier(orderprofiledetailid, supplierid, supplierpremium)VALUES ('$max_id1', '$supplierid', '$supplierpremium')";
				mysql_query($sql);
				echo mysql_error();
			}
		}
	}
	else
	{
		$orderId=$_POST['id_of_order'];
		
		$sql="update orderprofile set name='$name',type='global',dateofcreation=NOW(),customergroup='$customergroup' where id ='$orderId'";
		
		mysql_query($sql);
		echo mysql_error();
	
		$max_id = $orderId;
		
		$check=mysql_query("select * from orderprofiledetail where orderprofileid='$max_id'");
		$row_found=mysql_fetch_array($check);
		$orderprofiledetailid_fetch=$row_found['orderprofiledetailid'];
		
		mysql_query("delete from orderprofiledetailsupplier where orderprofiledetailid='$orderprofiledetailid_fetch'");
		
		mysql_query("delete from orderprofiledetail where orderprofileid='$max_id'");
		
		for($i=0;$i<sizeof($arr);$i++){
			$productid = $arr[$i]['id'];
			$defaultquantity = $arr[$i]['qty']; 
			$substitu = $arr[$i]['subs'];
			$substituteproductids = '';
			for($k=0;$k<sizeof($substitu);$k++){
				if($k==0){
					$substituteproductids = $substitu[$k];
				}else{
					$substituteproductids = $substituteproductids.",".$substitu[$k] ;
				}
			}
			$prem = $arr[$i]['prem']; 
			$premv = $arr[$i]['premv']; 
			$sql = "INSERT INTO orderprofiledetail(orderprofileid, productid, defaultquantity, substituteproductids)VALUES ('$max_id', '$productid', '$defaultquantity','$substituteproductids')";
			mysql_query($sql);
			echo mysql_error();
			$sql1="SELECT MAX( orderprofiledetailid ) FROM orderprofiledetail";
			$result1=mysql_query($sql1);
			$temp1=mysql_fetch_array($result1);
			$max_id1 = $temp1['MAX( orderprofiledetailid )'];
			
			for($j=0;$j<sizeof($prem);$j++){
				$supplierid = $prem[$j];
				$supplierpremium = $premv[$j];
				$sql = "INSERT INTO orderprofiledetailsupplier(orderprofiledetailid, supplierid, supplierpremium)VALUES ('$max_id1', '$supplierid', '$supplierpremium')";
				mysql_query($sql);
				echo mysql_error();
			}
		}
	}
}
else if(isset($_REQUEST['submit_Saveas']))
{
	$name = $_POST['name'];
	$customergroup = $_POST['customergroup'];
	$pro_data = $_POST['pro_data'];
	$customer_id = $_POST['customersid'];
	$jso = stripslashes($pro_data);
	$arr = json_decode($jso, true);
	$add_edit=$_POST['add_edit'];
	$sql = "INSERT INTO orderprofile(name, type, customerid, dateofcreation, customergroup)VALUES ('$name', 'global','$customer_id',NOW(), '$customergroup')";
		mysql_query($sql);
		echo mysql_error();
	
		$sql="SELECT MAX( id ) FROM orderprofile";
		$result=mysql_query($sql);
		$temp=mysql_fetch_array($result);
		$max_id = $temp['MAX( id )'];
		for($i=0;$i<sizeof($arr);$i++){
			$productid = $arr[$i]['id'];
			$defaultquantity = $arr[$i]['qty']; 
			$substitu = $arr[$i]['subs'];
			$substituteproductids = '';
			for($k=0;$k<sizeof($substitu);$k++){
				if($k==0){
					$substituteproductids = $substitu[$k];
				}else{
					$substituteproductids = $substituteproductids.",".$substitu[$k] ;
				}
			}
			$prem = $arr[$i]['prem']; 
			$premv = $arr[$i]['premv']; 
			$sql = "INSERT INTO orderprofiledetail(orderprofileid, productid, defaultquantity, substituteproductids)VALUES ('$max_id', '$productid', '$defaultquantity','$substituteproductids')";
			mysql_query($sql);
			echo mysql_error();
			$sql1="SELECT MAX( orderprofiledetailid ) FROM orderprofiledetail";
			$result1=mysql_query($sql1);
			$temp1=mysql_fetch_array($result1);
			$max_id1 = $temp1['MAX( orderprofiledetailid )'];
			
			for($j=0;$j<sizeof($prem);$j++){
				$supplierid = $prem[$j];
				$supplierpremium = $premv[$j];
				$sql = "INSERT INTO orderprofiledetailsupplier(orderprofiledetailid, supplierid, supplierpremium)VALUES ('$max_id1', '$supplierid', '$supplierpremium')";
				mysql_query($sql);
				echo mysql_error();
			}
	}
	header('Location: ' . basename($_SERVER['PHP_SELF']));

}


include "header.php";
	
?>
			
			<!-- left menu starts -->
			<!-- left menu starts -->
<?
include "menu.php";
?>
	<link href='css/css.css' rel='stylesheet'>
	<link href='css/own.css' rel='stylesheet'>	
<style>
	.drop_down ul 
	{
	width: 100%;
	float: left;
	padding: 0;
	margin: 0px 0 0 0;
	background: white;
	border: 2px solid rgb(194, 194, 194);
	}
	.drop_down a {
font-weight: normal;
padding: 6px 0 !important;
color: white !important;
text-align: center !important;
background: rgb(56, 56, 56) !important;
width: 100% !important;}

.sup_settings {
width: 40%;
position: relative;
float: right;
margin-left: 3%;
margin-bottom: 9px;
margin-top: 10px;
</style>	
			<!-- left menu ends -->
			<div id="content" class="span10">
			<!-- content starts -->			
			<div class='bread'>
			
	<ul class="breadcrumb">
		<li class="step">
			<a href="index.php">Home</a>
		</li>
		<li class="step">
			<a href="#" class="active1">Order Profile</a>
		</li>
	</ul>
	</div>
	
	<div class="row-fluid sortable">		
			<div class="box span12">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-user"></i>Profile</h2>
					<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 130px;'><i class="icon-cog"></i> Add Profile</a>
					</div>
				</div>
				<div class="box-content">
					<table class="table table-striped table-bordered bootstrap-datatable datatable">
						<thead>
							<tr>
								<th><input type="checkbox" onclick="check_all()"/></th>
								<th>Profile Id</th>
								<th>Name</th>
								<th>Customer Group</th>
								<th>Customer</th>
								<th>Type</th>
								<th>Date of Creation</th>
								<th style='display:none;'>cgid</th>
								<th style='display:none;'>cid</th>
							  </tr>
						</thead>   
						<tbody>
							<?php
							include "connection.php";
							$sql="SELECT * FROM customergroup";
							$result = mysql_query($sql);
							$cg_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$cg_arr[$row['customergroupid']] = $row['customergroupname'];
							}
							$sql="SELECT * FROM customer";
							$result = mysql_query($sql);
							$cname_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$cname_arr[$row['customergroupid']] = $row['customergroupname'];
							}
							$sql="SELECT * FROM orderprofile";
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['id']."$$"."id"."$$".'orderprofile';
								$line_id=$row['id'];
								echo "<tr id='$line_id'>";
															
								echo "<td  class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['id']."') name='check[]' value='".$row['id']."'></td>";
								
								$max_id=str_pad($row['id'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$line_id')>DBAGP{$max_id}</a></td>";
								echo "<td>{$row['name']}</td>";
								$max_id=str_pad($row['customergroup'],6, '0',STR_PAD_LEFT);
								if($row['customergroup']!=-1){
								echo "<td>{$cg_arr[$row['customergroup']]}</td>";
								}
								else
								{
									echo "<td>All</td>";
								}
								if($row['customerid']!=-1){
								echo "<td>{$cname_arr[$row['customergroup']]}</td>";
								}
								else
								{
									echo "<td>All</td>";
								}
								echo "<td>{$row['type']}</td>";			
								echo "<td>{$row['dateofcreation']}</td>";
								echo "<td style='display:none'>{$row['customergroup']}</td>";
								echo "<td style='display:none'>{$row['customerid']}</td>";
								echo "</tr>";
								
							}
							?>
						</tbody>
					</table>  
					<div>
						<button onclick="deletentries()" style="margin-right:10px"><a href="#">Delete Selected</a></button>
						<button style="margin-right:10px" id="download_csv"><a href="#">Download Selected</a></button>
						<button style="margin-right:10px" id="download_csv_all"><a href="#">Download All</a></button>
						<button onclick="" style="margin-right:10px"><a href="csv_upload_prdt.php">Upload</a></button>
					</div>
				</div>
			</div><!--/span-->			
	</div>
</div><!--/#content.span10-->
				
<div class="modal hide fade" id="myModal" style="width: 70%;left: 40%;
display: block;">
	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick='hide()'>Close</button>
				<h3>Create Profile</h3>
				<a class="add" href="#" onclick="$('#overlay_box').show();$('#overlay_product').show(); return false;" id="add" style="
				background: #a1b226;  color: white;  text-decoration: none;  float: right;  text-align: center;  padding: 6px 10px;  position: absolute;  
				right: 12%;  top: 8px;  border-radius: 2px;  font-size: 15px;
			">Add Product</a>
	</div>
	<div class="modal-body">
		<div class="box-content">
		
	<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data" >
	<div class="right_form" style='width:100%;'>  
         
					<div class="table1">
                    
                    		<div class="customer_group">
							<table border="0">
							<tbody>
							<tr style="margin-top: 15px;">
							<td>Profile Name</td>
                            <td><input type="text" name="name" id="name" required ></td>
							</tr>
                            <tr>
                            <td><label style='width: 105px;float: left;'>Customer Group</label>
							<select name="customergroup" id="customergroup" onchange='show_customer()' required style='width:57%;'>
                            <?
								include "connection.php";
								$sql = "SELECT * FROM customergroup";
								echo "<option value='-1'>All</option>";
								$result = mysql_query($sql);
								while($row=mysql_fetch_array($result)){
									echo "<option value='".$row['customergroupid']."'>".$row['customergroupname']."</option>";
								}
							?>
                            </select>
                            
                            <td><select name="customersid" id="customerids" style='width:93%;' required >
							
                            <?
								include "connection.php";
								$sql = "SELECT * FROM customer";
								echo "<option value='-1'>All</option>";
								$result = mysql_query($sql);
								while($row=mysql_fetch_array($result)){
									echo "<option value='".$row['customerid']."'>".$row['businessname']."</option>";
								}
							?>
                            </select>
                           
                            </td>
                            </tr>
                            
                          	</tbody>
                            </table>
						</div><!--customer_group_closed-->
                            
							<div class="settings" id="stng">
								<p id="button">Global Supplier Settings</p>
                            	<div class="drop_down" id="one" style="display:none;">
                                <ul style='width: 100%;'>
                                   <?
								  
									include "connection.php";
									$sql = "SELECT * FROM supplier";
									$result = mysql_query($sql);
									
									while($row=mysql_fetch_array($result)){
										echo "<li><b style='width: 62px;'>".$row['businessname']."</b><input type='checkbox' onclick=supplier_name_checked('".$row['supplierid']."') id='supp_".$row['supplierid']."' checked;><i><input type='number' id='sup_id".$row['supplierid']."'></i></li>";
										
									}
									?>
                                </ul>
</div><!--drop_down closed-->
</div><!----settings-->
<div id="lis_div" >
	
</div>
     			
    </div>

				<input type='hidden' name='pro_data' id='pro_data' />
				<input type='hidden' name='id_of_order' id='id_of_order' />
        <div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" onclick='save_profile()'>Close</a>
		<input type='submit' value='Submit' name='submit' style='background-color: #4376de;background-image:-moz-linear-gradient(top, #4c7de0, #366ddc);background-image:-ms-linear-gradient(top, #4c7de0, #366ddc);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#4c7de0), to(#366ddc));background-image: -webkit-linear-gradient(top, #4c7de0, #366ddc);background-image:-o-linear-gradient(top, #4c7de0, #366ddc);background-image:linear-gradient(top, #4c7de0, #366ddc);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c7de0, endColorstr=#366ddc,GradientType=0);border-color: #366ddc #366ddc #1d4ba8;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);color: white;border-radius: 2px;height: 28px;width: 66px;font-size: 14px;' >
				<!--<a href="#" class="btn btn-primary" onclick='submit_form()' >Submit</a>-->
	</div> <!--save closed-->
		
		<div class="modal-footer" id='update'>
		
		<input type='submit' value='Save' name='submit' style='background-color: #4376de;background-image:-moz-linear-gradient(top, #4c7de0, #366ddc);background-image:-ms-linear-gradient(top, #4c7de0, #366ddc);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#4c7de0), to(#366ddc));background-image: -webkit-linear-gradient(top, #4c7de0, #366ddc);background-image:-o-linear-gradient(top, #4c7de0, #366ddc);background-image:linear-gradient(top, #4c7de0, #366ddc);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c7de0, endColorstr=#366ddc,GradientType=0);border-color: #366ddc #366ddc #1d4ba8;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);color: white;border-radius: 2px;height: 28px;width: 66px;font-size: 14px;' >
		
		<input type='submit' value='Save As' name='submit_Saveas' onclick='change_name()' style='background-color: #4376de;background-image:-moz-linear-gradient(top, #4c7de0, #366ddc);background-image:-ms-linear-gradient(top, #4c7de0, #366ddc);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#4c7de0), to(#366ddc));background-image: -webkit-linear-gradient(top, #4c7de0, #366ddc);background-image:-o-linear-gradient(top, #4c7de0, #366ddc);background-image:linear-gradient(top, #4c7de0, #366ddc);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c7de0, endColorstr=#366ddc,GradientType=0);border-color: #366ddc #366ddc #1d4ba8;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);color: white;border-radius: 2px;height: 28px;width: 66px;font-size: 14px;' >
		<input type="hidden" name='add_edit' id='add_edit' />
				<!--<a href="#" class="btn btn-primary" onclick='submit_form()' >Submit</a>-->
	</div> <!--save closed-->

	<!--<div style='width: 100%;display: block;float: left;text-align:enter; background: #ACB75D;color: white;'><p style='float:left'>Line Number#</p><p style='float:right' onclick='cp_add_order()'>+add new line</p></div>-->
</div>
</form>
</div>
         </div> 
		 
</div>
<div id="overlay_box" class="overlay" style='opacity:0.7'>
</div>
<div id="overlay_product" class="product_popup" style='top: 10%;'>

<div class="header header-pop" style='width: 70%;'>
<p>SELECT A PRODUCT</p>
<div class="back">
<a href="#" onclick="$('#overlay_box').hide();$('#overlay_product').hide(); return false;"><img src="images/cancel.png"/>cancel</a>
</div><!--back closed-->
<div class="done">
			<a href="#" onclick="$('#overlay_box').hide();$('#overlay_product').hide(); product_list(); return false;" ><img src="images/done.png"/>Done</a>
			</div><!--done closed-->
			</div><!--content closed-->

<div class="header-copy"></div>

<!-------header finish-------->

<div class="main" style='width: 70%;opacity:1'>
                   <div class="popup">
                    <ul>
                    <li>
					<label>Category</label>
                         <select name="category" id="category_id" onchange="get_subcat()" >
							<?
								include "connection.php";
								$sql = "SELECT * FROM productcategory";
								echo "<option value=''>All</option>";
								$result = mysql_query($sql);
								while($row=mysql_fetch_array($result)){
									echo "<option value='".$row['productcategoryid']."'>".$row['productcategoryname']."</option>";
								}
							?>
                         </select>
                     </li>
                    <li><label>Sub Category</label>
                     	  <select name="subcat_id" id="subcat_id">
                           <option value="">All</option>
                           </select>
                     </li>
					 <li>
					 <label style="opacity:0;">.</label>
                     	 <input name="srch" id="srch" placeholder="Search" />
                     </li>
                     </ul>
					 <div class="handle">
					 <div class="filter">
                     <a href="#" onclick="product_filter()" >Filter</a>
                     </div>
					 
                    <div class="filter">
                     <a href="#" onclick="all_product()" >All</a>
                    </div> </div>
                     </div><!-- popup-header-->
                     
                    
                     
                         		
 <div class="description" id="product_view">
	<?php
	$sql = "SELECT * FROM productportfolio where active='1'";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result))
	{
		if($row['picture1']!='a' && $row['picture1']!='')
		{
			
			echo "<div class='left' id='div".$row['productid']."'><label><input type='checkbox' onclick=add_product('".$row['productid']."') /><img src='upload/".$row['picture1']."'><small>".$row['productlabel']."</small><i>".$row['productdescription']."</i></label></div>";
		}
		else
		{
				echo "<div class='left' id='div".$row['productid']."'><label><input type='checkbox' onclick=add_product('".$row['productid']."') /><img src='images/a.png'><small>".$row['productlabel']."</small><i>".$row['productdescription']."</i></label></div>";
		}
	}
	?>
 </div>
                 
                                
                             
</div><!--table closed-->
</div><!--main closed-->

<div id="overlay_product1" class="product_popup" style='top: 10%;'>

<div class="header header-pop" style='width: 70%;'>
<p>SELECT A PRODUCT</p>
<div class="back">
<a href="#" onclick="$('#overlay_box').hide();$('#overlay_product1').hide(); return false;">Cancel</a>
</div><!--back closed-->
<div class="done">
			<a href="#" onclick="$('#overlay_box').hide(); $('#overlay_product1').hide(); product_list(); return false;" >Done</a>
			</div><!--done closed-->
			</div><!--content closed-->

<div class="header-copy"></div>
<!-------header finish-------->

<div class="main" style='width: 70%;opacity:1'>
                   <div class="popup">
                    <ul>
                    <li>
                         <select name="category" id="category_id1" onchange="get_subcat()" >
							<?
								include "connection.php";
								$sql = "SELECT * FROM productcategory";
								echo "<option value=''>All</option>";
								$result = mysql_query($sql);
								while($row=mysql_fetch_array($result)){
									echo "<option value='".$row['productcategoryid']."'>".$row['productcategoryname']."</option>";
								}
							?>
                         </select>
                     </li>
                    <li>
                     	  <select name="subcat_id" id="subcat_id1">
							<option value=''>All</option>
                           </select>
                     </li>
                     </ul>
                     </div><!-- popup-header-->
                     
                    <div class="filter">
                     <a href="#" onclick="product_filter()" >Filter</a>
                     </div>
					 
                    <div class="filter">
                     <a href="#" onclick="all_product()" >All</a>
                    </div> 
                     
                         		
 <div class="description" id="product_view1">
	<?php
	$sql = "SELECT * FROM productportfolio where active='1'";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		if($row['picture1']!='a' && $row['picture1']!='')
		{
			
			echo "<div class='left'><label><input type='checkbox' onclick=add_product('".$row['productid']."') /><img src='upload/".$row['picture1']."'><small>".$row['productlabel']."</small><i>".$row['productdescription']."</i></label></div>";
		}
		else
		{
			echo "<div class='left'><label><input type='checkbox' onclick=add_product('".$row['productid']."') /><img src='images/a.png'><small>".$row['productlabel']."</small><i>".$row['productdescription']."</i></label></div>";
			// echo "<div class='left'><input type='checkbox' /><img src='images/a.png'><small>".$row['productlabel']."</small><label>".$row['productdescription']."</label></div>";
		}
	}
	?>
	
</div>                        
</div><!--table closed-->
</div><!--main closed-->


<?php	
	include "footer.php";
	
?>
		<script>
		
var ul1 = false;
var ul2 = false;
var ul3 = false;
var ul4 = false;
var ul5 = false;
var add=0;
		
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

$("#button").click(function() {
	$( "#one" ).slideToggle(700);
});

$(document).ready(function(){
	loading();
	
	$("div.myTools").html('<label>Type</label><select><option value="global">Global</option><option value="personal">Personal</option></select>');
	
		var table=$('.datatable').dataTable();
		$('select#cust_grp').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 5, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$",5, true ); 
			}
		});
		// 
		
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
		$("div.myTools").html('<label>Customer Group</label><select id="cust_grp">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#cust_grp').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(),7, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$",7, true ); 
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
		$("div.myTools1").html('<label>Customer</label><select id="customers">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#customers').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 8, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 8, true ); 
			}
		});
		
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	
});

var product_index = new Array();
var obj = null;
var sup_obj = null;
var p_index = new Array();
var s_index = new Array();
var final_list = new Array();
var global_setting_checked = new Array();

function add_product(pid){
	var index = product_index.indexOf(pid);
	if(index==-1){
		product_index.push(pid);
		var subsi = new Array();
		var premi = new Array();
		var premiv = new Array();
		var pack = {
			id : pid,
			subs: subsi,
			prem:premi,
			premv:premiv,
			qty: 0
		}
		final_list.push(pack);
	}
	else{
		product_index.splice(index,1);
		final_list.splice(index,1);
	}
	var jsn = JSON.stringify(final_list);
	//alert(jsn);
	$("#pro_data").val(jsn);
}
function product_list()
{
	var str = "";
	
	for(i=0;i<product_index.length;i++)
	{
		var id = product_index[i];
		var index = p_index.indexOf(id);
		
		var detail = obj[index];			
		var substr = "<div class='substitute' ><p onclick=showt('subsi',"+i+")>Substitute Product</p><div class='drop_down' id='subsi"+i+"' style='display:none;'><ul><a class='another' href='#' onclick='show_pro_over("+i+")' >Add Product</a>";
		
		for(j=0;j<obj.length;j++){
			var pid = obj[j].productid;
			var idx = final_list[i].subs.indexOf(pid);
			
			if(idx!=-1){
				substr = substr + "<li><b>"+obj[j].productlabel+"</b></li>";
			}else{
				//substr = substr + "<li><b><input type='checkbox' onclick='subpro("+i+","+obj[j].productid+");' />"+obj[j].productlabel+"</b></li>";
			}
			
		}
		substr = substr + "</ul></div></div>";
		
		var supstr = "<div class='sup_settings' ><p onclick=showt('supl',"+i+") >Supplier Settings</p><div class='drop_down' id='supl"+i+"' style='display:none;'><ul>";
		
		for(k=0;k<sup_obj.length;k++){
			var pid = parseInt(sup_obj[k].supplierid);
			
			var idx = final_list[i].prem.indexOf(pid);
			if(idx!=-1)
			{
				var prvid=i+"prem"+sup_obj[k].supplierid;
				var supp_id=sup_obj[k].supplierid;
				var indexss = global_setting_checked.indexOf(supp_id);
				//alert(indexss);
				if(indexss!=-1)
				{
					var prvid=i+"prem"+sup_obj[k].supplierid;			
					var tol_value=$("#sup_id"+supp_id).val();			
					supstr = supstr + "<li><b><input type='checkbox' onclick='presup("+i+","+sup_obj[k].supplierid+")' checked/>"+sup_obj[k].businessname+"</b><i><input onchange=set_premv('"+prvid+"') id='"+i+"prem"+sup_obj[k].supplierid+"' type='number' value='"+tol_value+"' ></i></li>";
					
					presup(i,supp_id);
					set_premv(prvid);
					
				}
				else
				{
					supstr = supstr + "<li><b><input checked type='checkbox' onclick='presup("+i+","+sup_obj[k].supplierid+")'/>"+sup_obj[k].businessname+"</b><i><input onchange=set_premv('"+prvid+"') id='"+i+"prem"+sup_obj[k].supplierid+"' type='number' value='"+final_list[i].premv[idx]+"' ></i></li>";
				}
			}
			else
			{
				var supp_id=sup_obj[k].supplierid;
				var indexss = global_setting_checked.indexOf(supp_id);
				//alert(indexss);
				if(indexss!=-1)
				{
					var prvid=i+"prem"+sup_obj[k].supplierid;					
					var tol_value=$("#sup_id"+supp_id).val();					
					supstr = supstr + "<li><b><input type='checkbox' onclick='presup("+i+","+sup_obj[k].supplierid+")' checked/>"+sup_obj[k].businessname+"</b><i><input id='"+i+"prem"+sup_obj[k].supplierid+"' onchange=set_premv('"+prvid+"') type='number' value='"+tol_value+"' ></i></li>";					
					presup(i,supp_id);
					set_premv(prvid);
				}
				else
				{				
					var prvid=i+"prem"+sup_obj[k].supplierid;
					supstr = supstr + "<li><b><input type='checkbox' onclick='presup("+i+","+sup_obj[k].supplierid+")'/>"+sup_obj[k].businessname+"</b><i><input id='"+i+"prem"+sup_obj[k].supplierid+"' onchange=set_premv('"+prvid+"') type='number' value='0' ></i></li>";
				}
			}
		}
		supstr = supstr + "</ul></div></div>";
		
		str = str + "<div class=wrap_product'><div class='description1' style='height:auto !important'><div class='left '>"+substr+""+supstr+"<div class='left-a '><img src='upload/"+detail.picture1+"'><small>"+detail.productlabel+"</small><i>"+detail.productdescription+"</i></div><div class='right'><label>Qty</label><input id='pqty"+i+"' type='number' name='quantity' value='"+final_list[i].qty+"' class='qty' onchange='pro_qty("+i+")' /></div></div></div>";
		// str = str+substr+supstr;
		
	}
	$("#lis_div").html(str);
}
function load_list(){
	
}

function loading(){
	$.ajax({
		type: "GET",
		url: "get_product.php",
		data: {}
	})
	.done(function( msg ){
		//alert(msg);
		obj = JSON.parse(msg);
			
		for(i=0;i<obj.length;i++){
			var row = obj[i];			
			p_index.push(row.productid);
		}
	});
	$.ajax({
		type: "GET",
		url: "get_supplier.php",
		data: {}
	})
	.done(function( msg ){
		//alert(msg);
		sup_obj = JSON.parse(msg);
		for(i=0;i<sup_obj.length;i++){
			var row = sup_obj[i];
			s_index.push(row.supplierid);
			$('#uniform-supp_'+row.supplierid+' span').addClass('checked');
			$('#supp_'+row.supplierid+' :checkbox').prop("checked", true);
			supplier_name_checked(row.supplierid);
		}
	});
}

function subpro(index, id){
	//alert(index+"----"+id);
	var idx = final_list[index].subs.indexOf(id);
	if(idx==-1){
		final_list[index].subs.push(id);
	}else{
		final_list[index].subs.splice(idx,1);
	}
	var jsn = JSON.stringify(final_list);
	//alert(jsn);
	$("#pro_data").val(jsn);
}

function presup(index, id){
	//alert(index+"----"+id);
	
	var idx = final_list[index].prem.indexOf(id);
	if(idx==-1){
		var prvid = index+"prem"+id;
		final_list[index].prem.push(id);
		final_list[index].premv.push($("#"+prvid).val());
	}else{
		final_list[index].prem.splice(idx,1);
		final_list[index].premv.splice(idx,1);
	}
	var jsn = JSON.stringify(final_list);
	//alert(jsn);
	$("#pro_data").val(jsn);
}

function pro_qty(index){
	var va = $("#pqty"+index).val();
	final_list[index].qty = $("#pqty"+index).val();
	var jsn = JSON.stringify(final_list);
	//alert(jsn);
	$("#pro_data").val(jsn);
}

function prem_val(index){
	var va = $("#pqty"+index).val();
	final_list[index].qty = $("#pqty"+index).val();
	
	var jsn = JSON.stringify(final_list);
	//alert(jsn);
	$("#pro_data").val(jsn);
}

function save_profile(){
	var jsn = JSON.stringify(final_list);
	$("#pro_data").val(jsn);
}

function showt(pref, index){
	$("#"+pref+index).toggle();
}

function set_premv(id){
	var p = id.split("prem");
	var index = p[0];
	var i = parseInt(p[1]);
	var pindx = final_list[index].prem.indexOf(i);
	if(pindx!=-1){
		final_list[index].premv[pindx]= $("#"+id).val();
	}
}

function hide()
{					
	$("#myModal").hide();
	$(".fade").removeClass('in');
	$( ".modal-backdrop" ).remove();					
}

function product_edit(id)
{
	add=1;
	$("#add_edit").val(1);
	$(".modal-footer").hide();
	$("#update").show();
	$("#id_of_order").val(id);
					
	$("#myModal").show();
	$("#myModal").addClass('in');
					
	var $div = $('<div />').appendTo('body');
	$div.attr('class','modal-backdrop fade in');
	
		
	$.ajax({
		type: "GET",
		url: "get_profile.php",
		data: {d:id}
	})
	.done(function( msg ) {
		//alert(msg);
		final_list=[];
		product_index=[];
		var objt = JSON.parse(msg);
		$("#name").val(objt['head']['name']);
		$("#customergroup").val(objt['head']['customergroup']);
		var ord  = objt['orderdetails'];
		for(i=0;i<ord.length;i++)
		{
			var pid = ord[i]['id'];
			var qt = ord[i]['qty'];
			var subp = ord[i]['subs'];
			subp = subp.split(",");
			var subsi = new Array();
			for(j=0;j<subp.length;j++)
			{
				subsi.push(subp[j]);
			}
			var premi = new Array();
			var prems = ord[i]['prem'];
			prems = prems.split(",");
			for(j=0;j<prems.length;j++){
				premi.push(parseInt(prems[j]));
			}
			
			var premiv = new Array();
			var premvs = ord[i]['premv'];
			premvs = premvs.split(",");
			for(j=0;j<premvs.length;j++){
				premiv.push(premvs[j]);
			}
			//alert(pid+"&&"+subsi+"&&"+premi+"&&"+premiv+"&&"+qt);
			var Divpid="div"+pid;
			
			$('#'+Divpid+' span').addClass('checked');
			$('#'+Divpid+' :checkbox').prop("checked", true);
			
			var pack = {
				id : pid,
				subs: subsi,
				prem:premi,
				premv:premiv,
				qty: qt
			}
			final_list.push(pack);
			product_index.push(pid);
		}
		
		var jsn = JSON.stringify(final_list);
		$("#pro_data").val(jsn);
		
		$("#lis_div").html(' ');
		product_list();
	});
}

function add_new_function()
{	
	add=0;
	$("#add_edit").val(0);
	$("#all")[0].reset();
	$("#lis_div").html('');
	$(".modal-footer").show();
	$("#update").hide();
	final_list = [];
	product_index = [];
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
	var r = confirm("Are you sure you want to delete these entries ?");
	if (r == true) 
	{
		var str = JSON.stringify(checklistjson);
							//alert(str);
		$.ajax({
			type: "POST",
			url: "delete_check.php",
			data: {local:str, table:"orderprofile", column:"id"}
		})
		.done(function( msg ){
							
		});
		
		for(i=0;i<checklist.length;i++){
			$("#"+checklist[i]).hide();
		}
	}
}

function get_subcat(){
	var cid=$("#category_id").val();
	$.ajax({
		type: "GET",
		url: "get_subcat.php",
		data: {id:cid}
	})
	.done(function( msg ) {
		$("#subcat_id").html(msg);
	});
}

function product_filter(){
	var catid=$("#category_id").val();
	var subcatid=$("#subcat_id").val();
	var serch=$("#srch").val();
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
			var indx = product_index.indexOf(objt[i]['productid'])
			if(indx!=-1){
				str = str + "<div class='left'><input type='checkbox' checked onclick=add_product('"+objt[i]['productid']+"') /><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><label>"+objt[i]['productdescription']+"</label></div>";
			}else{
				str = str + "<div class='left'><input type='checkbox' onclick=add_product('"+objt[i]['productid']+"') /><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><label>"+objt[i]['productdescription']+"</label></div>";
			}
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
			var indx = product_index.indexOf(objt[i]['productid']);
			if(objt[i]['picture1']=='a' || objt[i]['picture1']=='')
			{
				objt[i]['picture1']='a.png';
			}
			
			if(indx!=-1){
				str = str + "<div class='left'><label><input type='checkbox' checked onclick=add_product('"+objt[i]['productid']+"') /><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><i>"+objt[i]['productdescription']+"</i></label></div>";
				
			}else{
				str = str + "<div class='left'><label><input type='checkbox' onclick=add_product('"+objt[i]['productid']+"') /><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><i>"+objt[i]['productdescription']+"</i></label></div>";
			}
		}
		$("#product_view").html(str);
	});
}

function show_pro_over(id){
	$('#overlay_box').show();
	$('#overlay_product1').show();
	var catid=$("#category_id1").val();
	var subcatid=$("#subcat_id1").val();
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
			var indx = final_list[id].subs.indexOf(objt[i]['productid']);
			if(indx!=-1){
				str = str + "<div class='left'><input type='checkbox' checked onclick=subpro("+id+",'"+objt[i]['productid']+"') /><img src='upload/"+obj[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><label>"+objt[i]['productdescription']+"</label></div>";
			}else{
				str = str + "<div class='left'><input type='checkbox' onclick=subpro("+id+",'"+objt[i]['productid']+"') /><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><label>"+objt[i]['productdescription']+"</label></div>";
			}
		}
		$("#product_view1").html(str);
	});
}
					$("#download_csv").on("click", function(e){
						download_csv_selected('orderprofile', checklist, 'order_prof', 'submit', 'id');
						// location.href="dba_export_csv.php?type=orderprofile&list="+checklist+"&page_name=order_prof&action=submit&type_nam=id";			
					});
					$("#download_csv_all").on("click", function(e){
						location.href="dba_export_csv.php?type=orderprofile&list=&page_name=order_prof&action=submit&type_nam=id";				
				});
				function show_customer()
				{
					var customer=$("#customergroup").val();
					
					$.ajax({
						type: "GET",
						url: "get_customer_fromgroup.php",
						data: {id:customer}
					})
					.done(function( msg ){
						$("#customerids").html(msg);
					});
					
				}
				function supplier_name_checked(id)
				{
					if(add==1)
					{
						var r = confirm("This will effect all the products. Are you sure you want to continue?");
						if (r == true) 
						{
						var index = global_setting_checked.indexOf(id);
						var value=$("#"+id).val();
						
						if(index==-1){
							var ide = 
							{
								key:id
							}
								global_setting_checked.push(id);
							}
							else
							{							
								global_setting_checked.splice(index,1);
							}
						}
						else
						{
							$("#supp_"+id).prop('checked',false);
						}
					}
				
					else
					{
						var index = global_setting_checked.indexOf(id);
						var value=$("#"+id).val();						
						if(index==-1){
							var ide = 
							{
								key:id
							}
								global_setting_checked.push(id);
							}
							else
							{							
								global_setting_checked.splice(index,1);
							}
						}
					
				}
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
				function change_name()
				{
					var name=$("#name").val();
					var person = prompt("Please change profile name", name);
					if(person != null && person != name)
					{
						$("#name").val(person);
						$( "form" ).submit();
					}
					else if(person == name)
					{
						alert("Profile name didn't change");
						$("form").submit(function(e){
						e.preventDefault();
						});
					}
					else
					{
						$("form").submit(function(e){
						e.preventDefault();
						});
						return false;
					}
				}
									</script>
