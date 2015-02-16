<?php
include "connection.php";

if(isset($_REQUEST['upload_csv'])){
	if (is_uploaded_file($_FILES['filename']['tmp_name']) && !empty($_FILES['filename']['tmp_name'])) {
		// echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		// echo "<h2>Displaying contents:</h2>";
		// readfile($_FILES['filename']['tmp_name']);
		

		$emailval = '/([\w\-]+\@[\w\-]+\.[\w\-]+)/';
		$mob='/^\d+$/';
		
		//Import uploaded file to Database
		$handle = fopen($_FILES['filename']['tmp_name'], "r");
		$hdata = fgetcsv($handle, 1000, ",");
		$header ="";
		foreach($hdata as $h)
		{
			//if(trim($h)!="")
			$header .= trim($h) . ', ';
		}
		$header .= 'Error Description';
		
		$status = "true";
		$msg = "";
		$line_no = 2;
		$out="";
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
		{
			if ( (trim($data[1])=="")|| (trim($data[2])=="") || (trim($data[3])=="")|| (trim($data[4])=="")|| (trim($data[5])=="")|| (trim($data[6])=="")|| (trim($data[7])=="")|| (trim($data[12])=="") )
			{
				foreach($data as $h)
				{
					//if(trim($h)!="")
						$out .= trim($h) . ', ';
				}
				$msg .= "Some important field is missing. Not uploading.<br> ";
				$status = "false";
				$out .= "Error at row - ". $line_no;
				$out .= "\n";
			}
			else if (!ctype_digit(trim($data[8])) OR strlen(trim($data[8])) != 10)
			{
				foreach($data as $h)
				{
					//if(trim($h)!="")
						$out .= trim($h) . ', ';
				}
				$msg.="Check your Mobile number. Not uploading.<br> ";
				$status = "false";
				$out .= "Error at row - ". $line_no;
				$out .= "\n";
				//break;
			}
			else
			{
				if (!filter_var(trim($data[10]), FILTER_VALIDATE_EMAIL))
				{
					foreach($data as $h)
					{
						//if(trim($h)!="")
							$out .= trim($h) . ', ';
					}
					$msg.="Check your email. Stopped uploading.<br> ";
					$status = "false";
					$out .= "Error at row - ". $line_no;
					$out .= "\n";
					//break;
				}
				else
				{
					if($data[0] != ''){
						$manufid = ltrim(substr(trim($data[0]),-6),'0');
					}else{
						$manufid=0;
					}
					// echo $manufid;
					$sql = "select * from manufacturer where manufid=$manufid";
					$res = mysql_query($sql);
					$manufname=$data[1];
					$address1=$data[2];
					$address2=$data[3];
					$city=$data[4];
					$state=$data[5];
					$country=$data[6];
					$zip=$data[7];
					$phone=$data[8];
					$fax=$data[9];
					$email=$data[10];
					$cellphone=$data[11];
					$website=$data[12];
					if(mysql_num_rows($res)>0){
					// echo $manufname;
						$import="UPDATE manufacturer SET manufname='$manufname', address1='$address1', address2='$address2', city='$city', state='$state', country='$country', zip='$zip', phone='$phone', fax='$fax', email='$email', cellphone='$cellphone', website='$website' WHERE manufid='$manufid' ";
						mysql_query($import) or die(mysql_error());
					}else{
						$import = "INSERT into manufacturer(manufname, address1, address2, city, state, country, zip, phone, fax, email, cellphone, website) values('$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]')";
						mysql_query($import) or die(mysql_error());
					}
					$msg="Upload successfully";
				}
			}
			$line_no++;
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
		if($out!="")
		{
			echo "<script>window.open('download_errors.php?data=".urlencode($out)."&header=".urlencode($header)."','_self','height=250,width=250');alert('Uploaded but with some errors');</script>";
		}else{
			echo "<script>alert('Uploaded Successfully');</script>";
		}
		// echo $msg;
		fclose($handle);

		//print "Import done";

		//view upload form
	}else{
		echo "<script>alert('Please choose a file to upload');</script>";
	}
}
else if(isset($_REQUEST['submit'])){
		$manufname = $_POST['manufname'];
		$address1 = $_POST['address1'];
		$address2 = $_POST['address2'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$country = $_POST['country'];
		$zip = $_POST['zip'];
		$phone = $_POST['phone'];
		$fax = $_POST['fax'];
		$email = $_POST['email'];
		$cellphone = $_POST['cellphone'];
		$website = $_POST['website'];
		$add_edit=$_POST['add_edit'];
		if($add_edit==0){
			
			$sql = "INSERT INTO manufacturer(manufname,address1,address2,city,state,country,zip,phone,fax,email,cellphone,website)VALUES('$manufname','$address1','$address2','$city','$state','$country','$zip','$phone','$fax','$email','$cellphone','$website')";
			
			mysql_query($sql);
			echo mysql_error();
		}else{
			$id=$_POST['field_id'];
			
			$sql = "UPDATE manufacturer SET manufname='$manufname', address1='$address1', address2='$address2', city='$city', state='$state', country='$country', zip='$zip', phone='$phone', fax='$fax', email='$email', cellphone='$cellphone', website='$website' WHERE manufid='$id' ";
			
			mysql_query($sql);
		}
		header('Location: ' . basename($_SERVER['PHP_SELF']));
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
						<a href="#" class="active1">Manufacturer</a>
					</li>
				</ul>
			</div>
			<!-- end bread crum -->
	<div class="row-fluid sortable">		
			<div class="box span12">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-user"></i>Manufacturer</h2>
					<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 155px;'><i class="icon-cog"></i> Add Manufacturer</a>
					</div>
				</div>
				<div class="box-content">
					<table class="table table-striped table-bordered bootstrap-datatable datatable">
						<thead>
							<tr>
								<th Style="width:5%"><input type="checkbox" onclick="check_all()"/></th>
								<th>Manufacturer Id</th>
								<th><a>Name</a></th>
								<th><a>City</a></th>
								<th><a>State</a></th>
								<th><a>Phone</a></th>
								<th><a>Email</a></th>
							  </tr>
						</thead>   
						<tbody>
							<?php
							include "connection.php";
							$sql="SELECT * FROM manufacturer ORDER BY manufid DESC";
							//echo $sql;
							$result = mysql_query($sql);
							while ($row = mysql_fetch_array($result))
							{
								$id=$row['manufid']."$$"."manufid"."$$".'manufacturer';
								$line_id=$row['manufid'];
								echo "<tr id='$line_id'>";
								
									echo "<td class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['manufid']."') class='check_class' name='check[]' value='".$row['manufid']."'></td>";
									
								$max_id=str_pad($row['manufid'],6, '0',STR_PAD_LEFT);
								echo "<td><a href='#' onclick=product_edit('$id')>DBAM{$max_id}</a></td>";
								echo "<td>{$row['manufname']}</td>";
								echo "<td>{$row['city']}</td>";
								echo "<td>{$row['state']}</td>";
								echo "<td>{$row['phone']}</td>";
								echo "<td>{$row['email']}</td>";
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
				<h3 id='heading_pop_up'>Create Manufacturer</h3>
	</div>
	<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data" >
	<div class="modal-body" >
		<div class="box-content">
		<fieldset>	
				
				<div class="control-group">
					<label class="control-label" >Name</label>
					<div class="controls">
						<input type="text" name="manufname" id="manufname" required />
					</div>
				</div>	
				<div class="control-group">
					<label class="control-label" >Address1</label>
					<div class="controls">
						<input type="text" name="address1" id="address1" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Address2</label>
					<div class="controls">
						<input type="text" name="address2" id="address2" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >City</label>
					<div class="controls">
						<input type="text" name="city" id="city" required />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >State</label>
					<div class="controls">
						<input type="text" name="state" id="state" required />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Zip code</label>
					<div class="controls">
						<input id="zip" type="text" name="zip" onkeypress="return IsNumeric(event,'error3');" ondrop="return false;" onpaste="return false;" onchange='get_countrystate()'/>
						<span id="error3" style="color: Red; display: none">* Input digits (0 - 9)</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Country</label>
					<div class="controls">
						<input type="text" name="country" id="country" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Phone</label>
					<div class="controls">
						<input type="text" name="phone" id="phone" pattern=".{14}" title="10 digits are required" required/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Fax</label>
					<div class="controls">
						<input type="text" name="fax" id="fax" pattern=".{14}" title="10 digits are required" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Email</label>
					<div class="controls">
						<input type="email" name="email" id="email" required />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Cellphone</label>
					<div class="controls">
						<input type="text" name="cellphone" id="cellphone" pattern=".{14}" title="10 digits are required"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Website</label>
					<div class="controls">
						<input type="text" name="website" id="website" />
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
		function product_edit(id)
		{
			//alert(id);
			$("#heading_pop_up").html("Edit manufacturer detail");
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
				$("#field_id").val(obj['manufid']);
				$("#manufname").val(obj['manufname']);
				$("#address1").val(obj['address1']);
				$("#address2").val(obj['address2']);
				$("#city").val(obj['city']);
				$("#state").val(obj['state']);
				$("#country").val(obj['country']);
				$("#zip").val(obj['zip']);
				$("#phone").val(obj['phone']);
				$("#fax").val(obj['fax']);
				$("#email").val(obj['email']);
				$("#cellphone").val(obj['cellphone']);
				$("#website").val(obj['website']);
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
			$("#heading_pop_up").html("Add manufacturer");
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
		data: {local:str, table:"manufacturer", column:"manufid"}
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

$("#download_csv").on("click", function(e){
	download_csv_selected('manufacturer', checklist, 'manufacturer', 'submit', 'manufid');
	// location.href="dba_export_csv.php?type=manufacturer&list="+checklist+"&page_name=manufacturer&action=submit&type_nam=manufid";			
});
$("#download_csv_all").on("click", function(e){
	location.href="dba_export_csv.php?type=manufacturer&list=&page_name=manufacturer&action=submit&type_nam=manufid";
});
$("#upload_csv_btn").on("click", function(e){
	$("#upload_hover").empty();
	$("#upload_hover").css("display","block");
	$("#upload_hover").load("demo_upload_csv.php");
});
		$("#upload_csv_btn").on("click", function(e){
$("#overlay").css("display","block");
});

function get_countrystate()
{
	var zip_code=$("#zip").val();
		$.ajax({
			type: "GET",
			url: "getinfo.php",
			data: {zip:zip_code}
		})
		.done(function( msg ){
			if((msg!=0)||(msg!=2))
			{
				var obj = JSON.parse(msg);
				$("#city").val(obj[1]);
				$("#state").val(obj[2]);
				$("#country").val('USA');
			}
		});
}

		</script>