<?php
include "connection.php";

if(isset($_REQUEST['upload_csv'])){
	if (is_uploaded_file($_FILES['filename']['tmp_name']) && !empty($_FILES['filename']['tmp_name'])) {
		// echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		/* echo "<h2>Displaying contents:</h2>";
		readfile($_FILES['filename']['tmp_name']); */
		// }

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
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			//$phone = $data[2];
			if ( (trim($data[1])=="") || (trim($data[2])=="") )
			{
				$msg .= "Some field is missing. Not uploading.<br> ";
				//$out .= $data[0] . ', ';
				$out .= $data[0] . ', ';
				$out .= $data[1] . ', ';
				$out .= $data[2] . ', ';
				$out .= "Some field is missing at line - " . $line_no . ', ';
				$out .= "\n";
			}
			else
			{
				$pname = trim($data[1]);
				$sql = "SELECT * FROM productcategory WHERE trim(productcategoryname) = '$pname' LIMIT 1";
				$result = mysql_query($sql);
				if(mysql_num_rows($result)!=0)
				{
					$row = mysql_fetch_array($result);
					$productcategoryid = $row['productcategoryid'];
					$subcatname = trim($data[1]);
					$sql = "SELECT * FROM productsubcategory WHERE productcategoryid = '$productcategoryid' AND trim(productsubcategoryname) = '$subcatname' LIMIT 1";
					$result1 = mysql_query($sql);
					if(mysql_num_rows($result1)==0)
					{
						$import = "INSERT into  productsubcategory(productcategoryid, productsubcategoryname) values('$productcategoryid','$data[2]')";
					
						mysql_query($import) or die(mysql_error());
						$msg="Upload successfully";
					}
					else
					{
						$productsubcategory = ltrim(substr(trim($data[0]),-6),'0');
						$sql = "UPDATE productsubcategory SET productsubcategoryname='$data[2]', productcategoryid='$productcategoryid' WHERE productsubcategoryid='$productsubcategory' ";
						// echo $sql;
						mysql_query($sql);
						// $out .= $data[0] . ', ';
						// $out .= $data[1] . ', ';
						// $out .= "Duplicate subcategory at line - " . $line_no . ', ';
						// $out .= "\n";
					}
				}
				else
				{
					$out .= $data[0] . ', ';
					$out .= $data[1] . ', ';
					$out .= $data[2] . ', ';
					$out .= "No such category at line - " . $line_no . ', ';
					$out .= "\n";
				}
			}
			$line_no++;
		}
		if($out!=""){
			// echo "<script></script>";
			echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');alert('Uploaded but with some errors');</script>";
		}else{
			echo "<script>alert('Uploaded Successfully');</script>";
		}
		// echo $msg;
		fclose($handle);
	}else{
		echo "<script>alert('Please choose a file to upload');</script>";
	}
}
else if(isset($_REQUEST['submit'])){
	
		$productcategoryid = $_POST['productcategoryid'];
		$productsubcategoryname = $_POST['productsubcategoryname'];
		$add_edit=$_POST['add_edit'];
		
		if($add_edit==0){
			if(isset($_FILES['productsubcategorypic']))
			{
				$productsubcategorypic=upload_file('productsubcategorypic');
			}
			else
			{
				$productsubcategorypic='a.png';
			}
			$sql = "INSERT INTO productsubcategory(productsubcategoryname, productcategoryid,productsubcategorypic)VALUES('$productsubcategoryname','$productcategoryid','$productsubcategorypic')";
		
			mysql_query($sql);
			echo mysql_error();
		}
		else{
			$id=$_POST['field_id'];
			if(isset($_FILES['productsubcategorypic']))
			{
				$productsubcategorypic=upload_file('productsubcategorypic');
				$sql = "UPDATE productsubcategory SET productsubcategorypic='$productsubcategorypic' WHERE productsubcategoryid='$id'";
		
				mysql_query($sql);
			}
			$sql = "UPDATE productsubcategory SET productsubcategoryname='$productsubcategoryname', productcategoryid='$productcategoryid' WHERE productsubcategoryid='$id' ";
		
			mysql_query($sql);
		}
		header('Location: http://antloc.com/dba/admin/create_prod_sub.php');
	}

	function upload_file($arg)
	{
		$image_name_new = "a";
		$temp = explode(".", $_FILES[$arg]["name"]);
		$allowedExts = array("gif", "jpeg", "jpg", "png");		
		$extension = end($temp);
		if ((($_FILES[$arg]["type"] == "image/gif")
		|| ($_FILES[$arg]["type"] == "image/jpeg")
		|| ($_FILES[$arg]["type"] == "image/jpg")		
		|| ($_FILES[$arg]["type"] == "image/png"))
		&& ($_FILES[$arg]["size"] < 200000)
		&& in_array($extension, $allowedExts)) {
		  if ($_FILES[$arg]["error"] > 0) {
			echo "Return Code: " . $_FILES[$arg]["error"] . "<br>";
		  } 
		  else
		  {			
			$image_name=rand(1,100000);
			$image_name_new=$arg."_".$image_name.".".$extension;			
			if (file_exists("upload/" . $_FILES[$arg]["name"])) {
			  echo $_FILES[$arg]["name"] . " already exists. ";
			} 
			else 
			{
			  move_uploaded_file($_FILES[$arg]["tmp_name"],"upload/".$image_name_new);			  
			}
		  }
		}
		return $image_name_new;
	}
	function upload_file1($arg)
	{		
		$image_name_new = "a";
		$temp = explode(".", $_FILES[$arg]["name"]);
		$allowedExts = array("docx", "pdf");		
		$extension = end($temp);
		if ((($_FILES[$arg]["type"] == "image/docx")
		|| ($_FILES[$arg]["type"] == "image/pdf"))
		&& ($_FILES[$arg]["size"] < 200000)
		&& in_array($extension, $allowedExts)) {
		  if ($_FILES[$arg]["error"] > 0) {
			echo "Return Code: " . $_FILES[$arg]["error"] . "<br>";
		  } 
		  else
		  {			
			$image_name=rand(1,100000);
			$image_name_new=$arg."_".$image_name.".".$extension;			
			if (file_exists("upload/" . $_FILES[$arg]["name"])) {
			  echo $_FILES[$arg]["name"] . " already exists. ";
			} 
			else 
			{
			  move_uploaded_file($_FILES[$arg]["tmp_name"],"upload/".$image_name_new);			  
			}
		  }
		}
		return $image_name_new;
	}
	include "header.php";
	include "menu.php";
?>
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
						<a href="#">Product</a>
					</li>
					<li class="step">
						<a href="#" class="active1">Sub Category</a>
					</li>
				</ul>
			</div>
			<!-- end bread crum -->
	<div class="row-fluid sortable">		
			<div class="box span12">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-user"></i>Sub Category</h2>
					<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 140px;'><i class="icon-cog"></i> Add Subcategory</a>
					</div>
				</div>
				<div class="box-content">
					<table class="table table-striped table-bordered bootstrap-datatable datatable">
						<thead>
							<tr>
								<th Style="width:5%"><input type='checkbox' onclick='check_all()'></th>
								<th>Id</th>
								<th>Name</th>
								<th>Category Name</th>
								<th style="display:none;">pcid</th>
							  </tr>
						</thead>   
						<tbody>
							<?php
							include "connection.php";
							$sql="SELECT * FROM productcategory";
							$result = mysql_query($sql);
							$cat_arr = array();
							while ($row = mysql_fetch_array($result))
							{
								$cat_arr[$row['productcategoryid']] = $row['productcategoryname'];
							}
							
							$sql="SELECT * FROM productsubcategory";
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['productsubcategoryid']."$$"."productsubcategoryid"."$$".'productsubcategory';
								$line_id=$row['productsubcategoryid'];
								echo "<tr id='$line_id'>";
								
								
								echo "<td ><input type='checkbox' class='check_box' onclick=checked_entries('".$row['productsubcategoryid']."') class='check_class' name='check[]' value='".$row['productsubcategoryid']."'></td>";
									
								$max_id=str_pad($row['productsubcategoryid'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$id')>DBAPS{$max_id}</a></td>";
								echo "<td>{$row['productsubcategoryname']}</td>";
								echo "<td>{$cat_arr[$row['productcategoryid']]}</td>";
								echo "<td style='display:none'>{$row['productcategoryid']}</td>"; 
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
	</div>
</div><!--/#content.span10-->


<hr>

<div class="modal hide fade" id="myModal">
	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick='hide()'>Close</button>
				<h3>Create Product</h3>
	</div>
	<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
	<div class="modal-body">
		<div class="box-content">
		<fieldset>	
				<div class="control-group">
					<label class="control-label" >Product Category</label>
					<div class="controls">
						<select name="productcategoryid" id="productcategoryid">
					<?
					include "connection.php";
					$sql = "SELECT * FROM productcategory";
					echo "<option value=''>Select</option>";
					$result = mysql_query($sql);
					while($row=mysql_fetch_array($result)){
						echo "<option value='".$row['productcategoryid']."'>".$row['productcategoryname']."</option>";
					}
					?></select>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >Product Subcategory name</label>
					<div class="controls">
						<input type="text" id="productsubcategoryname" name="productsubcategoryname" required />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" >Picture</label>
					<div class="controls">
						<input type="file" name="productsubcategorypic" onchange="readURL(this);" />
						<img id="blah" src="#" alt="your image" />
					</div>
				</div>
						
			<input type='hidden' name='add_edit' id='add_edit' value='0'/>
			<input type='hidden' name='field_id' id='field_id' value='0'/>
		</fieldset>				
		</div>	
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal" onclick='hide()'>Close</a>
		<input type='submit' value='Submit' name='submit' style='background-color: #4376de;background-image:-moz-linear-gradient(top, #4c7de0, #366ddc);background-image:-ms-linear-gradient(top, #4c7de0, #366ddc);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#4c7de0), to(#366ddc));background-image: -webkit-linear-gradient(top, #4c7de0, #366ddc);background-image:-o-linear-gradient(top, #4c7de0, #366ddc);background-image:linear-gradient(top, #4c7de0, #366ddc);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c7de0, endColorstr=#366ddc,GradientType=0);border-color: #366ddc #366ddc #1d4ba8;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);color: white;border-radius: 2px;height: 28px;width: 66px;font-size: 14px;' />
				<!--<a href="#" class="btn btn-primary" onclick='submit_form()' >Submit</a>-->
	</div>
	</form> 
</div>

<div id="overlay"></div>

<? include "footer.php"?>

<script>
var ul1 = false;
var ul2 = false;
var ul3 = false;
var ul4 = false;
var ul5 = false;
var checkss=0;
$(document).ready(function(){

	$( "#product_ul" ).show();
	$( "#i1" ).html('-');
	ul3 = true;
	
	$.ajax({
		type: "POST",
		url: "get_cat_list.php",
		data: {action:'authenticated'}
	})
	.done(function( msg ){
		// alert(msg);
		res = JSON.parse(msg);
		// console.log(res[0].productcategoryid);
		var s='<option value="">All</option>';
		for(i=0;i<res.length;i++){
			s=s+"<option value='"+res[i].productcategoryid+"'>"+res[i].productcategoryname+"</option>";
		}
		
		$("div.myTools").html('<label>Category</label><select id="categories">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#categories').change( function() { 
			if($(this).val()==''){
				table.fnFilter( $(this).val(), 4, true ); 
			}else{
				table.fnFilter( "^"+ $(this).val() +"$", 4, true ); 
			}
		});
		
		// $("div.myTools").html('<select id="teams"><option value=""></option>'); //Team</option><c:forEach var="userTeams" items="${userProjectTeams}"><option value="${userTeams.teamId}" onClick="javascript:takeAction(this.value)"> ${userTeams.teamtName}</option></c:forEach></select>');
	});
	
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
					var t = confirm("Are you sure you want to delete these entries?");
					if (t == true) 
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
						$("#field_id").val(obj['productsubcategoryid']);
						$("#productsubcategoryname").val(obj['productsubcategoryname']);
						$("#productcategoryid").val(obj['productcategoryid']);
						$("#blah").attr("src", "upload/"+obj['productsubcategorypic']).width(70);
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
						var t = confirm("Are you sure you want to delete these entries?");
					if (t == true) 
					{
						var str = JSON.stringify(checklistjson);
						//alert(str);
						$.ajax({
							type: "POST",
							url: "delete_check.php",
							data: {local:str, table:"productsubcategory", column:"productsubcategoryid"}
						})
						.done(function( msg ){
						//	alert(msg);
							
						});
						
						for(i=0;i<checklist.length;i++){
							$("#"+checklist[i]).hide();
						}
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
						download_csv_selected('productsubcategory', checklist, 'prod_sub_cat', 'submit', 'productsubcategoryid');
						// location.href="dba_export_csv.php?type=productsubcategory&list="+checklist+"&page_name=prod_sub_cat&action=submit&type_nam=productsubcategoryid";			
					});
					
$("#download_csv_all").on("click", function(e){
						location.href="dba_export_csv.php?type=productsubcategory&list=&page_name=prod_sub_cat&action=submit&type_nam=productsubcategoryid";			
					});
					$("#upload_csv_btn").on("click", function(e){
						$("#upload_hover").empty();
						$("#upload_hover").css("display","block");
						$("#upload_hover").load("csv_upload_prdt_sub.php");
					});
					$("#upload_csv_btn").on("click", function(e){
		$("#overlay").css("display","block");
		});

		function check_all()
					{
						if(checkss==0)
						{
							$(".check_box").attr("checked",true);
							$(".checker span").addClass("checked");	
							checkss=1;
							
						}
						else
						 {
							$(".check_box").attr("checked",false);
							$(".checker span").removeClass();
							checkss=0;
							
						}
						update_array_checkbox();
						
					}
				function update_array_checkbox()
					{
						var $all_checked = $("input[type=checkbox][name='check[]']:checked");
						
						if ($all_checked.length) {
					
						   var values = $all_checked.map(function()
						   {	
								var id=this.value;
								
									var ide = {
									row:id
								}
								checklistjson.push(ide);
								checklist.push(id);						
						   }).get();
						   // ...
						} else 
						{
							checklist=[];
							checklistjson=[];
						}
												
					}
					
				
</script>