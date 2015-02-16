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
			
			if ((trim($data[1])=="")||(trim($data[2])=="")||(trim($data[3])=="")||(trim($data[4])=="")||(trim($data[5])=="")||(trim($data[6])=="")||(trim($data[7])=="")||(trim($data[8])=="")||(trim($data[9])==""))
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
				
				$out .= "Some field is missing at line - " . $line_no . ', ';
				$out .= "\n";
			}	
			else if((strtotime($data[4]) < $now)||(strtotime($data[5])<(strtotime($data[4]))))	
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
				$out .=', ';
				$out .= "Date from can't be less than or equal to today's date or  Date to can't be less than date from". ', ';
				$out .= "\n";
			}
			else
			{
				$promotion_id = ltrim(substr(trim($data[0]),-6),'0'); //trim($data[0]);
				$productid = ltrim(substr(trim($data[1]),-6),'0'); //trim($data[1]);
				$supplierid = ltrim(substr(trim($data[2]),-6),'0'); //trim($data[2]);
				$type = trim($data[3]);
				$datefrom = trim($data[4]);
				$dateto = trim($data[5]);
				$minordervalue = trim($data[6]);
				$percentageoff = trim($data[7]);
				$valueoff = trim($data[8]);
				$promotionText = trim($data[9]);
				
				if($dateto=='')
				{
					$dateto='9999-01-01';
				}
				if($promotion_id == ''){
					$sql = "INSERT INTO promotion(productid, supplierid, type, datefrom, dateto, minimumorderquantity, percentageoff, valueoff, promotiontext) VALUES ( '$productid', '$supplierid', '$type', '$datefrom', '$dateto', '$minordervalue', '$percentageoff', '$valueoff', '$promotiontext')"; 			
					mysql_query($sql);
					
						$sql = "SELECT * FROM promotion WHERE supplierid='$supplier_id' AND productid='$productid' AND datefrom<'$datefrom' AND dateto>'$datefrom'";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result)){
							$sql1 = "UPDATE promotion SET dateto='$datefrom' WHERE promotionid=".$row['promotionid'];
							mysql_query($sql1);
						}
				}else{
					$sql = "update promotion set productid=$productid, supplierid=$supplierid, type=$type, datefrom=$datefrom, dateto=$dateto, minimumorderquantity=$minimumorderquantity, percentageoff=$percentageoff, valueoff=$valueoff, promotiontext=$promotionText where promotionid=$promotion_id"; //  VALUES ( '$productid', '$supplierid', '$type', '$datefrom', '$dateto', '$minordervalue', '$percentageoff', '$valueoff', '$promotiontext')"; 			
					mysql_query($sql);
				}
			}
		}
		if($out!=""){
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
		$productid = $_POST['productid']; 
		if(!isset($_SESSION['supplierid'])){
			$supplierid = $_POST['supplierid'];
		}else{
			$supplierid = $_SESSION['supplierid'];
		}
		$type = $_POST['type'];
		$datefrom = $_POST['datefrom'];
		$dateto = $_POST['dateto'];
		$minimumorderquantity = $_POST['minimumorderquantity'];
		$percentageoff = $_POST['percentageoff'];
		$valueoff = $_POST['valueoff'];
		$promotiontext = $_POST['promotiontext'];
		$add_edit=$_POST['add_edit'];
		if($add_edit==0){
			$sql = "INSERT INTO promotion(productid, supplierid, type, datefrom, dateto, minimumorderquantity, percentageoff, valueoff, promotiontext) VALUES ( '$productid', '$supplierid', '$type', '$datefrom', '$dateto', '$minimumorderquantity', '$percentageoff', '$valueoff', '$promotiontext')"; 
			
			$result = mysql_query($sql);
		}else{
			$id=$_POST['field_id'];
			
			$sql = "UPDATE promotion SET productid='$productid', supplierid='$supplierid', type='$type', datefrom='$datefrom', dateto='$dateto', minimumorderquantity='$minimumorderquantity', percentageoff='$percentageoff', valueoff='$valueoff', promotiontext='$promotiontext' WHERE promotionid=$id ";
			
			$result = mysql_query($sql);
			echo mysql_error();
		}
		header('Location: ' . basename($_SERVER['PHP_SELF']));
	}
	include "header.php";
	include "menu.php";
?>
		
	<link href='css/css.css' rel='stylesheet'>
	<link href='css/own.css' rel='stylesheet'>	
	<div id='upload_hover'></div>
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
						<a href="#" class="active1">Promotions</a>
					</li>
				</ul>
			</div>
			<!-- end bread crum -->
			
<div class="row-fluid sortable">		
	<div class="box span12">
		<div class="box-header well" data-original-title>
			<h2><i class="icon-user"></i>Promotions</h2>
			<div class="box-icon">
				<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 130px;'><i class="icon-cog"></i> Add Promotion</a>
			</div>
		</div>
		<div class="box-content">
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
				<thead>
					<tr>
						<th><input type="checkbox" onclick="check_all()"/></th>
						<th>Id</th>
						<th>Product</th>
						
						<th>Supplier</th>
						<th>Type</th>
						<th>Date from</th>
						<th>Date to</th>
						<th>Minimum Quantity</th>
						<th>Percentage off</th>
						<th>Value off</th>
						<th>Promotion Text</th>
						<th style='display:none;'>sid</th>
						<th style='display:none;'>pid</th>
					</tr>
				</thead>   
						 
						<tbody id="test_datatable">
						  <?php
							include "connection.php";
							$sql="SELECT supplierid, businessname FROM supplier";
							$result = mysql_query($sql);
							$sup_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$sup_arr[$row['supplierid']] = $row['businessname'];
							}
							$sql="SELECT productid, productlabel FROM productportfolio";
							$result = mysql_query($sql);
							$pro_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$pro_arr[$row['productid']] = $row['productlabel'];
							}
							if(!isset($_SESSION['supplierid'])){
								$sql="SELECT * FROM promotion";
							}else{
								$supplierid = $_SESSION['supplierid'];
								$sql="SELECT * FROM promotion WHERE supplierid=".$supplierid;
							}
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['promotionid']."$$"."promotionid"."$$".'promotion';
								$line_id=$row['promotionid'];
								echo "<tr id='$line_id'>";
								
								echo "<td  class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['promotionid']."') name='check[]' value='".$row['promotionid']."'></td>";
									
								$max_id=str_pad($row['promotionid'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$id')>DBAES{$max_id}</a></td>";
								echo "<td>{$pro_arr[$row['productid']]}</td>";
								echo "<td>".$sup_arr[$row['supplierid']]."</td>";
								echo "<td>{$row['type']}</td>";
								echo "<td>".$row['datefrom']."</td>";
								echo "<td>".$row['dateto']."</td>";
								echo "<td>".$row['minimumorderquantity']."</td>";
								echo "<td>".$row['percentageoff']."</td>";
								echo "<td>".$row['valueoff']."</td>";
								echo "<td>".$row['promotiontext']."</td>";
								echo "<td style='display:none;'>{$row['supplierid']}</td>";
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
				<h3>Promotion Event</h3>
			</div>
			<div class="modal-body">
				<div class="box-content">
				<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
						<fieldset>
							<div class="control-group" style="display:none">
							<label class="control-label" for="inputError">Product</label>
							<div class="controls">
								<input type="text" name="productid" id="productid" required /> 
									  
							</div>
							</div>	
							<div class="control-group">
							<label class="control-label" for="inputError">Product</label>
							<div class="controls">
								<input type="text" name="productidl" id="productidl" onclick="$('#overlay_box').show(); $('#overlay_product').show();" required /> 
									  
							</div>
							</div>	
							<?
							if(!isset($_SESSION['supplierid'])){
							?>
							<div class="control-group">
							<label class="control-label" for="inputError">Supplier</label>
							<div class="controls">
								<select name="supplierid" id="supplierid" required > 
									<?
									include "connection.php";
									$sql = "SELECT * FROM supplier where active='1'";
									echo "<option value=''>Select</option>";
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
							<div class="control-group">
							<label class="control-label" for="inputError">Type</label>
							<div class="controls">
								<select name="type" id="type" required > 
									<option value=''>Select</option>
									<option>OFFINVOICE</option>
									<option>REBATE</option>
								</select>
							</div>
							</div>

							<div class="control-group">
							<label class="control-label" for="inputError">Date from</label>
							<div class="controls">
								<input type="text" name="datefrom" id="datefrom" required />
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Date to</label>
							<div class="controls">
								<input type="text" name="dateto" id="dateto" required />
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Minimum Order Quantity</label>
							<div class="controls">
								<input id="minimumorderquantity" type="text" name="minimumorderquantity" onkeypress="return IsNumeric(event,'error1');" ondrop="return false;" onpaste="return false;" required/>	
								<span id="error1" style="color: Red; display: none">* Input digits (0 - 9)</span> 
								
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Percentage off</label>
							<div class="controls">
								<input id="percentageoff" type="text" name="percentageoff" onkeypress="return IsNumeric(event,'error1');" ondrop="return false;" onpaste="return false;" onkeyup="setoff('valueoff')" required/>	
								<span id="error1" style="color: Red; display: none">* Input digits (0 - 9)</span> 
							</div>
							</div>
							
							<div class="control-group">
							<label class="control-label" for="inputError">Value off</label>
							<div class="controls">
								<input id="valueoff" type="text" name="valueoff" onkeypress="return IsNumeric(event,'error2');" ondrop="return false;" onpaste="return false;" onkeyup="setoff('percentageoff')" required/>	
								<span id="error2" style="color: Red; display: none">* Input digits (0 - 9)</span> 
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
                    <li><label>Category</label>
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
var time = 0;

$(document).ready(function(){
	$( "#supplier_ul" ).show();
	$( "#i3" ).html('-');
	ul1 = true;
	all_product();
	
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
		
		$("div.myTools").html('<label>Supplier</label><select id="suppliers">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#suppliers').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 11, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 11, true ); 
			}
		});
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	/* $.ajax({
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
		$("div.myTools1").html('<label>Product</label><select id="products">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#products').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 12, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 12, true ); 
			}
		});
		
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	 */
	// $(".myTools1").css("position","absolute");$(".myTools1").css("left","480px");
	
		var s='<option value="">All</option><option value="OFFINVOICE">Offinvoice</option><option value="REBATE">Rebate</option>';
		// for(i=0;i<res.length;i++){
			// s=s+"<option value='"+res[i].supplierid+"'>"+res[i].businessname+"</option>";
		// }
		$("div.myTools4").html('<label>Type</label><select id="types">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#types').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 4, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 4, true ); 
			}
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
					url: "date_range_promotion.php",
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
					url: "date_range_promotion.php",
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
					url: "date_range_promotion.php",
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
					url: "date_range_promotion.php",
					data: {sd:std, ed:end}
				})
				.done(function( msg ){
					$("#test_datatable").html(msg);
				});
			}
		
		});
	// $(".myTools3").css("position","relative");$(".myTools3").css("left","459px");$(".myTools3").css("width","220px");
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
					var r = confirm("Are you sure you want to delete these entries ?");
					if (r == true) 
					{
						var str = JSON.stringify(checklistjson);
						//alert(str);
						$.ajax({
							type: "POST",
							url: "delete_check.php",
							data: {local:str, table:"promotion", column:"promotionid"}
						})
						.done(function( msg ){
						//	alert(msg);
							
						});
						
						for(i=0;i<checklist.length;i++){
							$("#"+checklist[i]).hide();
						}
					}}
					function cusch(){
						var abc = $("#state").val();
						$("#abc").val(abc);
					}
					
					function setoff(id){
						$("#"+id).val(0);
					}
					
					$(function() {
						var date = new Date();
						var today = date.getDate();
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
				label=label.trim().replace(/ /g, '&&&');
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
		for(i=0;i<objt.length;i++)
		{
				var label = objt[i]['productlabel'].replace(' ', '&&&');
				label=label.trim().replace(/ /g, '&&&');
				str = str + "<div class='left'><input type='button' onclick=add_product("+objt[i]['productid']+",'"+label+"') value='select' /><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><label>"+objt[i]['productdescription']+"</label></div>";
		}
		$("#product_view").html(str);
	});
}
function add_product(id,label){
	$('#overlay_box').hide();
$('#overlay_product').hide();
label = label.replace("&&&", " ");
label=label.trim().replace(/&&&/g, ' ');
	$("#productidl").val(label);
	$("#productid").val(id);
	
}
					$("#download_csv").on("click", function(e){
						download_csv_selected('promotion', checklist, 'promotion', 'submit', 'promotionid');
						// location.href="dba_export_csv.php?type=promotion&list="+checklist+"&page_name=promotion&action=submit&type_nam=promotionid";			
					});
					$("#download_csv_all").on("click", function(e){
						location.href="dba_export_csv.php?type=promotion&list=&page_name=promotion&action=submit&type_nam=promotionid";			
					});
					$("#upload_csv_btn").on("click", function(e){
						$("#upload_hover").empty();
						$("#upload_hover").css("display","block");
						$("#upload_hover").load("promotion_csv_upload.php");
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
			
			</script>
			<style>
			.myTools5{ display:none}
			</style>