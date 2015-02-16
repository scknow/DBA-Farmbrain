<?php
include "connection.php";
if(isset($_REQUEST['submit'])){
	$brandname = $_POST['brandname'];
	$manufid = $_POST['manufid'];
	$add_edit=$_POST['add_edit'];
	if($add_edit==0){
		
		$sql = "INSERT INTO brand(brandname, manufid)VALUES('$brandname', '$manufid')";
		
		mysql_query($sql);
		echo mysql_error();
	}else{
		$id=$_POST['field_id'];
		
		$sql = "UPDATE brand SET brandname='$brandname', manufid='$manufid' WHERE brandid='$id' ";
		
		mysql_query($sql);
	}
}


	include "header.php";
	include "menu.php";
?>

<div id="content" class="span10">
			<!-- content starts -->			<div>
	<ul class="breadcrumb">
		<li>
			<a href="dashboard.php">Home</a> <span class="divider">/</span>
		</li>
		<li>
			<a href="create_edit_prod.php">Product</a>
		</li>
	</ul>
	</div>
	<div class="row-fluid sortable">		
			<div class="box span12">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-user"></i>Brand</h2>
					<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 155px;'><i class="icon-cog"></i> Add New Brand</a>
					</div>
				</div>
				<div class="box-content">
					<table class="table table-striped table-bordered bootstrap-datatable datatable">
						<thead>
							<tr>
								<th Style="width:5%">Select</th>
								<th>Id</th>
								<th>Name</th>
								<th>Manufacturer</th>
							  </tr>
						</thead>   
						<tbody>
							<?php
							include "connection.php";
							$sql="SELECT * FROM manufacturer";
							//echo $sql;
							$result = mysql_query($sql);
							$manf_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$manf_arr[$row['manufid']] = $row['manufname'];
							}
							$sql="SELECT * FROM brand";
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['brandid']."$$"."brandid"."$$".'brand';
								$line_id=$row['brandid'];
								echo "<tr id='$line_id'>";
								echo "<td onclick=checked_entries('".$row['brandid']."')><input type='checkbox'/></td>";
								$max_id=str_pad($row['brandid'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$id')>DBAB{$max_id}</a></td>";
								echo "<td>{$row['brandname']}</td>";
								echo "<td>{$manf_arr[$row['manufid']]}</td>";
								echo "</tr>";
								
							}
							?>
						</tbody>
					</table>  
					<div>
						<button onclick="deletentries()" style="margin-right:10px"><a href="#">Delete Selected</a></button>
						<button style="margin-right:10px" id="download_csv"><a href="#">Download Selected</a></button>

						<button style="margin-right:10px" id="download_csv_all"><a href="#">Download All</a></button>
						<a href="#" class="btn btn-setting btn-round btn-danger1" id="upload_csv_here" style='height: 19px;width: 100px; margin-right:10px;background:#4863A0;'> Upload</a>
						<!--<button onclick="" style="margin-right:10px"><a href="#" onclick='add_new_function1()' >Upload</a></button>-->
					</div>
				</div>
			</div><!--/span-->			
	</div>
</div><!--/#content.span10-->


<hr>

<div class="modal hide fade" id="myModal">
	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick='hide()'>Close</button>
				<h3>Create Manufacturer</h3>
	</div>
	<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
	<div class="modal-body">
		<div class="box-content">
		<fieldset>	
				
				<div class="control-group">
					<label class="control-label" >Brand name</label>
					<div class="controls">
						<input type="text" name="brandname" id="brandname" />
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label" >Manufacturer</label>
					<div class="controls">
						<select name="manufid" id="manufid" required >
                            <?
							include "connection.php";
							$sql = "SELECT * FROM manufacturer";
							echo "<option value=''>Select</option>";
							$result = mysql_query($sql);
							while($row=mysql_fetch_array($result)){
								echo "<option value='".$row['manufid']."'>".$row['manufname']."</option>";
							}
							?>
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

<div class="modal hide fade1" id="myModal1">
	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick='hide1()'>Close</button>
				<h3>Upload</h3>
	</div>
	<form name="upload_form1" class="form-horizontal" method="post" id="upload_csv" action="brand_upload_csv.php" enctype="multipart/form-data">
	<div class="modal-body">
		<div class="box-content">
			<fieldset>	
				
				<div class="control-group">
					<label class="control-label" >File name to import: </label>
					<div class="controls">
						<input size='50' type='file' name='filename'>
					</div>
				</div>	
			</fieldset>				
		</div>	
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" onclick='hide1()'>Close</a>
		<input type='submit' value='Upload' name='submit' style='background-color: #4376de;background-image:-moz-linear-gradient(top, #4c7de0, #366ddc);background-image:-ms-linear-gradient(top, #4c7de0, #366ddc);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#4c7de0), to(#366ddc));background-image: -webkit-linear-gradient(top, #4c7de0, #366ddc);background-image:-o-linear-gradient(top, #4c7de0, #366ddc);background-image:linear-gradient(top, #4c7de0, #366ddc);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c7de0, endColorstr=#366ddc,GradientType=0);border-color: #366ddc #366ddc #1d4ba8;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);color: white;border-radius: 2px;height: 28px;width: 66px;font-size: 14px;' >
				<!--<a href="#" class="btn btn-primary" onclick='submit_form()' >Submit</a>-->
	</div>
	</form> 
</div>

<!--<div id="upload_csv" style="display:none;">
	<form name="upload_form1" class="form-horizontal" enctype='multipart/form-data' action='brand_upload_csv.php' method='post' id="upload_csv_form" >
	<fieldset>	
			
			<div class="control-group">
				<label class="control-label" >File name to import</label>
				<div class="controls">
					<input size='50' type='file' name='filename'>
				</div>
			</div>
	</fieldset>

	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" onclick='hide()'>Close</a>
		<input type='submit' value='Upload' name='submit' style='background-color: #4376de;background-image:-moz-linear-gradient(top, #4c7de0, #366ddc);background-image:-ms-linear-gradient(top, #4c7de0, #366ddc);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#4c7de0), to(#366ddc));background-image: -webkit-linear-gradient(top, #4c7de0, #366ddc);background-image:-o-linear-gradient(top, #4c7de0, #366ddc);background-image:linear-gradient(top, #4c7de0, #366ddc);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c7de0, endColorstr=#366ddc,GradientType=0);border-color: #366ddc #366ddc #1d4ba8;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);color: white;border-radius: 2px;height: 28px;width: 66px;font-size: 14px;' >
				<!--<a href="#" class="btn btn-primary" onclick='submit_form()' >Submit</a>-->
	</div>
	</form> 
	
</div>-->


<? include "footer.php"?>

<script>
var ul1 = false;
var ul2 = false;
var ul3 = false;
var ul4 = false;
var ul5 = false;

$(document).ready(function(){
	$( "#product_ul" ).show();
	$( "#i1" ).html('-');
	ul3 = true;
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

$( "#upload_csv_here" ).click(function() {
	$("#myModal").hide();
	$("#myModal1").show();
	$("#myModal1").addClass('in');
	
	var $div = $('<div />').appendTo('body');
	$div.attr('class','modal-backdrop1 fade in');
});
function hide1()
{					
	$("#myModal1").hide();
	$(".fade").removeClass('in');
	$( ".modal-backdrop1" ).remove();					
}

/* function add_new_function1()
{
	//alert();
	$('#upload_csv').show();
} */
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
						$("#field_id").val(obj['brandid']);
						$("#brandname").val(obj['brandname']);
						$("#manufid").val(obj['manufid']);
						
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
						var str = JSON.stringify(checklistjson);
						//alert(str);
						$.ajax({
							type: "POST",
							url: "delete_check.php",
							data: {local:str, table:"brand", column:"brandid"}
						})
						.done(function( msg ){
						
						});
						
						for(i=0;i<checklist.length;i++){
							$("#"+checklist[i]).hide();
						}
					}
					
					function search_uniq(){
						var str = $("#partner_user_id").val();
						//alert(str);
						$.ajax({
							type: "GET",
							url: "search_partner.php",
							data: {term:str}
						})
						.done(function( msg ){
						//alert(msg);
							if(msg==1){
								$("#alreaytag").show();
								//document.getElementById("alsubmt").disabled = true;
							}else{
								$("#alreaytag").hide();
								//document.getElementById("alsubmt").disabled = false;
							}
						});
					}
					function readURL(input) {
						if (input.files && input.files[0]) {
							var reader = new FileReader();

							reader.onload = function (e) {
								$('#blah')
									.attr('src', e.target.result)
									.width(70)
							};

							reader.readAsDataURL(input.files[0]);
						}
					}
					$("#download_csv").on("click", function(e){
						location.href="dba_export_csv.php?type=brand&list="+checklist+"&page_name=brand&action=submit&type_nam=brandid";			
					});
					$("#download_csv_all").on("click", function(e){
						location.href="dba_export_csv.php?type=brand&list=&page_name=brand&action=submit&type_nam=brandid";			
					});
</script>