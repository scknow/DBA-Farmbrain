<? 
	include "connection.php";
	session_start();	
	if(isset($_REQUEST['add_line']))
	{
		
		$tbl_name="help_support"; // Table name
		// username and password sent from form 
		$sql="SELECT MAX( id ) FROM $tbl_name";
		$result=mysql_query($sql);
		$temp=mysql_fetch_array($result);
		$max_id = $temp['MAX( id )'] +1;
		
		$CLNT0=$_SESSION['id'];
		$TINUM="SUP".($max_id+100000);
		
		$TICAT=$_POST['i_cat'];
		$TIPRI=$_POST['i_prior'];
		$TIDEC=$_POST['i_desc'];
		$TIDET=$_POST['i_detail'];
		$TISTA=$_POST['i_status'];
		$TIATO=$_POST['i_assigned_to'];
		$TIREM=$_POST['i_remark'];
		$TIRES='';
		$CRDAT= date("m/d/Y");
		$CRTBY='admin';
		
		if(isset($_FILES['i_attach']))
		{
			$file=upload_file1('i_attach');
		}
		else
		{
			$file='a';
		}
		
		
		$sql="INSERT INTO  $tbl_name (CLNT0, TINUM, TICAT, TIPRI, TIDEC, TIDET, TIFIL, TISTA, TIRES, CRDAT, CRTBY, TIATO, TIREM) VALUES( '$CLNT0', '$TINUM', '$TICAT', '$TIPRI', '$TIDEC', '$TIDET', '$file', '$TISTA', '$TIRES', '$CRDAT', '$CRTBY', '$TIATO','$TIREM')";	
		
		$result=mysql_query($sql);
	}
	
	function upload_file1($arg)
	{		
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
	
	
?>
			
			<!-- left menu starts -->
			<div class="span2 main-menu-span" style='display:none;'>
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a class="ajax-link" href="ui.html"><i class="icon-eye-open"></i>						
						<span class="hidden-tablet"> Application Setting</span></a>
						<ul style='list-style:none;' style='padding-left:9px;' class='nav nav-tabs nav-stacked main-menu'>
							<li><a class="ajax-link" href="#" style='padding-left: 25px;background:rgb(238, 238, 238);'><i class="icon-eye-open"></i>					
							<span class="hidden-tablet">Change Logo</span></a></li>
							<li><a id='product_li' class="ajax-link" href="#" style='padding-left: 25px;background:rgb(238, 238, 238);'><i class="icon-eye-open"></i>					
							<span class="hidden-tablet">Change theme</span></a>
							</li>							
							
							
						</ul>
						</li>
						
						</ul>
						
				</div><!--/.well -->
			</div><!--/span-->
			
			<!-- left menu ends -->
			<div id="content" class="span10" style='width: 100%;'>
			<!-- content starts -->			
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="index.php">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Help & Support</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable" style='width:72%;margin: 0 auto;'>		
				<div class="box span12" style='width:100%;min-height:219px;overflow:hidden;float:left'>				
				<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Help & Support</h2>
				</div>
					<div class="box-content">					
						<div class="box-content">
				<!--<div style="background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(0,0,0,0.1) 100%);" class="well" data-original-title>
					<center><a href="#" class="btn btn-info" style='height: 19px;width: 150px;' onclick='add_new_function()' ><i class="icon-cog"></i>Create a new ticket</a></center>
				</div>-->
				<div style="background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(0,0,0,0.1) 100%);" class="well" data-original-title>
					<center><a href="tickets.php" class="btn btn-info" style='width: 150px;'><i class="icon-cog"></i>Support Dashboard</a></center>
				</div>
				<div style="background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(0,0,0,0.1) 100%);" class="well" data-original-title>
					<center><a href="faq.php" class="btn btn-info" style='width: 150px;'><i class="icon-cog"></i>FAQ’s & Knowledge Management</a></center>
				</div>
				<div style="background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(0,0,0,0.1) 100%);" class="well" data-original-title>
					<center><a href="backh.php" class="btn btn-info" style='width: 150px;'><i class=""></i>Contact us</a></center>
				</div>
				</div>
					</div>
				</div>	
			
			</div>
		</div>
	
	</div><!--/fluid-row-->
	
	<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="hide()">close</button>
				<h3>Add New Ticket</h3>
			</div>
			<div class="modal-body">
				<div class="box-content">
				<form name="form1" class="form-horizontal" method="post" id="all" action="#" enctype="multipart/form-data">
					<? 	
						include "connection.php";
						$cid = "DBAS".str_pad($_SESSION['supplierid'],6, '0',STR_PAD_LEFT);;
						
						$tbl_name="help_support"; // Table name
						// username and password sent from form 
						$sql="SELECT MAX( id ) FROM $tbl_name";
						$result=mysql_query($sql);
						$temp=mysql_fetch_array($result);
						$max_id = $temp['MAX( id )'] +1;
						
						$TINUM="TCKT".($max_id+100000);

					?>
						  <fieldset>
						  <div class="control-group">
								<label class="control-label" for="inputError">User ID</label>
								<div class="controls">
								<input name="client_id" type="text" id="client_id"  value='<? echo $cid;?>' disabled /> 
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputError">Ticket Number</label>
								<div class="controls">
									<label><? echo $TINUM ?></label> 
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputError">Issue Category</label>
								<div class="controls">
									<select required name="i_cat"><option value="" >Select</option><option value="Defect" >Defect</option><option value="Enhancement" >Enhancement</option><option value="DataIssue" >Data Issue</option></select> 
								</div>
							</div>	
							<div class="control-group">
								<label class="control-label" >Issue Priority </label>
								<div class="controls">
									<select name="i_prior" required ><option value="" >Select</option><option value="Low" >Low</option>
									<option value="Medium" >Medium</option>
									<option value="High" >High</option></select> 
								</div>
							</div>	
							<div class="control-group">
								<label class="control-label" >Issue</label>
								<div class="controls">
									<textarea col='10' name="i_desc" type="text" id="i_desc" maxlength="40"></textarea> 
								</div>	
							</div>	
							<div class="control-group">
								<label class="control-label" >Issue Description</label>
								<div class="controls">
									<textarea col='15' name="i_detail" type="text" id="i_detail" maxlength="255"></textarea> 
								</div>	
							</div>	
							
							<div class="control-group">
							<label class="control-label" for="inputError">Attachments</label>
							<div class="controls">
								<input name="i_attach" type="file" id="i_attach" />  
							</div>
							</div>				
							<div class="control-group">
								<label class="control-label" for="inputError">Status</label>
								<div class="controls">
									<select name="i_status" id="i_status" required >
										<option value="Created" selected >Created</option>
										<option value="Assigned" >Assigned</option>
										<option value="In progress" >In progress</option>
										<option value="On Hold" >On Hold</option>
										<option value="Closed" >Closed</option>
									</select> 
								</div>
							</div>							
							<div class="control-group">
								<label class="control-label" for="inputError">Assigned To</label>
								<div class="controls">
									<select name="i_assigned_to" id="i_assigned_to" required>
										<option value="Gundeep Singh" selected>Gundeep Singh</option>
										<option value="Alex Cardona" >Alex Cardona</option>
										<option value="Gaurav Kohli" >Gaurav Kohli</option>
										<option value="Brian Carlson" >Brian Carlson</option>
										<option value="Karan Checker" >Karan Checker</option>
										<option value="Varinder Singh" >Varinder Singh</option>
										
									</select> 
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" >Remarks/History</label>
								<div class="controls">
									<textarea col='15' name="i_remark" type="text" id="i_remark" maxlength="255" readonly></textarea> 
								</div>	
							</div>
						  <input type='hidden' name='add_edit' id='add_edit' value='0'/>
						  <input type='hidden' name='field_id' id='field_id' value='0'/>
						  </fieldset>
						
						</div>
				
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal" onclick="hide()" >Close</a>
				<input type='submit' value='Submit' name='add_line' style='background-color: #4376de;background-image:-moz-linear-gradient(top, #4c7de0, #366ddc);background-image:-ms-linear-gradient(top, #4c7de0, #366ddc);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#4c7de0), to(#366ddc));background-image: -webkit-linear-gradient(top, #4c7de0, #366ddc);background-image:-o-linear-gradient(top, #4c7de0, #366ddc);background-image:linear-gradient(top, #4c7de0, #366ddc);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c7de0, endColorstr=#366ddc,GradientType=0);border-color: #366ddc #366ddc #1d4ba8;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);color: white;border-radius: 2px;height: 28px;width: 66px;font-size: 14px;' >
				<!--<a href="#" class="btn btn-primary" onclick='submit_form()' >Submit</a>-->
			</div>
			</form> 
		</div>

	
	
	
		<? include "footer.php"?>
		<script>
			
			function add_new_function()
			{		
				$("#add_edit").val(0);
				$("#all")[0].reset();
					$("#myModal").show();
					$("#myModal").addClass('in');
					
					var $div = $('<div />').appendTo('body');
					$div.attr('class','modal-backdrop fade in');
			}
			function hide()
			{					
				$("#myModal").hide();
				$(".fade").removeClass('in');
				$( ".modal-backdrop" ).remove();					
			}
			$("#i_assigned_to, #i_status").change(function(){
				var s='';
				var d = new Date();

				var month = d.getMonth()+1;
				var day = d.getDate();

				var output = d.getFullYear() + '/' +
					(month<10 ? '0' : '') + month + '/' +
					(day<10 ? '0' : '') + day;
				if($("#i_status").val() == "Created"){
					s= "<?php echo $_SESSION['name']; ?>"+" Created issue on "+output;
				}else if($("#i_status").val() == "Assigned"){
					s= "<?php echo $_SESSION['name']; ?>"+" Assigned issue to "+$("#i_assigned_to").val();
				}else if($("#i_status").val() == "In progress"){
					s= "<?php echo $_SESSION['name']; ?>"+" changed status to In Progess";
				}else if($("#i_status").val() == "On Hold"){
					s= "<?php echo $_SESSION['name']; ?>"+" put the issue on Hold";
				}else if($("#i_status").val() == "Closed"){
					s= "<?php echo $_SESSION['name']; ?>"+" Closed the issue";
				}
				$("#i_remark").val(s);
			});
		</script>