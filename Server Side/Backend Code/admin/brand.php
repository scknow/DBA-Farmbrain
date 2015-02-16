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
			// echo trim($data[0])." ".trim($data[1]);
			if ( (trim($data[1])=="") || (trim($data[2])=="") )
			{
				$msg .= "Some field is missing. Not uploading.<br> ";
				$out .= $data[0] . ', ';
				$out .= $data[1] . ', ';
				$out .= $data[2] . ', ';
				$out .= "Some field is missing at line - " . $line_no . ', ';
				$out .= "\n";
			}
			else
			{
				// $mname = ltrim(substr(trim($data[0]),-7),'0');
				$brandid =  ltrim(substr(trim($data[0]),-6),'0');
				$mname =trim($data[1]);
				// echo $mname;
				$sql = "SELECT manufid FROM manufacturer WHERE trim(manufname) = '$mname' LIMIT 1";
				$result = mysql_query($sql);
				if(mysql_num_rows($result)!=0)
				{
					$row = mysql_fetch_array($result);
					$manufacturerid = $row['manufid'];
					$sql = "SELECT * FROM brand WHERE brandid=$brandid";//manufid = '$manufacturerid' AND trim(brandname) = '$data[2]' LIMIT 1";
					$result = mysql_query($sql);
					// echo $sql;
					if(mysql_num_rows($result)==0)
					{
						$import = "INSERT into brand(manufid, brandname) values('$manufacturerid','$data[2]')";
					
						mysql_query($import) or die(mysql_error());
						$msg="Upload successfully";
					}
					else
					{
						
						$import = "UPDATE brand SET brandname='$data[2]' WHERE brandid='$brandid' ";
						// echo $import;
						mysql_query($import);
						// $out .= $data[0] . ', ';
						// $out .= $data[1] . ', ';
						// $out .= "Duplicate manufacture at line - " . $line_no . ', ';
						// $out .= "\n";
					}
				}
				else
				{
					$out .= $data[0] . ', ';
					$out .= $data[1] . ', ';
					$out .= $data[2] . ', ';
					$out .= "No such manufacture at line - " . $line_no . ', ';
					$out .= "\n";
				}
			}
		}
		/* if($status == "true")
		{
			$handle = fopen($_FILES['filename']['tmp_name'], "r");
			fgetcsv($handle, 1000, ",");
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
			{
				$import="INSERT into manufacturer(manufname, address1, address2, city, state, country, zip, phone, fax, email, cellphone, website) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]')";
				
				mysql_query($import) or die(mysql_error());
				$msg="Upload successfully";
			}
		} */
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
	header('Location: http://antloc.com/dba/admin/brand.php');
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
						<a href="#" class="active1">Brand</a>
					</li>
				</ul>
			</div>
			<!-- end bread crum -->
	<div class="row-fluid sortable">		
			<div class="box span12">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-user"></i>Brand</h2>
					<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 155px;'><i class="icon-cog"></i> Add Brand</a>
					</div>
				</div>
				<div class="box-content">
					<table class="table table-striped table-bordered bootstrap-datatable datatable">
						<thead>
							<tr>
								<th><input type="checkbox" onclick="check_all()"/></th>
								<th>Id</th>
								<th>Name</th>
								<th>Manufacturer</th>
								<th style="display:none;">manuid</th>
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
							$sql="SELECT * FROM brand ORDER BY brandid DESC" ;
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['brandid']."$$"."brandid"."$$".'brand';
								$line_id=$row['brandid'];
								echo "<tr id='$line_id'>";
								echo "<td  class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['brandid']."') name='check[]' value='".$row['brandid']."'></td>";
								
							
								$max_id=str_pad($row['brandid'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$id')>DBAB{$max_id}</a></td>";
								echo "<td>{$row['brandname']}</td>";
								echo "<td>{$manf_arr[$row['manufid']]}</td>";
								echo "<td style='display:none;'>{$row['manufid']}</td>";
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
				<h3>Create Manufacturer</h3>
	</div>
	<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
	<div class="modal-body">
		<div class="box-content">
		<fieldset>	
				
				<div class="control-group">
					<label class="control-label" >Brand name</label>
					<div class="controls">
						<input type="text" name="brandname" id="brandname" required />
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
		$("div.myTools").html('<label>Manufacturer</label><select id="manufact">'+s+'</select>');
		var table=$('.datatable').dataTable();
		$('select#manufact').change( function() { 
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
					var r = confirm("Are you sure you want to delete these entries ?");
					if (r == true) 
					{
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
					}}
					
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
						download_csv_selected('brand', checklist, 'brand', 'submit', 'brandid');
						// location.href="dba_export_csv.php?type=brand&list="+checklist+"&page_name=brand&action=submit&type_nam=brandid";			
					});
					$("#download_csv_all").on("click", function(e){
						location.href="dba_export_csv.php?type=brand&list=&page_name=brand&action=submit&type_nam=brandid";			
					});
					$("#upload_csv_btn").on("click", function(e){
						$("#upload_hover").empty();
						$("#upload_hover").css("display","block");
						$("#upload_hover").load("brand_upload_csv.php");
					});
					$("#upload_csv_btn").on("click", function(e){
		$("#overlay").css("display","block");
		});
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