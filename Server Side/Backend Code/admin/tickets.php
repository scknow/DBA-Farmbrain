<?php
	include "connection.php";
	session_start();
	
	if(isset($_REQUEST['i_desc']))
	{
		// echo "ASDAS";die;
		$tbl_name="help_support"; // Table name
		$id=$_POST['tinum_val'];
		$TINUM=$id;
		$id=ltrim(substr(trim($id),-5),'0');
		$CLNT0=$_SESSION['id'];
		$CRTD_BY_ID=$_SESSION['id'];
		$TICAT=$_POST['i_cat'];
		$TIPRI=$_POST['i_prior'];
		$TIDEC=$_POST['i_desc'];
		$TIDET=$_POST['i_detail'];
		$TISTA=$_POST['i_status'];
		$TIATO=$_POST['i_assigned_to'];
		$TIREM=$_POST['i_remark'];
		
		$TIRES='';
		$CRDAT= date("m/d/Y");
		$CRTBY=$_SESSION['name'];
		$resolved_on=$_POST['resolved_on'];
		$add_edit=$_POST['add_edit'];
		$arg='i_attachs';
		if($add_edit==1)
		{
			
			if(!file_exists($_FILES[$arg]['tmp_name']) || !is_uploaded_file($_FILES[$arg]['tmp_name'])) 
			{	
				
				$sql="update $tbl_name set CLNT0='$CLNT0', TINUM='$TINUM', TICAT='$TICAT', TIPRI='$TIPRI', TIDEC='$TIDEC', TIDET='$TIDET',TISTA='$TISTA', TIRES='$TIRES',TIATO='$TIATO', TIREM='$TIREM',resolved_on='$resolved_on' where id=$id";	
			}
			else{
				
				$temp = explode(".", $_FILES[$arg]["name"]);
				$allowedExts = array("docx", "pdf");		
				$extension = end($temp);//echo $extension;die;
				if ($_FILES[$arg]["size"] < 200000)
				{
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
				
				$file=$image_name_new;
				$sql="update $tbl_name set CLNT0='$CLNT0', TINUM='$TINUM', TICAT='$TICAT', TIPRI='$TIPRI', TIDEC='$TIDEC', TIDET='$TIDET', TIFIL='$file', TISTA='$TISTA', TIRES='$TIRES', TIATO='$TIATO', TIREM='$TIREM' ,resolved_on='$resolved_on' where id=$id";	
			}
			
			$result=mysql_query($sql);
			include "test_email.php";			
		}
		else
		{
			if(!file_exists($_FILES['i_attachs']['tmp_name']) || !is_uploaded_file($_FILES['i_attachs']['tmp_name']))
			{	
				$file='a';
			}
			else
			{
				$file=upload_file1('i_attachs');
			}
			$sql="INSERT INTO  $tbl_name (CLNT0, TINUM, TICAT, TIPRI, TIDEC, TIDET, TIFIL, TISTA, TIRES, CRDAT, CRTBY, TIATO, TIREM,CRTD_BY_ID,resolved_on) VALUES( '$CLNT0', '$TINUM', '$TICAT', '$TIPRI', '$TIDEC', '$TIDET', '$file', '$TISTA', '$TIRES',NOW(),'$CRTBY','$TIATO','$TIREM','$CRTD_BY_ID','$resolved_on')";
			
			$result=mysql_query($sql);
			$ro=mysql_query("select MAX(id) from $tbl_name");
			$vh=mysql_fetch_array($ro);
			include "test_email.php";
		}		
	}
	function upload_file1($arg)
	{		
		$temp = explode(".", $_FILES[$arg]["name"]);
		$allowedExts = array("docx", "pdf");		
		$extension = end($temp);
		// if ((($_FILES[$arg]["type"] == "image/docx")
		// || ($_FILES[$arg]["type"] == "image/pdf"))
		// && ($_FILES[$arg]["size"] < 200000)
		// && in_array($extension, $allowedExts)) 
		if($_FILES[$arg]["size"] < 200000){
		  if ($_FILES[$arg]["error"] > 0) {
			$image_name_new='a';
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
			
			
			
			<!-- left menu ends -->
			<div id="content" class="span10" style="margin-left:9%">
			<!-- content starts -->			<div class='bread'>
				<ul class="breadcrumb">
					<li class='step'>
						<a href="index.php">Home</a>
					</li>
					<li class='step'>
						<a href="help_mail.php">Help & support</a>
					</li>
					<li class='step'>
						<a href="#" class='active1'>Ticket Status</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Tickets</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round btn-danger" onclick='add_new_function()' style='height: 19px;width: 120px;'><i class="icon-cog"></i> Add Ticket</a>
					</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th><input type="checkbox" onclick="check_all()"/></th> 
								  <th>Ticket #</th>
								  <th>Created By</th>
								  <th>Created on</th>
								  <th>Issue Description</th>
								  <th>Status</th>
								  <th>Assigned To</th>
								  <th>Priority</th>
								  <th>Resolved on</th>
							  </tr>
						  </thead>   
						  <tbody id='test_datatable'>
						  <?php
							session_start();
							//retrieve session data
							include "connection.php";
							$cid=$_SESSION['id'];
							
							$tbl_name='help_support';
							if($_SESSION["superadmin"]==1)
							{
								$sql="SELECT * FROM $tbl_name ORDER BY id DESC";
							}
							else
							{
								$sql="SELECT * FROM $tbl_name WHERE CRTD_BY_ID='$cid' ORDER BY id DESC";
							}
							//echo $sql;
							if($tbl_name=="help_support"){
							
							$result = mysql_query($sql);
							//echo $sql;
							$i=1;
							while ($row = mysql_fetch_array($result))
							{
								$TINUM="TCKT".($row['id']+100000);
								$line_id=$row['id'];
								echo "<tr id='$line_id'>";
															
								echo "<td  class='check_box1'><input type='checkbox' class='check_box' onclick=checked_entries('".$row['id']."') name='check[]' value='".$line_id."'></td>";
								
								echo "<td onclick=update_records('".$row['id']."');><a href='#'>".$TINUM."</a></td>";
								echo "<td>".$row['CRTBY']."</td>";
								echo "<td>".$row['CRDAT']."</td>";
								echo "<td>".$row['TIDEC']."</td>";
								echo "<td>".$row['TISTA']."</td>";
								echo "<td>".$row['TIATO']."</td>";
								echo "<td>".$row['TIPRI']."</td>";
								if($row['resolved_on']!=-1)
								{
									echo "<td>".$row['resolved_on']."</td>";
								}
								else
								{
									echo "<td>&nbsp;</td>";
								}	
								echo "</tr>";
							}
							}
							?>
							
					</table> 
					<div>
						<button onclick="deletentries()" style="margin-right:10px"><a href="#">Delete Selected</a></button>
						<button style="margin-right:10px" id="download_csv"><a href="#">Download Selected</a></button>
						<button style="margin-right:10px" id="download_csv_all"><a href="#">Download All</a></button>
						<button id="upload_csv_btn" onclick="deletentriesall()" style="margin-right:10px">
						<a href="#">Delete All</a></button>
					</div>
					
					</div>
				</div><!--/span-->			
			</div><!--/row-->		
		<!-- content ends -->
		
		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="hide()">close</button>
				<h3 id='heading'>Add New Ticket</h3>
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
									<label name="tinum" id='tinum'><?php echo $TINUM;?></label> 
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="inputError">Issue Category</label>
								<div class="controls">
									<select required name="i_cat" id="i_cat">
									<option value="" >Select</option>
									<option value="Defect" >Defect</option>
									<option value="Enhancement" >Enhancement</option>
									<option value="DataIssue" >Data Issue</option></select> 
								</div>
							</div>	
							<div class="control-group">
								<label class="control-label" >Issue Priority </label>
								<div class="controls">
									<select name="i_prior" id="i_prior" required >
									<option value="" >Select</option>
									<option value="Low" >Low</option>
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
								<input name="i_attachs" type="file" id="i_attach" />								
							</div>
							<p onclick='open_attachment()' style='float:left'><img src='http://antloc.com/dba/admin/images/download.png' style='width:30px;' id='p_img'></p>
							</div>				
							<div class="control-group">
								<label class="control-label" for="inputError">Status</label>
								<div class="controls">
									<select name="i_status" id="i_status" required >
										<option value="" selected >Select</option>
										<option value="Created" >Created</option>
										<option value="Assigned" >Assigned</option>
										<option value="In progress" >In progress</option>
										<option value="On Hold" >On Hold</option>
										<option value="Closed" >Closed</option>
										<option value="Ready for test" >Ready for test</option>
										<option value="Reject" >Rejected</option>
									</select> 
								</div>
							</div>							
							<div class="control-group">
								<label class="control-label" for="inputError">Assigned To</label>
								<div class="controls">
									<select name="i_assigned_to" id="i_assigned_to" required >
										<option value="" selected >Select</option> 
										<option value="Gundeep Singh" >Gundeep Singh</option>
										<option value="Alex Cardona" >Alex Cardona</option>	
										<option value="james" >James</option>
										<option value="Gaurav Kohli" >Gaurav Kohli</option>
										<option value="Brian Carlson" >Brian Carlson</option>
										<option value="Karan Checker" >Karan Checker</option>
										<option value="Varinder Singh" >Varinder Singh</option>
										<option value="Jatin" >Jatin</option>
										<option value="SNA Test team" >SNA test team</option>
										
									</select> 
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" >Remarks/History</label>
								<div class="controls">
									<textarea col='15' name="i_remark" type="text" id="i_remark" maxlength="255" readonly></textarea> 
								</div>	
							</div>
						<input type="hidden" name="img_val" id="img_val" value="" />
						  <input type='hidden' name='add_edit' id='add_edit' value='0'/>
						  <input type='hidden' name='field_id' id='field_id' value='0'/>
						  <input type='hidden' name='tinum_val' id='tinum_val'/> 

						  <input type='hidden' name='resolved_on' id='resolved_on'/>
						  
						  <input type='hidden' name='download_file' id='download_file'/>
						  </fieldset>
						
						</div>
				
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal" onclick="hide()" >Close</a>
				<input type='submit' value='Submit' name='add_line' style='background-color: #4376de;background-image:-moz-linear-gradient(top, #4c7de0, #366ddc);background-image:-ms-linear-gradient(top, #4c7de0, #366ddc);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#4c7de0), to(#366ddc));background-image: -webkit-linear-gradient(top, #4c7de0, #366ddc);background-image:-o-linear-gradient(top, #4c7de0, #366ddc);background-image:linear-gradient(top, #4c7de0, #366ddc);background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c7de0, endColorstr=#366ddc,GradientType=0);border-color: #366ddc #366ddc #1d4ba8;border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);color: white;border-radius: 2px;height: 28px;width: 66px;font-size: 14px;' onclick='capture()'>
				<!--<a href="#" class="btn btn-primary" onclick='submit_form()' >Submit</a>-->
			</div>
			</form> 
		</div>
		
		</div><!--/#content.span10-->
				
		<hr>

		

		<? include "footer.php"?>
			<script type="text/javascript" src="js/html2canvas.js"></script>
			<script type="text/javascript" src="js/plugin_html.js"></script>
		<script>
		var time=1;
		$(document).ready(function()
		{
			var s='<option value="">All</option><option value="Created">Created</option><option value="Assigned">Assigned</option><option value="In progress">In progress</option><option value="On Hold">On Hold</option><option value="Closed">Closed</option><option value="Reject">Rejected</option><option value="Ready for test">Ready for test</option>';
		
			$("div.myTools").html('<label>Status</label><select id="status">'+s+'</select>');
			var table=$('.datatable').dataTable();
			
			$('select#status').change( function() { 
				if($(this).val()==''){
					table.fnFilter( $(this).val(), 5, true ); 
				}else{
					table.fnFilter( "^"+ $(this).val() +"$", 5, true ); 
				}
			});
			
			
			var s='<option value="">All</option><option value="Gundeep Singh">Gundeep Singh</option><option value="Alex Cardona">Alex Cardona</option><option value="Gaurav Kohli">Gaurav Kohli</option><option value="Brian Carlson">Brian Carlson</option><option value="Karan Checker">Karan Checker</option><option value="Varinder Singh">Varinder Singh</option><option value="Jatin">Jatin</option><option value="SNA Test team">SNA Test team</option>';
			
			$("div.myTools1").html('<label>Assigned To</label><select id="assignedTO">'+s+'</select>');
			var table=$('.datatable').dataTable();
			$('select#assignedTO').change( function() { 
				if($(this).val()==''){
					table.fnFilter( $(this).val(), 6, true ); 
				}else{
					table.fnFilter( "^"+ $(this).val() +"$", 6, true ); 
				}
			});
			
			/* $("div.myTools2").html('<label>Start Date</label><input type="text" id="startD" placeholder="Start Date"/> <i>X</i>');
			$('#startD').datepicker({ 
			dateFormat: 'mm/dd/yy', 
			beforeShow : function(){
				$( this ).datepicker('option','maxDate', $('#EndD').val() );
			}
		});		
			$('input#startD').change( function() {
			std = $("#startD").val();
			end = $("#EndD").val();
			if(((std=='')||(end==''))&&time==1)
			{
				$.ajax({
					type: "POST",
					url: "date_range_ticket.php",
					data: {sd:std, ed:end}
				})
				.done(function( msg ){
					time=0;
					$("#test_datatable").html('');
					$("#test_datatable").html(msg);
				});
			}
			else
			{
					$.ajax({
						type: "POST",
						url: "date_range_ticket.php",
						data: {sd:std, ed:end}
					})
					.done(function( msg ){
						$("#test_datatable").html('');
						$("#test_datatable").html(msg);
					});
				}
			});
			$("div.myTools3").html(' <label>End Date</label><input type="text" id="EndD" placeholder="End Date"/><i>X</i>');
			$('#EndD').datepicker({ 
				dateFormat: 'mm/dd/yy',
				beforeShow : function(){
					$( this ).datepicker('option','minDate', $('#startD').val() );
				}
			});
			$('input#EndD').change( function() {
			std = $("#startD").val();
			end = $("#EndD").val();
			if(((std=='')||(end==''))&&time==1)
			{
				
				$.ajax({
					type: "POST",
					url: "date_range_ticket.php",
					data: {sd:std, ed:end}
				})
				.done(function( msg ){
					time=0;
					//$("#test_datatable").html('');
					//$("#test_datatable").html(msg);
				});
			}
			else
			{
				$.ajax({
					type: "POST",
					url: "date_range_ticket.php",
					data: {sd:std, ed:end}
				})
				.done(function( msg ){
					
					$("#test_datatable").html('');
					$("#test_datatable").html(msg);
				});
			}
		});
			 */
			 
			 
			var s='<option value="">All</option><option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option>';
			// for(i=0;i<4;i++){
				// s=s+"<option value='"+res[i].supplierid+"'>"+res[i].businessname+"</option>";
			// }
			$("div.myTools4").html('<label>Priority</label><select id="priorities">'+s+'</select>');
			var table=$('.datatable').dataTable();
			$('select#priorities').change( function() { 
				if($(this).val()==''){
					table.fnFilter( $(this).val(), 7, true ); 
				}else{
					table.fnFilter( "^"+ $(this).val() +"$", 7, true ); 
				}
			});
			
			finish_loading_filters();
			$("#startD").datepicker("setDate",'');
			$("#EndD").datepicker("setDate",'');
			$(".myTools2 input, .myTools3 input").change();
		});
			
		function update_records(issue_id)
			{
				$("#add_edit").val(1);
				$("#resolved_on").val('-1');
				$.ajax({
						type: "GET",
						url: "ticket_edit.php",
						data: {d: issue_id}
					})
					.done(function( msg ) {
						obj = JSON.parse(msg);
						console.log(msg);
						$("#tinum_val").html(issue_id);
						$("#tinum_val").attr("value",issue_id);
						var str = "" + issue_id;
						var pad = "000000";
						var ord="TCKT"+pad.substring(0, pad.length - str.length) + str;
						$("#heading").html(ord);
						$("#tinum").html(ord);
										
						$("#i_cat").val(obj['TICAT']);
						$("#i_prior").val(obj['TIPRI']);
						$("#i_desc").val(obj['TIDEC']);
						$("#i_detail").val(obj['TIDET']);
						if(obj['TIFIL']!='a' && obj['TIFIL']!='')
						{	
							$("#p_img").show();
							$("#download_file").val(obj['TIFIL']);
						}
						else
						{
							$("#p_img").hide();
						}
						
						$("#i_status").val(obj['TISTA']);
						$("#i_assigned_to").val(obj['TIATO']);
						
						/* $("#i_status option").filter(function() {
							//may want to use $.trim in here
							return $(this).text() == obj['TISTA']; 
						}).attr('selected', true);
						
						$("#i_assigned_to option").filter(function() {
							//may want to use $.trim in here
							return $(this).text() == obj['TIATO']; 
						}).attr('selected', true); */
						
						$("#i_remark").prop('disabled',false);
						$("#i_remark").val(obj['TIREM']);
						$("#i_remark").prop('disabled',true);
					
						// $("#all")[0].reset();
							$("#myModal").show();
							$("#myModal").addClass('in');
							
							var $div = $('<div />').appendTo('body');
							$div.attr('class','modal-backdrop fade in');
					});
			}
			function delete_item(id)
				{
					$("#"+id).hide();
					data='table_name=product_attribute&field_name=NodeID&id='+id;
					$.ajax({
									type: "POST",				
									url: "delete_entery.php",
									data:data
									}).done(function( msg )
										{	
											//alert(msg);
										});
				}	
				function line_edit(id){
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
							$("#field_id").val(obj['NodeID']);
							$("#node_name").val(obj['NodeName']);
							$("#node_description").val(obj['NodeDescription']);
							$("#node_type").val(obj['NodeType']);
							
							$(".select1 .chzn-single span").html(obj['NodeType']);
							$(".select2 .chzn-single span").html(obj['SupervisorID']);
							$(".select3 .chzn-single span").html(obj['HandlingUnit']);
							$(".select4 .chzn-single span").html(obj['Equipments']);
							
							$("#node_identifier").val(obj['NodeIdentifier']);
							$("#node_duns").val(obj['Duns']);
							$("#node_dunsuffix").val(obj['DunsSuffix']);
							
							$("#node_supervisor").val(obj['SupervisorID']);
							$("#node_company").val(obj['Company']);
							$("#node_street1").val(obj['StreetAddress1']);
							$("#node_street2").val(obj['StreetAddress2']);
							$("#node_city").val(obj['City']);
							$("#node_state").val(obj['State']);
							$("#node_country").val(obj['Country']);
							$("#node_zip").val(obj['ZipCode']);
							$("#node_capcity").val(obj['NodeCapcity']);
							$("#node_handling").val(obj['HandlingUnit']);
							$("#node_equipment").val(obj['Equipments']);
							$("#ncid").val(obj['NDCID']);
							$("#longitude").val(obj['NDLON']);
							$("#latitude").val(obj['NDLAT']);
						});
				}
				
				$( "#product_li" ).click(function() 
				{
					$( "#product_ul" ).slideToggle(1000);
				});
				
				$( "#node_li" ).click(function() {
					$( "#node_ul" ).slideToggle(1000);
				});

				function hide()
				{					
					$("#myModal").hide();
					$(".fade").removeClass('in');
					$( ".modal-backdrop" ).remove();					
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

					function deletentries()
					{
						var r = confirm("Are you sure you want to delete these entries ?");
						if (r == true) 
						{
							
							var str = JSON.stringify(checklistjson);
							$.ajax({
								type: "POST",
								url: "delete_check.php",
								data: {local:str, table:"help_support", column:"id"}
							})
							.done(function( msg ){
							//	alert(msg);
								for(i=0;i<checklist.length;i++){
									$("#"+checklist[i]).hide();
								}
								checklistjson = [];
								checklist = [];
							});
						}
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
					s= "\r\n<?php echo date('d-m-Y');echo "--".$_SESSION['name']; ?>"+" Created issue on "+output;
				}else if($("#i_status").val() == "Assigned"){
					s= "\r\n<?php echo date('d-m-Y');echo "--".$_SESSION['name']; ?>"+" Assigned issue to "+$("#i_assigned_to").val();
				}else if($("#i_status").val() == "In progress"){
					s= "\r\n<?php echo date('d-m-Y');echo "--".$_SESSION['name'];?>"+" changed status to In Progess";
				}else if($("#i_status").val() == "On Hold"){
					s= "\r\n<?php echo date('d-m-Y');echo "--".$_SESSION['name']; ?>"+" put the issue on Hold";
				}else if($("#i_status").val() == "Closed")
				{
					s= "\r\n<?php echo date('d-m-Y');echo "--".$_SESSION['name']; ?>"+" Closed the issue";
					$("#resolved_on").val('<? echo date('m/d/Y');?>');
				}
				else if($("#i_status").val() == "Ready for test")
				{
					s= "\r\n<?php echo date('d-m-Y');echo "--".$_SESSION['name']; ?>"+" changed status to Ready for test";
				}
				document.getElementById("i_remark").value +=s;				
			});
				function open_attachment()
				{
				var name=$("#download_file").val();
				window.open("http://antloc.com/dba/admin/upload/"+name, '_blank');
			}
					function add_new_function()
					{	
						$("#add_edit").val(0);					
						$("#all")[0].reset();
						$("#i_status").val('Created');
						$("#i_assigned_to").val('Gundeep Singh');
						$("#heading").html('Add New Ticket');
						$.ajax({
							type: "POST",
							url: "get_max_id.php"
						})
						.done(function( msg ){
							$("#tinum").html(msg);							
						});
					}
					function deletentriesall()
					{
						var r = confirm("Are you sure you want to delete these entries ?");
						if (r == true) 
						{
							var str = JSON.stringify(checklistjson);
							/* $.ajax({
								type: "POST",
								url: "delete_check.php",
								data: {local:str, table:"help_support", column:"id"}
							})
							.done(function( msg ){
							//	alert(msg);
								for(i=0;i<checklist.length;i++){
									$("#"+checklist[i]).hide();
								}
								checklistjson = [];
								checklist = [];
							}); */
						}
					}
					$("#download_csv").on("click", function(e){
						
						location.href="dba_export_csv_ticket.php?type=help_support&list="+checklist+"&page_name=Tickets&action=submit&type_nam=id";			
					});
					
					$("#download_csv_all").on("click", function(e){
						location.href="dba_export_csv_ticket.php?type=help_support&list&page_name=Tickets&action=submit&type_nam=id";			
					});
					
				function capture() {
					$("#i_remark").prop('disabled',false);
					$('#myModal').html2canvas({
						onrendered: function (canvas) {
							
							$('#img_val').val(canvas.toDataURL("image/png"));//alert(canvas.toDataURL("image/png"));
							//Submit the form manually
							document.getElementById("all").submit();
						}
					});
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
			</script>
		
	
			<style>
				.uploader 
				{
					float:left;
				}
			</style>