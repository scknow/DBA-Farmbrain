<?php	
include "connection.php";
session_start();

if(isset($_REQUEST['upload_csv'])){
	if (is_uploaded_file($_FILES['filename']['tmp_name']) && !empty($_FILES['filename']['tmp_name'])) {
		echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";		

		$emailval = '/([\w\-]+\@[\w\-]+\.[\w\-]+)/';
		$mob='/^\d+$/';
		
		$handle = fopen($_FILES['filename']['tmp_name'], "r");
		$hdata = fgetcsv($handle, 1000, ",");
		$header ="";
		foreach($hdata as $h)
		{
			if(trim($h)!="")
				$header .= trim($h) . ', ';
		}
		$header .= 'Error Description';
		$status = "true";
		$msg = "";
		$out="";
		$line_no=2;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			
			if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])==""))
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
				$out .= "Some field is missing at line - " . $line_no . ', ';
				$out .= "\n";
			}		
			else
			{
				$cutomer_id = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
				$supplierid = ltrim(substr(trim($data[1]),-6),'0'); //trim($data[1]);
				$business_name = trim($data[2]);
				$customer_id = ltrim(substr(trim($data[3]),-6),'0'); //trim($data[3]);
				$customerbusiness_name = trim($data[4]);
				$suppliersidecustomerid = trim($data[5]);
				$minordervalue = trim($data[6]);
				$ordertolerancevalue = trim($data[7]);
				
				if($cutomer_id == ''){
					$sql = "INSERT INTO suppliercustomer(supplierid, customerid, customerbusinessname,suppliersidecustomerid, minimumordervalue, ordertolerancevalue,approve) VALUES ('$supplierid', '$customer_id', '$business_name','$suppliersidecustomerid', '$minordervalue', '$ordertolerancevalue','0')";
				}else{
					$sql = "UPDATE suppliercustomer SET supplierid='$supplierid', customerid='$customerid', customerbusinessname='$customerbusinessname', suppliersidecustomerid='$suppliersidecustomerid', minimumordervalue='$minimumordervalue', ordertolerancevalue='$ordertolerancevalue', approve='0' WHERE rid='$cutomer_id' "; 
				}
				$result = mysql_query($sql);
				echo mysql_error();							
			}
		}
		
		if($out!="")
		{
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
		$sql = "SELECT * FROM customer WHERE customerid='$customerid' ";
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);
		$customerbusinessname = $row['businessname'];
		//echo $customerbusinessname;
		$suppliersidecustomerid = $_POST['suppliersidecustomerid'];
		$minimumordervalue = $_POST['minimumordervalue'];
		$ordertolerancevalue = $_POST['ordertolerancevalue'];
		if(!isset($_SESSION['supplierid'])){
			$supplierid = $_POST['supplierid'];
		}else{
			$supplierid = $_SESSION['supplierid'];
		}
		$approve = $_POST['approve'];
		//echo $customersid;
		$add_edit=$_POST['add_edit'];
		if($add_edit==0)
		{
			$sql = "INSERT INTO suppliercustomer(supplierid, customerid, customerbusinessname, salesuserid, salesfirstname, saleslastname, suppliersidecustomerid, minimumordervalue, ordertolerancevalue,approve) VALUES ('$supplierid', '$customerid', '$customerbusinessname', '', '', '', '$suppliersidecustomerid', '$minimumordervalue', '$ordertolerancevalue','$approve')"; 
			$result = mysql_query($sql);
			echo mysql_error();
			
		}else{
			$id=$_POST['field_id'];
			
			$sql = "UPDATE suppliercustomer SET supplierid='$supplierid', customerid='$customerid', customerbusinessname='$customerbusinessname', suppliersidecustomerid='$suppliersidecustomerid', minimumordervalue='$minimumordervalue', ordertolerancevalue='$ordertolerancevalue', approve='$approve' WHERE rid='$id' "; 
			$result = mysql_query($sql);
			echo mysql_error();
		}
		// unset($_POST);
		header('Location: ' . basename($_SERVER['PHP_SELF']));
	}
	include "header.php";
	include "menu.php";
?>
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
						<a href="#" class="active1">Customer Relation</a>
					</li>
				</ul>
			</div>
			<!-- end bread crum -->
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Supplier Customer Relationship</h2>
						<?php if(!isset($_SESSION['supplierid'])){
						?>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 113px;'><i class="icon-cog"></i> Add Relation</a>
						</div>
						<?}?>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th><input type="checkbox" onclick="check_all()"/></th>
								  <th>SC Id</th>
								  <th>Customer</th>
								   <?php if(!isset($_SESSION['supplierid']))
									{
									?>
									<th>Supplier</th>
									<?}?>
								 
								  <th>Supplier Cust Name</th>
								  <th>SUname</th>
								  <th>MOV</th>
								  <th>OTV</th>
								  <th>Approved</th>
								  <th style='display:none;'>sid</th>
								  <th style="display:none;">cid</th>
							  </tr>
						  </thead>   
						<tbody>
						  <?php
							include "connection.php";
							$sql="SELECT * FROM customer";
							//echo $sql;
							$result = mysql_query($sql);
							$cust = array();
							while ($row = mysql_fetch_array($result))
							{
								$cust[$row['customerid']] = $row['businessname'];
							}
							$sql="SELECT * FROM supplier";
							//echo $sql;
							$result = mysql_query($sql);
							$supp_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$supp_arr[$row['supplierid']] = $row['businessname'];
							}
							if(!isset($_SESSION['supplierid'])){
								$sql="SELECT * FROM suppliercustomer";
							}else{
								$supplierid = $_SESSION['supplierid'];
								$sql="SELECT * FROM suppliercustomer WHERE supplierid=".$supplierid;
							}
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								
								$id=$row['rid']."$$"."rid"."$$".'suppliercustomer';
								$line_id=$row['rid'];
								echo "<tr id='$line_id'>";
							
								echo "<td  class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['rid']."') name='check[]' value='".$row['rid']."'></td>";
								
								$max_id=str_pad($row['rid'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$id')>DBASC{$max_id}</a></td>";
								echo "<td>".$row['customerbusinessname']."</td>";
								if(!isset($_SESSION['supplierid']))
								{
								
								echo "<td>".$supp_arr[$row['supplierid']]."</td>";
								}
								
								//echo "<td>".$cust[$row['customerid']]."</td>";
								echo "<td>".$row['supplierid']."</td>";
								echo "<td>".$row['suppliersidecustomerid']."</td>";
								echo "<td>".$row['minimumordervalue']."</td>";
								echo "<td>".$row['ordertolerancevalue']."</td>";
								if($row['approve']){
									echo "<td>Yes</td>";
								}else{
									echo "<td id='ab".$id."' ><a href='#' class='btn btn-setting btn-info' onclick=approve_customer('".$id."') style='height: 19px;width: 100px;'><i class='icon-cog'></i>Approve</a></td>";
								}
								echo "<td style='display:none;'>{$row['supplierid']}</td>";
								echo "<td style='display:none;'>{$row['customerid']}</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					  </table>  
					  <div>
						<button onclick="deletentries()" style="margin-right:10px"><a href="#">Delete Selected</a></button>
						<button style="margin-right:10px" id="download_csv"><a href="#">Download Selected</a></button>
						<button style="margin-right:10px" id="download_csv_all"><a href="#">Download All</a></button>
						<button id='upload_csv_btn' style="margin-right:10px"><a href="#">Upload</a></button>
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
				<h3>Create Customer supplier relation </h3>
			</div>
			<div class="modal-body">
				<div class="box-content">
				<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
					
						<fieldset>
						<?
						if(!isset($_SESSION['supplierid'])){	
						?>
						<div class="control-group">
							<label class="control-label" for="inputError">Supplier</label>
							<div class="controls">
								<select id="supplierid" name="supplierid" onchange='get_mov_supplier()' required >
									   <?php
									   //id="customer id" multiple
										include "connection.php";
										$sql = "SELECT * FROM supplier";
										$result = mysql_query($sql);
										echo "<option value=''>Select</option>";
										while($row=mysql_fetch_array($result))
										{
											echo "<option value='".$row['supplierid']."'>".$row['businessname']."</option>";
										}
										?>
									</select>
							</div>
						</div>
						<?
						}
						?>
							<div class="control-group">
								<label class="control-label" for="product_attribute">Customer Id</label>
								<div class="controls">
									<select id="customerid"name="customerid" required >
									   <?php
									   //id="customer id" multiple
										include "connection.php";
										$sql = "SELECT * FROM customer";
										$result = mysql_query($sql);
										echo "<option value=''>Select</option>";
										while($row=mysql_fetch_array($result)){
											echo "<option value='".$row['customerid']."'>".$row['businessname']."</option>";
										}
										?>
									</select>
								</div>
							</div>

							<div class="control-group">
							<label class="control-label" for="inputError">Supplier Side ID</label>
							<div class="controls">
								<input type="text" id="suppliersidecustomerid" name="suppliersidecustomerid" /> 
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Minimum order value (in USD)</label>
							<div class="controls">
								<input id="minimumordervalue" type="text" name="minimumordervalue" onkeypress="return IsNumeric(event,'error8');" ondrop="return false;" onpaste="return false;" required/>	
								<span id="error8" style="color: Red; display: none">* Input digits (0 - 9)</span>
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Order Tolerance Value(in %)</label>
							<div class="controls">
								<input type="number" id="ordertolerancevalue" name="ordertolerancevalue" min="0" max="100" required />
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Approve</label>
							<div class="controls">
								<select type="number" id="approve" name="approve" required >
								<option value='1'>Yes</option>
								<option value='0'>No</option>
								</select>
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
					s=s+"<option value='"+res[i].businessname+"'>"+res[i].businessname+"</option>";
				}
			}
			<?}else{?>
				var s='<option value="">All</option>';
				for(i=0;i<res.length;i++)
				{
					s=s+"<option value='"+res[i].businessname+"'>"+res[i].businessname+"</option>";					
				}
			<?}?>
		
		$("div.myTools").html('<label>Supplier</label><select id="suppliers">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#suppliers').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 3, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 3, true ); 
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
			s=s+"<option value='"+res[i].businessname+"'>"+res[i].businessname+"</option>";
		}
		$("div.myTools1").html('<label>Customer</label><select id="customers">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#customers').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 2, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 2, true ); 
			}
		});
		
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	// $(".myTools1").css("position","absolute");$(".myTools1").css("left","480px");
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

function approve_customer(id)
{
	// alert("If you want to approve, please update the 'Minimum order value', 'Order Tolerance Value' and 'Approve status'");
	$("#ab"+id).html("Yes");
	product_edit(id);
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
		$("#field_id").val(obj['rid']);						
		$("#supplierid").val(obj['supplierid']);
		$("#customerid").val(obj['customerid']);
		$("#supplierid").prop('readonly',true);
		$("#customerid").prop('readonly',true);
		
		$("#suppliersidecustomerid").val(obj['suppliersidecustomerid']);
		$("#minimumordervalue").val(obj['minimumordervalue']);
		$("#ordertolerancevalue").val(obj['ordertolerancevalue']);
		$("#approve").val(obj['approve']);
		
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
	$("#supplierid").prop('disabled',false);
	$("#customerid").prop('disabled',false);
	$("#add_edit").val(0);
	$(".select1 .chzn-single span").html('select');
	$(".select2 .chzn-single span").html('select');
	$(".select3 .chzn-single span").html('select');
	$(".select4 .chzn-single span").html('select');
	$(".select5 .chzn-single span").html('select');
	$(".select6 .chzn-single span").html('select');
	$(".chzn-drop").css('display','block');
	$("#all")[0].reset();		
	$("#myModal").show();
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
		data: {local:str, table:"suppliercustomer", column:"rid"}
	})
	.done(function(msg){
	
	});
	
	for(i=0;i<checklist.length;i++){
		$("#"+checklist[i]).hide();
	}
}}
$("#download_csv").on("click", function(e){
	download_csv_selected('suppliercustomer',checklist,'supp_cust','submit','rid');
	// if(!check_record_selected(checklist)){
		// alert("Please select atleast one record to download.");
	// }else{
		// location.href="dba_export_csv.php?type=suppliercustomer&list="+checklist+"&page_name=supp_cust&action=submit&type_nam=rid";
	// }
});
$("#download_csv_all").on("click", function(e){
	location.href="dba_export_csv.php?type=suppliercustomer&list=&page_name=supp_cust&action=submit&type_nam=rid";			
});
$("#upload_csv_btn").on("click", function(e){
	$("#upload_hover").empty();
	$("#upload_hover").css("display","block");
	$("#upload_hover").load("relation_csv_upload.php");
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
function get_mov_supplier()
{
	var supplierid=$("#supplierid").val();
	$.ajax({
		type: "POST",
		url: "get_mov_otv.php",
		data: {supplierid:supplierid}
	})
	.done(function(msg)
	{
		var msgs=msg.split("&&");
		$("#minimumordervalue").val(msgs[0]);
		$("#ordertolerancevalue").val(msgs[1]);
	});
}
			</script>