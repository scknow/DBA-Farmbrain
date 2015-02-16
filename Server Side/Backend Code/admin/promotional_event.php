<?php	
include "connection.php";

if(isset($_REQUEST['upload_csv'])){
	if (is_uploaded_file($_FILES['filename']['tmp_name'])  && !empty($_FILES['filename']['tmp_name'])) {
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
			
			if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])==""))
			{
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
			else if((strtotime($data[2]) < $now)||(strtotime($data[3]) < strtotime($data[2])))
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
				$out .= "Event start Date can't be less than or equal to today's date OR end date can't be less than start date". ', ';
				$out .= "\n";
			}
			else
			{
				$evenId = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
				$eventname = trim($data[1]);
				$startdate = trim($data[2]);
				$enddate = trim($data[3]);
				$customergiveaway = trim($data[4]);
				$supplierchargeable = trim($data[5]);
				$maxquantity = trim($data[6]);
				if($dateto=='')
				{
					$dateto='9999-01-01';
				}
				$product_id = trim($data[7]);
				if($data[0]=='')
				{
					$sql = "INSERT INTO promotionalevent(eventname, startdate, enddate, customergiveaway, supplierchargeable, maxquantity) VALUES ('$eventname', '$startdate', '$enddate', '$customergiveaway', '$supplierchargeable', '$maxquantity')";	
					mysql_query($sql);
					
						$sql="SELECT MAX( eventid ) FROM promotionalevent";
						$result=mysql_query($sql);
						$temp=mysql_fetch_array($result);
						$max_id = $temp['MAX( eventid )'];
						
					$productid=explode("&",$product_id);
					for($i=0;$i<sizeof($productid);$i++)
					{
						$sql = "INSERT INTO 	promotionaleventdetail(eventid,productid)VALUES('$max_id','$productid[$i]')";
						$result=mysql_query($sql);
					}
				}
				else
				{
					$sql = "UPDATE promotionalevent set eventname='$eventname', startdate='$startdate', enddate='$enddate', customergiveaway='$customergiveaway', supplierchargeable='$supplierchargeable', maxquantity='$maxquantity' where eventid='$evenId'";
					
					mysql_query($sql);
					
					mysql_query("delete from promotionaleventdetail where eventid='$eventId'");
					
					$productid=explode("&",$product_id);
					for($i=0;$i<sizeof($productid);$i++)
					{
						$sql = "INSERT INTO promotionaleventdetail(eventid,productid)VALUES('$eventId','$productid[$i]')";
						$result=mysql_query($sql);
					}

				}
			}
		}
		if($out!=""){
			// echo "<script></script>";
			echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');alert('Uploaded but with some errors');</script>";
		}else{
			echo "<script>alert('Uploaded Successfully');</script>";
		}
		echo $msg;
		fclose($handle);
	}else{
		echo "<script>alert('Please choose a file to upload');</script>";
	}
	
}
else if(isset($_REQUEST['submit'])){
		$eventname = $_POST['eventname']; 
		$startdate = $_POST['startdate']; 
		$enddate = $_POST['enddate'];
		$customergiveaway = $_POST['customergiveaway'];
		$supplierchargeable = $_POST['supplierchargeable'];
		$maxquantity = $_POST['maxquantity'];
		
		$add_edit = $_POST['add_edit'];
		
		if($add_edit==0)
		{
			$sql = "INSERT INTO promotionalevent(eventname, startdate, enddate, customergiveaway, supplierchargeable, maxquantity) VALUES ('$eventname', '$startdate', '$enddate', '$customergiveaway', '$supplierchargeable', '$maxquantity')"; 
			$result = mysql_query($sql);
			
			$sql="SELECT MAX( eventid ) FROM promotionalevent";
			$result=mysql_query($sql);
			echo mysql_error();
			$temp=mysql_fetch_array($result);
			$max_id = $temp['MAX( eventid )'];
			$productid = explode(",",$_POST['productid']);
			
			for($i=0;$i<sizeof($productid);$i++)
			{
				$sql = "INSERT INTO promotionaleventdetail(eventid,productid)VALUES('$max_id','$productid[$i]')";
				$result=mysql_query($sql);
			}
		}
		else
		{
			$e_id = $_POST['field_id'];
			$sql = "update promotionalevent set eventname='$eventname', startdate='$startdate', enddate='$enddate', customergiveaway='$customergiveaway', supplierchargeable='$supplierchargeable', maxquantity='$maxquantity' where eventid='$e_id'"; 
			$result = mysql_query($sql);
		
			$max_id = $e_id;
			$productid = explode(",",$_POST['productid']);
			mysql_query("delete from promotionaleventdetail where eventid='$max_id'");
			for($i=0;$i<sizeof($productid);$i++)
			{
				$sql = "INSERT INTO promotionaleventdetail(eventid,productid)VALUES('$max_id','$productid[$i]')";
				$result=mysql_query($sql);
			}
		}
		header('Location: ' . basename($_SERVER['PHP_SELF']));
	}
	include "header.php";
	include "menu.php";
?>
	<link href='css/css.css' rel='stylesheet'>
	<link href='css/own.css' rel='stylesheet'>			
			<!-- left menu ends -->
		<div id='upload_hover'></div>
		<div id="content" class="span10">	
			<!-- bread crum -->
			<div class='bread'>
				<ul class="breadcrumb">
					<li class="step">
						<a href="index.php">Home</a>
					</li>
					<li class="step">
						<a href="#">Events</a>
					</li>
					<li class="step">
						<a href="#" class="active1">Events</a>
					</li>
				</ul>
			</div>
			<!-- end bread crum -->
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Events</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 113px;'><i class="icon-cog"></i> Add Event</a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th><input type="checkbox" onclick="check_all()"/></th>
								  <th>Id</th>
								  <th>Name</th>
								  <th>Start Date</th>
								  <th>End Date</th>
								  <th>Demo Support $</th>
								  <th>Demo Support Qty</th>
								  <th>Manufacturer</th>
								  <th style='display:none;'>mid</th>
							  </tr>
						  </thead>   
						<tbody id="test_datatable">
						  <?php
							include "connection.php";
							$sql="SELECT manufid, manufname FROM manufacturer";
							$result = mysql_query($sql);
							$pro_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$manu_arr[$row['manufid']] = $row['manufname'];
							}
							$sql="SELECT * FROM promotionalevent";
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['eventid']."$$"."eventid"."$$".'promotionalevent';
								$line_id=$row['eventid'];
								echo "<tr id='$line_id'>";
								
								echo "<td  class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['eventid']."') name='check[]' value='".$row['eventid']."'></td>";
								
								$max_id=str_pad($row['eventid'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$id')>DBAEM{$max_id}</a></td>";
								echo "<td>{$row['eventname']}</td>";
								echo "<td>".$row['startdate']."</td>";
								echo "<td>{$row['enddate']}</td>";
								echo "<td>".$row['customergiveaway']."</td>";
								echo "<td>".$row['maxquantity']."</td>";
								echo "<td>".$manu_arr[$row['supplierchargeable']]."</td>";
								echo "<td style='display:none;'>{$row['supplierchargeable']}</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					  </table>  
					  <div>
						<button onclick="deletentries()" style="margin-right:10px"><a href="#">Delete Selected</a></button>
						<button style="margin-right:10px" id="download_csv"><a href="#">Download Selected</a></button>
						<button style="margin-right:10px" id="download_csv_all"><a href="#">Download All</a></button>
						<button id="upload_csv_btn" style="margin-right:10px"><!--<a href="promotional_event_csv.php">--><a href='#'>Upload</a></button>
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
				<h3>Manage Event</h3>
			</div>
			<div class="modal-body">
				<div class="box-content">
				<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
					
						<fieldset>
							<div class="control-group">
							<label class="control-label" for="inputError"> Event Name</label>
							<div class="controls">
								<input type="text" name="eventname" id='ename' required />  
							</div>
							</div>	
							
							
							<div class="control-group">
							<label class="control-label" for="inputError">Start Date</label>
							<div class="controls">
								<input type="text" name="startdate" id="startdate" required />
							</div>
							</div>

							<div class="control-group">
							<label class="control-label" for="inputError">End Date</label>
							<div class="controls">
								<input type="text" name="enddate" id="enddate" required />
							</div>
							</div>
							
							
							
							<div class="control-group">
							<label class="control-label" for="inputError">Demo Support $</label>
							<div class="controls">
																
								<input id="customergiveaway" type="text" name="customergiveaway" onkeypress="return IsNumeric(event,'error2');" ondrop="return false;" onpaste="return false;" required/>	
								<span id="error2" style="color: Red; display: none">* Input digits (0 - 9)</span> 
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Demo Support Qty</label>
							<div class="controls">
								<input id="maxquantity" type="text" name="maxquantity" onkeypress="return IsNumeric(event,'error3');" ondrop="return false;" onpaste="return false;" required/>	
								<span id="error3" style="color: Red; display: none">* Input digits (0 - 9)</span> 
								 
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Manufacturer</label>
							<div class="controls">
								<!--<input type="text" name="supplierchargeable" required />-->
								<select name="supplierchargeable" id="supplierchargeable" required >
                           
								</select>
							</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="product_attribute">Select Products</label>
								<div class="controls">
									<!-- <input id="state"  onclick="cusch()" required />-->
									<div id="state" onclick="cusch()" class="products-selection">
									
									</div>
									<div id="stdprdt"></div>
								</div>
							</div>

							<div class="control-group" style="display:none" >
							<label class="control-label" for="inputError">Maximum Qty</label>
							<div class="controls">
								
								<input id="abc" type="text" name="productid" onkeypress="return IsNumeric(event,'error4');" ondrop="return false;" onpaste="return false;"  required/>	
									<span id="error4" style="color: Red; display: none">* Input digits (0 - 9)</span>								
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

<div style="width:70%;" class="header header-pop">
<p>SELECT A PRODUCT</p>
<div style="text-align:center;" class="back">
<a href="#" onclick="$('#overlay_box').hide();$('#overlay_product').hide(); return false;">Cancel</a>
</div><!--back closed-->
<div style="text-align:center;" class="done">
			<a href="#" onclick="$('#overlay_box').hide();$('#overlay_product').hide(); product_list(); return false;" >Done</a>
			</div><!--done closed-->
			</div><!--content closed-->

<div class="header-copy"></div>

<!-------header finish-------->




<div style="width: 70%;opacity: 1;" class="main">
                   <div class="popup">
                    <ul>
                    <li>
					<label>Category</label>
					<select name="category" id="category_id" onchange="get_subcat()" >
							<?
								include "connection.php";
								$sql = "SELECT * FROM productcategory";
								echo "<option value='-1'>Select</option>";
								$result = mysql_query($sql);
								while($row=mysql_fetch_array($result)){
									echo "<option value='".$row['productcategoryid']."'>".$row['productcategoryname']."</option>";
								}
							?>
                         </select>
                     </li>
                    <li><label>Sub Category</label>
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
var time=0;
var checked_all_prod=0;
var product_index = new Array();
var product_label = new Array();
$(document).ready(function(){
	$( "#node_ul" ).show();
	$( "#i4" ).html('-');
	ul4 = true;
	all_product();

	$.ajax({
		type: "POST",
		url: "get_manufact_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
			s=s+"<option value='"+res[i].manufid+"'>"+res[i].manufname+"</option>";
		}
		$("div.myTools").html('<label>Manufacturer</label><select id="manufacts">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#manufacts').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 8, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 8, true ); 
			}
		});
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	
	var table=$('.datatable').dataTable();
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
					url: "date_range_pevent.php",
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
					url: "date_range_pevent.php",
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
			std = $("#startD").val();
			end = $("#EndD").val();
			if(((std!='')||(end!=''))&&time==1)
			{
				$.ajax({
					type: "POST",
					url: "date_range_pevent.php",
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
					url: "date_range_pevent.php",
					data: {sd:std, ed:end}
				})
				.done(function( msg ){
					$("#test_datatable").html(msg);
				});
			}
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
					
					$("#myModal").show();
					$("#myModal").addClass('in');
					
					var $div = $('<div />').appendTo('body');
					$div.attr('class','modal-backdrop fade in');
					
					edit_new_function();
					
					$.ajax({
						type: "GET",
						url: "edit.php",
						data: {d:id}
					})
					.done(function( msg ) {
						//alert(msg);
						obj = JSON.parse(msg);						
						$("#field_id").val(obj['eventid']);
						$("#ename").val(obj['eventname']);
						$("#startdate").val(obj['startdate']);
						$("#enddate").val(obj['enddate']);
						$("#customergiveaway").val(obj['customergiveaway']);
						$("#maxquantity").val(obj['maxquantity']);
						$("#supplierchargeable").val(obj['supplierchargeable']);
						get_prev_product(obj['eventid']);
						all_product();
						$("#supplierchargeable").prop('disabled',true);
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
					$("#all")[0].reset();
					$("#supplierchargeable").prop('disabled',false);
					$.ajax({
						type: "POST",
						url: "get_manufact_list.php",
						data: {action:'authenticated'}
					})
					.done(function( msg ){
						// alert(msg);
						res = JSON.parse(msg);
						// console.log(res[0].productcategoryid);
						var s='<option value="-1">All</option>';
						for(i=0;i<res.length;i++){
							s=s+"<option value='"+res[i].manufid+"'>"+res[i].manufname+"</option>";
						}
						$("#supplierchargeable").html(s);
						$('#startdate').datepicker({ 
							dateFormat: 'yy-mm-dd', 
							beforeShow : function(){
								$( this ).datepicker('option','maxDate', $('#enddate').val() );
							}
						});
						$('#enddate').datepicker({ 
							dateFormat: 'yy-mm-dd',
							beforeShow : function(){
								$( this ).datepicker('option','minDate', $('#startdate').val() );
							}
						});
					});
					product_index = [];		
					product_label = [];		
					$("#stdprdt").html('');
					$("#add_edit").val(0);
					$(".select1 .chzn-single span").html('select');
					$(".select2 .chzn-single span").html('select');
					$(".select3 .chzn-single span").html('select');
					$(".select4 .chzn-single span").html('select');
					$(".select5 .chzn-single span").html('select');
					$(".select6 .chzn-single span").html('select');
					$(".chzn-drop").css('display','block');
					
									
				}
				
				function edit_new_function()
				{	
					$.ajax({
						type: "POST",
						url: "get_manufact_list.php",
						data: {action:'authenticated'}
					})
					.done(function( msg ){
						// alert(msg);
						res = JSON.parse(msg);
						var s='<option value="">All</option>';
						for(i=0;i<res.length;i++){
							s=s+"<option value='"+res[i].manufid+"'>"+res[i].manufname+"</option>";
						}
						$("#supplierchargeable").html(s);
						$('#startdate').datepicker({ 
							dateFormat: 'yy-mm-dd', 
							beforeShow : function(){
								$( this ).datepicker('option','maxDate', $('#enddate').val() );
							}
						});
						$('#enddate').datepicker({ 
							dateFormat: 'yy-mm-dd',
							beforeShow : function(){
								$( this ).datepicker('option','minDate', $('#startdate').val() );
							}
						});
					});
					$(".select1 .chzn-single span").html('select');
					$(".select2 .chzn-single span").html('select');
					$(".select3 .chzn-single span").html('select');
					$(".select4 .chzn-single span").html('select');
					$(".select5 .chzn-single span").html('select');
					$(".select6 .chzn-single span").html('select');
					$(".chzn-drop").css('display','block');
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
							data: {local:str, table:"promotionalevent", column:"eventid"}
						})
						.done(function( msg ){
						//	alert(msg);
							
						});
						
						for(i=0;i<checklist.length;i++){
							$("#"+checklist[i]).hide();
						}
					}}
					
					function cusch()
					{
						$('#overlay_box').show(); 
						$('#overlay_product').show();					
						all_product();
					}
					
				function product_list()
				{
					$("#abc").val(product_index);
					$("#stdprdt").val(product_label);
					//alert(product_label);
				}					
function add_product(pid,label)
{
	label = label.replace("%%%%", " ");
	label=label.trim().replace(/%%%%/g, ' ');
	var indx = product_label.indexOf(label);
	var index = product_index.indexOf(pid);
	if(index==-1){
		product_index.push(pid);
	}
	else{
		product_index.splice(index,1);
	}
	if(indx==-1){
		product_label.push(label);
	}
	else{
		product_label.splice(indx,1);
	}
	var str = "";
	for(i=0;i<product_label.length;i++){
		if(i==0){
			str = product_label[i];
		}else{
			str = str+", "+product_label[i];
		}
	}
	
	$("#stdprdt").html(str);
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
		var str1="<div class='left' style='height:45px;'><label><div class='checker' id='uniform-undefined'><span><input type='checkbox' class='all_c' onclick='add_product_all()' /></span></div><small>Select all</small><i></i></label></div>";
		for(i=0;i<objt.length;i++){
			var lbl = objt[i]['productlabel'];
			var manufact_id=$("#supplierchargeable").val();
			var product_manufact = objt[i]['productmanufacturer'];
			if(objt[i]['picture1']=='a' || objt[i]['picture1']=='')
			{
				objt[i]['picture1']='a.png';
			}
			if(manufact_id=='-1' ||manufact_id==product_manufact || manufact_id=='')
			{
				if(manufact_id==-1 || manufact_id=='')
				{
					$(".all_c").attr('checked',true);
				}
			lbl = lbl.replace(/\s+/g, '%%%%');
			var indx = product_index.indexOf(objt[i]['productid'])
				if(indx!=-1)
				{
					str = str + "<div class='left'><label><div class='checker' id='uniform-undefined'><span><input type='checkbox' checked value='"+objt[i]['productid']+"&&"+lbl+"' class='product_check' onclick=add_product('"+objt[i]['productid']+"','"+lbl+"') /></span></div><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><i>"+objt[i]['productdescription']+"</i></label></div>";
				}
				else
				{
					str = str + "<div class='left'><label><div class='checker' id='uniform-undefined'><span><input type='checkbox' value='"+objt[i]['productid']+"&&"+lbl+"' class='product_check' onclick=add_product('"+objt[i]['productid']+"','"+lbl+"') /></span></div><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><i>"+objt[i]['productdescription']+"</i></label></div>";
				}
			}
			
		}
		
		if(str=='')
			{
				str = str + "<div><label> No product for this Sponser </label></div>";
			}
		else
		{
			str=str1+str;
		}
		$("#product_view").html(str);
	});
}

function all_product()
{
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
		var str1="<div class='left' style='height:45px;'><label><div class='checker' id='uniform-undefined'><span><input type='checkbox' class='all_c' onclick='add_product_all()' /></span></div><small>Select all</small><i></i></label></div>";
		
		for(i=0;i<objt.length;i++){
			
			var lbl = objt[i]['productlabel'];			
			lbl = lbl.replace(/\s+/g, '%%%%');;
			var manufact_id=$("#supplierchargeable").val();
			var product_manufact = objt[i]['productmanufacturer'];
			if(objt[i]['picture1']=='a' || objt[i]['picture1']=='')
			{
				objt[i]['picture1']='a.png';
			}
			//alert(objt[i]['picture1']);
			if(manufact_id=='-1' ||manufact_id==product_manufact || manufact_id=='')
			{
				if(manufact_id==-1 || manufact_id=='')
				{
					$(".all").attr('checked',true);
				}
				var indx = product_index.indexOf(objt[i]['productid'])
				if(indx!=-1)
				{
					str = str + "<div class='left'><label><div class='checker' id='uniform-undefined'><span><input type='checkbox' checked value='"+objt[i]['productid']+"&&"+lbl+"' class='product_check' onclick=add_product('"+objt[i]['productid']+"','"+lbl+"') /></span></div><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><i>"+objt[i]['productdescription']+"</i></label></div>";
					
				}else{
					str = str + "<div class='left'><label><div class='checker' id='uniform-undefined'><span><input type='checkbox' value='"+objt[i]['productid']+"&&"+lbl+"' class='product_check' onclick=add_product('"+objt[i]['productid']+"','"+lbl+"') /></span></div><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><i>"+objt[i]['productdescription']+"</i></label></div>";
				}
			}
		}
		
		if(str=='')
			{
				str = str + "<div><label> No product for this Sponser </label></div>";
			}
		else
		{
			str=str1+str;
		}
		$("#product_view").html(str);
	});
}

function get_prev_product(id)
{
	product_index=[];
	product_label=[];
	
	$.ajax({
		type: "GET",
		url: "product_filter1.php",
		data: {cat:"", sub:"",event_id:id}
	})
	.done(function( msg ) {
		
		var objt = JSON.parse(msg);
		var str = "";
		for(i=0;i<objt.length;i++)
		{
			var lbl = objt[i]['productlabel'];
			product_index.push(objt[i]['productid']);			
			product_label.push(objt[i]['productlabel']);
		}
		for(i=0;i<product_label.length;i++){
		if(i==0){
			str = product_label[i];
		}else{
			str = str+", "+product_label[i];
		}
		}	
		$("#state").val(str);
		$("#stdprdt").html(str);
		$("#abc").val(product_index);
	});
}

					$("#download_csv").on("click", function(e){
						download_csv_selected('promotionalevent', checklist, 'promotional_event', 'submit', 'eventid');
						// location.href="dba_export_csv.php?type=promotionalevent&list="+checklist+"&page_name=promotional_event&action=submit&type_nam=eventid";			
					});
					$("#download_csv_all").on("click", function(e){
						location.href="dba_export_csv.php?type=promotionalevent&list=&page_name=promotional_event&action=submit&type_nam=eventid";
					});
					$("#upload_csv_btn").on("click", function(e){
						$("#upload_hover").empty();
						$("#upload_hover").css("display","block");
						$("#upload_hover").load("promotional_event_csv.php");
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
					function add_product_all()
					{
						if(checked_all_prod==0)
						{
						$(".product_check").attr('checked',true);
						var checkedValues = $('#product_view input:checkbox:checked').map(function() {
							return this.value;
						}).get();
						
						product_label=[];
						product_index=[];
							for(var i=1;i<checkedValues.length;i++)
							{
								var pid_lbl_arr=checkedValues[i].split("&&");
								var label=pid_lbl_arr[1];
								var pid=pid_lbl_arr[0];
								label = label.replace("%%%%", " ");
								label=label.trim().replace(/%%%%/g, ' ');
								
								var indx = product_label.indexOf(label);
								var index = product_index.indexOf(pid);
								if(index==-1){
									product_index.push(pid);
								}
								else
								{
									product_index.splice(index,1);
								}
								if(indx==-1){
									product_label.push(label);
								}
								else
								{
									product_label.splice(indx,1);
								}
								
							
							}
							checked_all_prod=1;
						}
						else
						{
							$(".product_check").attr('checked',false);
							product_label=[];
							product_index=[];
							checked_all_prod=0;
						}
						var str = "";
						for(i=0;i<product_label.length;i++)
						{
							if(i==0)
							{
								str = product_label[i];
							}else
							{
								str = str+", "+product_label[i];
							}
						}
						
						$("#stdprdt").html(str);
					
					}
			</script>
			<style>
			.myTools1, .myTools5, .myTools4{ display:none;}
			input{ opacity:1 !important}
			</style>