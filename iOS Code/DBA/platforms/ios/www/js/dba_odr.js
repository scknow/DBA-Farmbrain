var info_notify_bool = false;
var days_of_week=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
function get_order_list2()
{
	var str = "<option value=''>All</option>";
	for(i=0;i<sup_obj.length;i++){
		str = str + "<option value='"+sup_obj[i].supplierid+"'>"+sup_obj[i].businessname+"</option>";
	}
	$("#order_list_supplier_filter").html(str);
	get_order_list();
}

function get_order_list()
{
	$("#order_li1").removeClass();
	$("#order_li2").removeClass();
	$("#order_li3").removeClass();
	$("#order_li4").removeClass();
	$("#order_li5").removeClass();
	$("#order_li6").removeClass();
	$("#order_li1").addClass('active-footer-down1');
	
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"order_list.php",
		data: {customer:customerid}
	})
	.done(function(msg){
	// alert(msg);		
		end_loading();
		var str = "";
		var jsn = JSON.parse(msg);
		var selected_supplier = $("#order_list_supplier_filter").val();
		//alert("length------"+selected_supplier);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			
			var currentdate = new Date(); 
			var time = 	currentdate.getFullYear() + "/"
						+(currentdate.getMonth()+1) + "/" 
						+ currentdate.getDate();
			
			
			if(row.confirmeddeliverydate=='0000-00-00'){var receive_truck_date2 = row.reqdeldt.split("-");
			var receive_truck_date1 = receive_truck_date2[0]+"/"+receive_truck_date2[1]+"/"+receive_truck_date2[2]}
			else{
			var receive_truck_date2 = row.confirmeddeliverydate.split("-");
			var receive_truck_date1 = receive_truck_date2[0]+"/"+receive_truck_date2[1]+"/"+receive_truck_date2[2];}
			
			var date1 = new Date(receive_truck_date1);
			var date2 = new Date(time);
			//alert(date1+"==="+date2)
			var timeDiff = Math.abs(date1.getTime() - date2.getTime());
			var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
			
			var indx = s_index.indexOf(row.supplierid);
			if(selected_supplier!=''){
				if(selected_supplier!=row.supplierid){
					indx = -1;
				}
			}
			if(indx!=-1){
				
				var detail_str = "";
				var jsn_qty = row.qty;
				var jsn_pid = row.pid;
				var jsn_man = row.manufact;
				var jsn_bar = row.brand;
				var jsn_upr = row.u_price;
				var jsn_recives = row.jsn_recive;
				
				//alert(jsn_pid+"---"+jsn_qty);
				jsn_pid = jsn_pid.split(",");
				jsn_qty = jsn_qty.split(",");
				jsn_man = jsn_man.split(",");
				jsn_bar = jsn_bar.split(",");
				jsn_upr = jsn_upr.split(",");
				jsn_recive = jsn_recives.split(",");
				//alert(jsn_qty);
				var total_qty_orderd = 0;
				
				for (var ijk = 0; ijk < jsn_qty.length; ijk++) {
					if(jsn_qty[ijk]!='')
					{ total_qty_orderd+=parseInt(jsn_qty[ijk]);}
				}

				for(r=0;r<jsn_pid.length;r++){
					var inx = p_index.indexOf(jsn_pid[r]);
					if(inx!=-1){
					var kyu = tocurrency(parseFloat(parseFloat(jsn_qty[r])* parseFloat(jsn_upr[r])).toFixed(2));					
					var pid = obj[inx].productlabel;
					
					
					
					if(row.receivestatus==1)
					{
						
						var kyu1 = tocurrency(parseFloat(parseFloat(jsn_recive[r])* parseFloat(jsn_upr[r])).toFixed(2));
						
						detail_str = detail_str +"<tr class='hide_detail detail_op"+row.orderid+"' style='display:none; background:silver' ><td class='one' ><p>"+pid+"<b>"+jsn_man[r]+"/"+jsn_bar[r]+"</b></p><div class='drop-1'><div class='open-info-main1'> </div></b></div></td><td class='large-width'><p>Ordered Qty: "+jsn_qty[r]+"</p><br/><p>Received Qty: "+jsn_recive[r]+"</p><br><p>Unit Price: $"+tocurrency(jsn_upr[r])+"</p><br/><p>Total amount(ordered value): $"+kyu+"</p><br/><p>Total amount(Received Value): $"+kyu1+"</p></td><td class='small-width'></td></tr>";
					}
					else
					{
						detail_str = detail_str +"<tr class='hide_detail detail_op"+row.orderid+"' style='display:none; background:silver' ><td class='one' ><p>"+pid+"<b>"+jsn_man[r]+"/"+jsn_bar[r]+"</b></p><div class='drop-1'><div class='open-info-main1'> </div></b></div></td><td class='large-width'><p>Qty: "+jsn_qty[r]+"</p><br/><p>Unit Price: $"+tocurrency(jsn_upr[r])+"</p><br/><p>Total: $"+kyu+"</p></td><td class='small-width'></td></tr>";
					}
				}
				}
				var pad = "000000";
				var ord="DBAO"+pad.substring(0, pad.length - row.orderid.length) + row.orderid;
				var ctime = row.reqdeldt.split(" ");
				var d = new Date(ctime);
				var ctime2 = ""+(d.getMonth()+1)+"/"+(d.getDate())+"/"+(d.getFullYear());
				var n = d.getDay();
				var days_week=days_of_week[n];
				var detail = sup_obj[indx];
				if(row.active==1){
					str = str+"<tr onclick='detail_first("+row.orderid+")' class='contain_tr'><td>"+detail.businessname+"<b>"+ord+"</b></td><td><b>"+days_week+"</b><b>"+ctime2+"<b>"; //ctime[0]
					if(row.confirmationstatus==0){
						if(row.receivestatus==1){
							str = str + "Received </b></td><td><u>$"+tocurrency(row.totalfinal)+"<b>Total received:"+row.total_received_for_list+"<br> Short : "+row.short_for_list+"<br> Driver name :"+row.drivername+"</b></u></td></tr>";
						}else{
							if(diffDays>1)
							{
								str = str + "Pending </b></td><td><u>$"+tocurrency(row.totalfinal)+"<br><b>Ordered Qty:"+total_qty_orderd+"</b></u><center><i><img src='images/edit.png' onclick=get_edit_detail('"+row.orderid+"','"+row.confirmeddeliverydate+"','"+row.supplierid+"') /></i><i><img src='images/truck.png' onclick=get_order_detail('"+row.orderid+"','"+row.supplierid+"','"+row.confirmeddeliverydate+"') /></i></center></td></tr>";
							}else{
								str = str + "Pending </b></td><td><u>$"+tocurrency(row.totalfinal)+"<br><b>Ordered Qty:"+total_qty_orderd+"</b></u><center><i></i><i><img src='images/truck.png' onclick=get_order_detail('"+row.orderid+"','"+row.supplierid+"','"+row.confirmeddeliverydate+"') /></i></center></td></tr>";
							}
						}
					}else{
						if(row.receivestatus==1){
							str = str + "Received </b></td><td><u>$"+tocurrency(row.totalfinal)+"<b>Total received:"+row.total_received_for_list+"<br> Short : "+row.short_for_list+"<br>Driver name :"+row.drivername+"</b></u></td></tr>";
						}else{
							if(diffDays>1){
								str = str + "Confirmed </b></td><td><u>$"+tocurrency(row.totalfinal)+"<br><b>Confirmed Qty:"+total_qty_orderd+"</b></u><center><i><img src='images/edit.png' onclick=get_edit_detail('"+row.orderid+"','"+row.confirmeddeliverydate+"','"+row.supplierid+"') /></i><i><img src='images/truck.png' onclick=get_order_detail('"+row.orderid+"','"+row.supplierid+"','"+row.confirmeddeliverydate+"') /></i></center></td></tr>";
							}else{
								str = str + "Confirmed </b></td><td><u>$"+tocurrency(row.totalfinal)+"<br><b>Confirmed Qty:"+total_qty_orderd+"</b></u><center><i></i><i><img src='images/truck.png' onclick=get_order_detail('"+row.orderid+"','"+row.supplierid+"','"+row.confirmeddeliverydate+"') /></i></center></td></tr>";
							}
						}
					}
				}else{
					str = str+"<tr onclick='detail_first("+row.orderid+")' class='contain_tr' ><td>"+detail.businessname+"<b>"+ord+"</b></td><td><b>"+days_week+"</b>"+ctime[0]+"<b>";
					str = str + "Cancelled </b></td><td><u>$"+tocurrency(row.totalfinal)+"</u><center><i></i><i></i></center></td></tr>";
				}
				
				str = str + detail_str;
			}
		}
		$("#order_list_table").html(str);
		
		if(info_notify_bool){
			open_notify_order();
		}
	});
}

function search_order_box(){

	var txt = $("#search_order_txtbox").val();
	//alert(txt);
	if(txt==''){
		$('.contain_tr').show();
	}else{
		$('.contain_tr').hide();
		$('tr:containsIN("'+txt+'")').show();
		$('.hide_detail').hide();
	}	
}

function search_catalog_txtbox(){

	var txt = $("#search_catalog_txtbox").val();
	//alert(txt);
	if(txt==''){
		$('.contain_tr_catlog').show();
	}else{
		$('.contain_tr_catlog').hide();
		$('li:containsIN("'+txt+'")').show();
		$('.contain_tr_catlog_hide').hide();
		
	}	
}

function search_profile_box(){
	var txt = $("#search_profile_txtbox").val();
	//alert(txt);
	if(txt==''){
		$('.profile_contain_tr').show();
	}else{
		$('.profile_contain_tr').hide();
		//$('tr:has(td:contains("'+txt+'"))').show();
		$('tr:containsIN("'+txt+'")').show();
	}
}

function search_co_box(){
	var txt = $("#search_co_txtbox").val();
	//alert(txt);
	if(txt==''){
		$('.co_contain_tr').show();
	}else{
		$('.co_contain_tr').hide();
		//$('tr:has(td:contains("'+txt+'"))').show();
		$('.co_contain_tr:containsIN("'+txt+'")').show();
	}
}

function show_profile_list(){
	$('.save-save-as span').hide();
	$('.open-info-main1').hide();
	$('.short li').hide();
	$("#profile_list").toggle();
}
var receive_truck_num = 0;
var receive_truck_supid = 0;
var receive_truck_date = "";
function get_order_detail(id,supid,dat)
{
	
	$("#li_cancel_order").hide();
	$("#li_order_change").hide();
	$("#li_truck_image").show();
	receive_truck_num = id;
	receive_truck_supid = supid;
	var sinrx = s_index.indexOf(supid);
	var sinrx1 = s_index.indexOf(parseInt(supid));
	//alert(sinrx)
	var pad = "000000";
	
	var ord = "DBAO"+pad.substring(0, pad.length - id.length) + id;
	var kgtr = "<li>Order Id: <b>"+ord+"</b></li><li>Requested Delivery Date: <input type='date' value='"+dat+"' id='date_req_edit' class='date_pic' readonly/></li>";
	
	receive_truck_date = dat;
	
	$("#detail_header_name").html(kgtr);
		
	if(sinrx!=-1 || sinrx1!=-1){
		$("#detail_suplier_name").html(sup_obj[sinrx].businessname);
	}
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"get_order_detail.php",
		data: {orderid:id}
	})
	.done(function(msg){
		end_loading();
		var str = "";
		var jsn = JSON.parse(msg);
		edit_order_data = [];
		edit_order_index = [];
		var receive_all=0;
		
		for(i=0;i<jsn.length;i++)
		{
			var row = jsn[i];
			var indx = p_index.indexOf(row.productid);
			var edit_data = {
				id : row.orderdetailid,
				qty : row.quantity
			}
			edit_order_index.push(parseInt(row.orderdetailid));
			edit_order_data.push(edit_data);
			if(parseInt(row.receivedquantity)>0)
			{
				//alert(row.productid);
				var short_qty = parseInt(row.quantity) - parseInt(row.receivedquantity);
							
				if(short_qty>0){
					short_qty = short_qty +" Short";
				}else{
					short_qty = "Short";
				}
				str = str+"<tr><td class='one'>"+obj[indx].productlabel+"<b></b></p><big id='qty_ord"+row.orderdetailid+"'>Qty: "+row.quantity+"</big><div class='btns'><a href='#' id='short"+row.orderdetailid+"'>"+short_qty+"</a><a href='#' onclick='capturePhoto("+row.orderdetailid+")'>Damage</a>";
				
				if(row.substitutewithproductid!=0 && row.substitutewithproductid!=-1){
					str = str+"<a href='#'>"+row.substitutewithproductid+"</a>";
				}
				if(row.confirmedquantity!=0)
				{
					str = str+"</div></td><td class='large-width'><span>+</span><input disabled value='"+row.confirmedquantity+"' type='text' /><span>-</span><br /><h3>Confirmed</h3><span>+</span><input id='reciqty"+row.orderdetailid+"' value='"+row.receivedquantity+"' type='number' disabled /><span>-</span><h3>Received</h3></td><td class='small-width'><u></u></td></tr>";
				}
				else
				{
					str = str+"</div></td><td class='large-width'><span>+</span><input disabled value='"+row.quantity+"' type='text' /><span>-</span><br /><h3>Ordered Qty</h3><span>+</span><input id='reciqty"+row.orderdetailid+"' value='"+row.receivedquantity+"' type='number' disabled /><span>-</span><h3>Received</h3></td><td class='small-width'><u></u></td></tr>";
					
				}
				
			}
			else
			{
				receive_all++;
				if(row.confirmedquantity==0)
				{
					var short_qty =0;
				}
				else
				{
					var short_qty = parseInt(row.quantity) - parseInt(row.receivedquantity);
				}
				if(short_qty>0){
					short_qty = short_qty +" Short";
				}else{
					short_qty = "Short";
				}
				
				str = str+"<tr><td class='one'>"+obj[indx].productlabel+"<b></b></p><big id='qty_ord"+row.orderdetailid+"'>Qty: "+row.quantity+"</big><div class='btns'><a href='#' id='short"+row.orderdetailid+"'>"+short_qty+"</a><a href='#' onclick='capturePhoto("+row.orderdetailid+")'>Damage</a>"
				
				if(row.substitutewithproductid!=0 && row.substitutewithproductid!=-1){
					str = str+"<a href='#'>"+row.substitutewithproductid+"</a>";
				}
				if(row.confirmedquantity==0)
				{
					str = str+"</div></td><td class='large-width'><span>+</span><input disabled value='"+row.quantity+"' type='text' /><span>-</span><br /><h3>Ordered Qty</h3><span onclick='incrs_revsd_qty("+row.orderdetailid+")' >+</span><input id='reciqty"+row.orderdetailid+"' value='"+row.quantity+"' onClick='this.select();' onchange='up_revsd_qty("+row.orderdetailid+")' type='number' /><span onclick='decrs_revsd_qty("+row.orderdetailid+")'>-</span><h3>Received</h3></td><td style='position:relative;height:120px;' class='small-width'><u><img style='position:absolute;bottom:0;' onclick='receive_small_turck("+row.orderdetailid+")' src='images/truck1.png' /></u></td></tr>";
				}
				else
				{
					str = str+"</div></td><td class='large-width'><span>+</span><input disabled value='"+row.confirmedquantity+"' type='text' /><span>-</span><br /><h3>Confirmed</h3><span onclick='incrs_revsd_qty("+row.orderdetailid+")' >+</span><input id='reciqty"+row.orderdetailid+"' onClick='this.select();' onchange='up_revsd_qty("+row.orderdetailid+")' value='"+row.quantity+"' type='number' /><span onclick='decrs_revsd_qty("+row.orderdetailid+")'>-</span><h3>Received</h3></td><td style='position:relative;height:120px;' class='small-width'><u><img style='position:absolute;bottom:0;' onclick='receive_small_turck("+row.orderdetailid+")' src='images/truck1.png' /></u></td></tr>";
				}
			}			
		}
		
		$("#order_detail_table").html(str);
		$("#"+TBH).hide();
		$("#order_detail_div").show();
		//alert(TBH);
		if(TBH=='order_detail_div')
		{
			var ifTBHexits = backArr.indexOf(TBH);
			if(ifTBHexits==-1)
			{
				//backArr.push(TBH);
			}
		}
		else
		{
			backArr.push(TBH);
		}

		TBH = "order_detail_div";
		//alert(receive_all);
		if(receive_all==0)
		{
			backArr.push(TBH);
			receive_order_turck();
		}
	});
}
var edit_order_data = new Array();
var edit_order_index = new Array();
function get_edit_detail(id,dat,supid){
	//alert(id);
/* 	$('.date_pic').mobiscroll().date({
		theme: 'android',
		display: 'modal',
		mode: 'scroller',
		animate: 'fade',
	}); */
	$("#li_cancel_order").show();
	$("#li_order_change").show();
	$("#li_truck_image").hide();
	receive_truck_num = id;
	receive_truck_date = dat;
	
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"get_order_detail.php",
		data: {orderid:id}
	})
	.done(function(msg){
		var pad = "000000";
		var ord = "DBAO"+pad.substring(0, pad.length - id.length) + id;
		var kgtr = "<li>Order Id: <b>"+ord+"</b></li><li>Requested Delivery Date: <input type='date' value='"+dat+"' id='date_req_edit' class='date_pic'/></li>";
		
		$("#detail_header_name").html(kgtr);
		end_loading();
		
		
		var sinrx = s_index.indexOf(supid);
		var sinrx1 = s_index.indexOf(parseInt(supid));
		if(sinrx!=-1 || sinrx1!=-1)
		{
			$("#detail_suplier_name").html(sup_obj[sinrx].businessname);
		}
		
		var str = "";
		var jsn = JSON.parse(msg);
		edit_order_data = [];
		edit_order_index = [];
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			var indx = p_index.indexOf(row.productid);
			//alert(row.productid);
			if(indx!=-1){
			var edit_data = 
			{
				id : row.orderdetailid,
				qty : row.quantity
			}
			edit_order_index.push(parseInt(row.orderdetailid));
			edit_order_data.push(edit_data);
				if(row.receivedquantity!=0)
				{
					str = str+"<tr id='itemtr"+row.orderdetailid+"' ><td class='one'><p>"+obj[indx].productlabel+"<b id='qty_ord"+row.orderdetailid+"'>Qty : "+row.quantity+"</b></p><div class='drop-1'><div class='open-info-main1'></div></b></div></td><td class='large-width'><span>+</span><input id='reciqty"+row.orderdetailid+"' value='"+row.quantity+"' type='number' disabled/><span>-</span></td></tr>";
				}
				else
				{
					str = str+"<tr id='itemtr"+row.orderdetailid+"' ><td class='one'><p>"+obj[indx].productlabel+"<b id='qty_ord"+row.orderdetailid+"'>Qty : "+row.quantity+"</b></p><div class='drop-1'><div class='open-info-main1'></div></b></div></td><td class='large-width'><span onclick='incrs_revsd_qty("+row.orderdetailid+")' >+</span><input id='reciqty"+row.orderdetailid+"' onClick='this.select();' value='"+row.quantity+"' type='number' onchange='up_revsd_qty("+row.orderdetailid+")' /><span onclick='decrs_revsd_qty("+row.orderdetailid+")' >-</span></td><td class='small-width'><u><img onclick='cancel_order_item("+row.orderdetailid+")' src='images/delete.png' /></u></td></tr>";

						
				}				
			}
		}
		
		$("#order_detail_table").html(str);
		$("#"+TBH).hide();
		$("#order_detail_div").show();
		backArr.push(TBH);
		TBH = "order_detail_div";
	});
}

var cancel_item_id="";
function cancel_order_item(id){
	cancel_item_id = id;
	navigator.notification.confirm(
			'Are you sure you want to delete this?',  // message
			oncancel_item,              // callback to invoke with index of button pressed
			'DBA',            // title
			'No, Yes'          // buttonLabels
	);
}

function oncancel_item(button){
	if(button==2){
		if(edit_order_data.length==1){
			oncancel_order_turck(2);
		}else{
			start_loading();
			$.ajax({
				type: "GET",
				url: base_url+"cancel_item.php",
				data: {odid:cancel_item_id, action:"item", order:receive_truck_num}
			})
			.done(function(msg){
				//alert(msg);
				//end_loading();
				//This can cause error
				get_edit_detail(receive_truck_num,receive_truck_date,'');
				//$("#itemtr"+cancel_item_id).hide();
			});
		}
	}
}

function edit_order_save(){
	navigator.notification.confirm(
			'Are you sure you want to save changes?',  // message
			onedit_order_save,              // callback to invoke with index of button pressed
			'DBA',            // title
			'No, Yes'          // buttonLabels
	);
}


function onedit_order_save(button){
if(button==2){
	var jsn_str = JSON.stringify(edit_order_data);
	//alert(jsn_str);
	start_loading();
	var req_date_edit=$("#date_req_edit").val();
	$.ajax({
		type: "GET",
		url: base_url+"cancel_item.php",
		data: {jsn:jsn_str, action:"edit",date:req_date_edit,order:receive_truck_num}
	})
	.done(function(msg){
		end_loading();		
		obj=msg.split("^^^");
		var date_f=obj[0].trim();
		alert( date_f +" for Delivery "+obj[1].trim()+" has been updated and "+obj[2].trim()+" notified");
		//alert("Order updated");
		loading();
		get_order_list2();		
		onBackKeyDown();
		
	});
	
	}
}

function up_revsd_qty(id)
{	
	
	var qty = $("#reciqty"+id).val();

	edit_order_data[edit_order_index.indexOf(id)].qty = qty;	
	var value=$("#qty_ord"+id).html();
	var qty_vl=value.split(":");
	var short_qty_ordr=qty_vl[1]-qty;
	$("#short"+id).html(short_qty_ordr+" Short");
}                                  

function incrs_revsd_qty(id){

	var qty = $("#reciqty"+id).val();
	qty++;
	$("#reciqty"+id).val(qty);
	edit_order_data[edit_order_index.indexOf(id)].qty = qty;
	var value=$("#qty_ord"+id).html();	
	var qty_vl=value.split(":");
	var short_qty_ordr=qty_vl[1]-qty;
	$("#short"+id).html(short_qty_ordr+" Short");
}

function decrs_revsd_qty(id){
	var qty = $("#reciqty"+id).val();
	if(qty>0)
	{
		qty--;
		$("#reciqty"+id).val(qty);
		edit_order_data[edit_order_index.indexOf(id)].qty = qty;		
		var value=$("#qty_ord"+id).html();
		var qty_vl=value.split(":");
		var short_qty_ordr=qty_vl[1]-qty;
		$("#short"+id).html(short_qty_ordr+" Short");
	}
}

function receive_order_turck()
{
	var driver_name = prompt("Please enter driver name: ","");
	start_loading();
	var jsn_str = JSON.stringify(edit_order_data);	//alert(jsn_str);
	
	$.ajax({
		type: "GET",
		url: base_url+"receive_order.php",
		data: {oid:receive_truck_num, jsn:jsn_str, action:'whole',dname:driver_name}
	})
	.done(function(msg)
	{
		
		alert(msg+ " delivery has been received and "+name_customer+" has been notified");
		//alert("Order has been received");
		end_loading();
		onBackKeyDown();
		get_order_list();
	});
	
}

function cancel_order_turck(){
	navigator.notification.confirm(
			'Canceling the order will delete the order in progress. Countinue?',  // message
			oncancel_order_turck,              // callback to invoke with index of button pressed
			'DBA',            // title
			'No, Yes'          // buttonLabels
	);
}

function oncancel_order_turck(button){
if(button==2){
	var currentdate = new Date(); 
	var time = 	currentdate.getFullYear() + "/"
                +(currentdate.getMonth()+1) + "/" 
                + currentdate.getDate();
				
	var receive_truck_date2 = receive_truck_date.split("-");
	var receive_truck_date1 = receive_truck_date2[0]+"/"+receive_truck_date2[1]+"/"+receive_truck_date2[2];
	//alert(receive_truck_date1);
	var date1 = new Date(receive_truck_date1);
	var date2 = new Date(time);
	//alert(date1+"==="+date2)
	var timeDiff = Math.abs(date1.getTime() - date2.getTime());
	var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
	//alert(diffDays);
	if(diffDays>=1){
		start_loading();
		$.ajax({
			type: "GET",
			url: base_url+"receive_order.php",
			data: {oid:receive_truck_num, action:'cancel'}
		})
		.done(function(msg){
			//alert(msg);
			end_loading();
			alert("Order has been cancelled");
			onBackKeyDown();
			get_order_list();
		});
	}else{
		alert("Order can not be cancel now");
	}
}
}

function receive_small_turck(id){
var qth = $("#reciqty"+id).val();
if(qth>0){
	start_loading();
	
	$.ajax({
		type: "GET",
		url: base_url+"receive_order.php",
		data: {oid:id, qty:qth, action:'item'}
	})
	.done(function(msg){
		get_order_detail(receive_truck_num,receive_truck_date,receive_truck_supid);
	});
}else{
	alert("quantity is zero");
}
}

function order_active_li(id){
	$("#order_li1").removeClass();
	$("#order_li2").removeClass();
	$("#order_li3").removeClass();
	$("#order_li4").removeClass();
	$("#order_li5").removeClass();
	$("#order_li6").removeClass();
	$("#order_li"+id).addClass('active-footer-down1');
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"order_list.php",
		data: {customer:customerid}
	})
	.done(function(msg){
		
		end_loading();
		//alert(msg);
		var str = "";
		var jsn = JSON.parse(msg);
		var selected_supplier = $("#order_list_supplier_filter").val();
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			
			var pad = "000000";
			var ord="DBAO"+pad.substring(0, pad.length - row.orderid.length) + row.orderid;
			
			var currentdate = new Date(); 
			var time = 	currentdate.getFullYear() + "/"
						+(currentdate.getMonth()+1) + "/" 
						+ currentdate.getDate();
						
			// var receive_truck_date2 = row.confirmeddeliverydate.split("-");
			// var receive_truck_date1 = receive_truck_date2[0]+"/"+receive_truck_date2[1]+"/"+receive_truck_date2[2];
			
			if(row.confirmeddeliverydate=='0000-00-00')
			{
			var receive_truck_date2 = row.reqdeldt.split("-");
			var receive_truck_date1 = receive_truck_date2[0]+"/"+receive_truck_date2[1]+"/"+receive_truck_date2[2]
			}
			else{
			var receive_truck_date2 = row.confirmeddeliverydate.split("-");
			var receive_truck_date1 = receive_truck_date2[0]+"/"+receive_truck_date2[1]+"/"+receive_truck_date2[2];}
			
			//alert(receive_truck_date1);
			var date1 = new Date(receive_truck_date1);
			var date2 = new Date(time);
			//alert(date1+"==="+date2)
			var timeDiff = Math.abs(date1.getTime() - date2.getTime());
			var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
			
			/* if(row.confirmationstatus==0){
				diffDays = 2;
			} */
			
			
			var indx = s_index.indexOf(row.supplierid);
			if(selected_supplier!=''){
				if(selected_supplier!=row.supplierid){
					indx = -1;
				}
			}
			if(indx!=-1)
			{
			var detail_str = "";
				var jsn_qty = row.qty;
				var jsn_pid = row.pid;
				var jsn_man = row.manufact;
				var jsn_bar = row.brand;
				var jsn_upr = row.u_price;
				var jsn_recive = row.jsn_recive;
				//alert(jsn_pid+"---"+jsn_qty);
				jsn_pid = jsn_pid.split(",");
				jsn_qty = jsn_qty.split(",");
				jsn_man = jsn_man.split(",");
				jsn_bar = jsn_bar.split(",");
				jsn_upr = jsn_upr.split(",");
				jsn_recive = jsn_recive.split(",");
				//alert(jsn_qty);
				for(r=0;r<jsn_pid.length;r++){
					var inx = p_index.indexOf(jsn_pid[r]);
					if(inx!=-1){
					var kyu = parseFloat(parseFloat(jsn_qty[r])* parseFloat(jsn_upr[r])).toFixed(2);
					var pid = obj[inx].productlabel;
					//detail_str = detail_str +"<tr class='hide_detail detail_op"+row.orderid+"' style='display:none; background:silver' ><td class='one' ><p>"+pid+"<b>"+jsn_man[r]+"/"+jsn_bar[r]+"</b></p><div class='drop-1'><div class='open-info-main1'> </div></b></div></td><td class='large-width'><p>Qty: "+jsn_qty[r]+"</p><br/><p>Unit Price: $"+jsn_upr[r]+"</p><br/><p>Total: $"+kyu+"</p></td><td class='small-width'></td></tr>";
					
					if(row.receivestatus==1)
					{
						var kyu1 = tocurrency(parseFloat(parseFloat(jsn_recive[r])* parseFloat(jsn_upr[r])).toFixed(2));
						detail_str = detail_str +"<tr class='hide_detail detail_op"+row.orderid+"' style='display:none; background:silver' ><td class='one' ><p>"+pid+"<b>"+jsn_man[r]+"/"+jsn_bar[r]+"</b></p><div class='drop-1'><div class='open-info-main1'> </div></b></div></td><td class='large-width'><p>Ordered Qty: "+jsn_qty[r]+"</p><br/><p>Received Qty: "+jsn_recive[r]+"</p><br><p>Unit Price: $"+tocurrency(jsn_upr[r])+"</p><br/><p>Total amount(ordered value): $"+kyu+"</p><br/><p>Total amount(Received Value): $"+kyu1+"</p></td><td class='small-width'></td></tr>";
					}
					else
					{
						detail_str = detail_str +"<tr class='hide_detail detail_op"+row.orderid+"' style='display:none; background:silver' ><td class='one' ><p>"+pid+"<b>"+jsn_man[r]+"/"+jsn_bar[r]+"</b></p><div class='drop-1'><div class='open-info-main1'> </div></b></div></td><td class='large-width'><p>Qty: "+jsn_qty[r]+"</p><br/><p>Unit Price: $"+tocurrency(jsn_upr[r])+"</p><br/><p>Total: $"+kyu+"</p></td><td class='small-width'></td></tr>";
					}
					
					}
				}
			
			var total_qty_orderd = 0;
				
				for (var ijk = 0; ijk < jsn_qty.length; ijk++) {
					if(jsn_qty[ijk]!='')
					{ total_qty_orderd+=parseInt(jsn_qty[ijk]);}
				}
				
			var ctime = row.reqdeldt.split(" ");
			var d = new Date(ctime);
			var n = d.getDay();
			var days_week=days_of_week[n];
			var detail = sup_obj[indx];
			var ctime2=date_format_change(ctime);
			if(id==1)
			{
				if(row.active==1){
					str = str+"<tr onclick='detail_first("+row.orderid+")'><td>"+detail.businessname+"<b>"+ord+"</b></td><td><b>"+days_week+"</b>"+ctime2+"<b>";
				if(row.confirmationstatus==0){
						if(row.receivestatus==1){
							str = str + "Received </b></td><td><u>$"+tocurrency(row.totalfinal)+"<b>Total received:"+row.total_received_for_list+"<br> Short : "+row.short_for_list+"<br> Driver name :"+row.drivername+"</b></u></td></tr>";
						}else{
							if(diffDays>1){
								str = str + "Pending </b></td><td><u>$"+tocurrency(row.totalfinal)+"<br><b>Ordered Qty:"+total_qty_orderd+"</b></u><center><i><img src='images/edit.png' onclick=get_edit_detail('"+row.orderid+"','"+row.confirmeddeliverydate+"','"+row.supplierid+"') /></i><i><img src='images/truck.png' onclick=get_order_detail('"+row.orderid+"','"+row.supplierid+"','"+row.confirmeddeliverydate+"') /></i></center></td></tr>";
							}else{
								str = str + "Pending </b></td><td><u>$"+tocurrency(row.totalfinal)+"<br><b>Ordered Qty:"+total_qty_orderd+"</b></u><center><i></i><i><img src='images/truck.png' onclick=get_order_detail('"+row.orderid+"','"+row.supplierid+"','"+row.confirmeddeliverydate+"') /></i></center></td></tr>";
							}
						}
					}else{
						if(row.receivestatus==1){
							str = str + "Received </b></td><td><u>$"+tocurrency(row.totalfinal)+"<b>Total received:"+row.total_received_for_list+"<br> Short : "+row.short_for_list+"<br>Driver name :"+row.drivername+"</b></u></td></tr>";
						}else{
							if(diffDays>1){
								str = str + "Confirmed </b></td><td><u>$"+tocurrency(row.totalfinal)+"<br><b>Confirmed Qty:"+total_qty_orderd+"</b></u><center><i><img src='images/edit.png' onclick=get_edit_detail('"+row.orderid+"','"+row.confirmeddeliverydate+"','"+row.supplierid+"') /></i><i><img src='images/truck.png' onclick=get_order_detail('"+row.orderid+"','"+row.supplierid+"','"+row.confirmeddeliverydate+"') /></i></center></td></tr>";
							}else{
								str = str + "Confirmed </b></td><td><u>$"+tocurrency(row.totalfinal)+"<br><b>Confirmed Qty:"+total_qty_orderd+"</b></u><center><i></i><i><img src='images/truck.png' onclick=get_order_detail('"+row.orderid+"','"+row.supplierid+"','"+row.confirmeddeliverydate+"') /></i></center></td></tr>";
							}
						}
					}
					}
			}else if(id==2){
				if(row.confirmationstatus==0 && row.active==1){
					if(row.receivestatus==1){
						//do nothing
					}else{
						if(diffDays>1){
							str = str+"<tr onclick='detail_first("+row.orderid+")'><td>"+detail.businessname+"<b>"+ord+"</b></td><td><b>"+days_week+"</b>"+ctime2+"<b>";
							str = str + "Pending </b></td><td><u>$"+tocurrency(row.totalfinal)+"<br><b>Ordered Qty:"+total_qty_orderd+"</b></u><center><i><img src='images/edit.png' onclick=get_edit_detail('"+row.orderid+"','"+row.confirmeddeliverydate+"','"+row.supplierid+"') /></i><i><img src='images/truck.png' onclick=get_order_detail('"+row.orderid+"','"+row.supplierid+"','"+row.confirmeddeliverydate+"') /></i></center></td></tr>";
						}else{
							str = str+"<tr onclick='detail_first("+row.orderid+")'><td>"+detail.businessname+"<b>"+ord+"</b></td><td><b>"+days_week+"</b>"+ctime2+"<b>";
							str = str + "Pending </b></td><td><u>$"+tocurrency(row.totalfinal)+"<br><b>Ordered Qty:"+total_qty_orderd+"</b></u><center><i></i><i><img src='images/truck.png' onclick=get_order_detail('"+row.orderid+"','"+row.supplierid+"','"+row.confirmeddeliverydate+"') /></i></center></td></tr>";
						}
					}
				}
			}else if(id==3){
				if(row.confirmationstatus==1 && row.active==1){
					if(row.receivestatus==1){
						// do nothing
					}else{
						if(diffDays>1){
							str = str+"<tr onclick='detail_first("+row.orderid+")'><td>"+detail.businessname+"<b>"+ord+"</b></td><td><b>"+days_week+"</b>"+ctime[0]+"<b>";
							str = str + "Confirmed </b></td><td><u>$"+tocurrency(row.totalfinal)+"<br><b>Confirmed Qty:"+total_qty_orderd+"</b></u><center><i><img src='images/edit.png' onclick=get_edit_detail('"+row.orderid+"','"+row.confirmeddeliverydate+"','"+row.supplierid+"') /></i><i><img src='images/truck.png' onclick=get_order_detail('"+row.orderid+"','"+row.supplierid+"','"+row.confirmeddeliverydate+"') /></i></center></td></tr>";
						}else{
							str = str+"<tr onclick='detail_first("+row.orderid+")'><td>"+detail.businessname+"<b>"+ord+"</b></td><td><b>"+days_week+"</b>"+ctime[0]+"<b>";
							str = str + "Confirmed </b></td><td><u>$"+tocurrency(row.totalfinal)+"<br><b>Confirmed Qty:"+total_qty_orderd+"</b></u><center><i></i><i><img src='images/truck.png' onclick=get_order_detail('"+row.orderid+"','"+row.supplierid+"','"+row.confirmeddeliverydate+"') /></i></center></td></tr>";
						}
					}
				}
			}else if(id==4){
				if(row.receivestatus==1 && row.active==1){
					str = str+"<tr onclick='detail_first("+row.orderid+")'><td>"+detail.businessname+"<b>"+ord+"</b></td><td><b>"+days_week+"</b>"+ctime[0]+"<b>";
					
					str = str + "Received </b></td><td><u>$"+tocurrency(row.totalfinal)+"<b>Total received:"+row.total_received_for_list+"<br> Short : "+row.short_for_list+"</b></u></td></tr>";
				}
			}else if(id==5){
				if(row.active==0){
					str = str+"<tr onclick='detail_first("+row.orderid+")'><td>"+detail.businessname+"<b>"+ord+"</b></td><td><b>"+days_week+"</b>"+ctime[0]+"<b>";
					str = str + "Cancelled </b></td><td><u>$"+tocurrency(row.totalfinal)+"</u><center><i></i><i></i></center></td></tr>";
				}
			}
			}
			str = str + detail_str;
		}
		str = str + detail_str;
		$("#order_list_table").html(str);
	});
}

function detail_first(id){
	$(".detail_op"+id).toggle();
}

function order_active_li_event(id){
	$("#order_li1").removeClass();
	$("#order_li2").removeClass();
	$("#order_li3").removeClass();
	$("#order_li4").removeClass();
	$("#order_li5").removeClass();
	$("#order_li6").removeClass();
	$("#order_li"+id).addClass('active-footer-down1');
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"get_event_order.php",
		data: {customer:customerid}
	})
	.done(function(msg){
		//alert(msg);
		end_loading();
		var str = "";
		var jsn = JSON.parse(msg);
		var selected_supplier = $("#order_list_supplier_filter").val();
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			var indx = s_index.indexOf(row.supplierid);
			if(indx!=-1)
			{
				var ctime = row.usedatetime.split(" ");
				
				str = str+"<tr><td>"+sup_obj[indx].businessname+"</td><td>"+ctime[0]+"<b>";
				str = str + "Event</b></td><td><u>"+row.eventid+"</u><center><i><img src='images/edit.png' onclick=order_event_detail('"+row.eventusageid+"') /></i><i><img src='images/truck.png' onclick=event_receive_detail('"+row.eventusageid+"') /></i></center></td></tr>";
			}
		}
		$("#order_list_table").html(str);
	});
}

function order_event_detail(id){
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"get_usevent_detail.php",
		data: {eid:id}
	})
	.done(function(msg){
		//alert(msg);
		end_loading();
		var str = "";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			var indx = p_index.indexOf(row.productid);
			if(indx!=-1){
				str = str+"<tr id='itemtr"+row.usagedetailid+"'><td class='one'><p>"+obj[indx].productlabel+"<b>"+row.quantity+"</b></p><div class='drop-1'><div class='open-info-main1'></div></b></div></td><td class='large-width'><span onclick='decrs_revsd_qty("+row.usagedetailid+")' >-</span><input id='reciqty"+row.usagedetailid+"' value='"+row.quantity+"' type='number' onClick='this.select();' /><span onclick='incrs_revsd_qty("+row.usagedetailid+")' >+</span></td><td class='small-width'><u><img onclick='cancel_order_item("+row.usagedetailid+")' src='images/delete.png' /></u></td></tr>";
			}
		}
		//alert(str);
		$("#order_detail_table").html(str);
		$("#"+TBH).hide();
		$("#order_detail_div").show();
		backArr.push(TBH);
		TBH = "order_detail_div";
	});
}

function event_receive_detail(id){
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"get_usevent_detail.php",
		data: {eid:id}
	})
	.done(function(msg){
		//alert(msg);
		end_loading();
		var str = "";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			var indx = p_index.indexOf(row.productid);
			//alert(row.productid);
			var short_qty = parseInt(row.quantity) - parseInt(row.receivedquantity);
			
			if(short_qty>0){
				short_qty = short_qty +" Short";
			}else{
				short_qty = "Short";
			}
			str = str+"<tr><td class='one'>"+obj[indx].productlabel+"<b></b></p><big id='qty_ord"+row.orderdetailid+"'>Qty: "+row.quantity+"</big><div class='btns'><a href='#'>"+short_qty+"</a><a href='#' onclick='capturePhoto("+row.orderdetailid+")'>Damage</a>"
			if(row.substitutewithproductid!=0){
				str = str+"<a href='#'>"+row.substitutewithproductid+"</a>";
			}
			str = str+"</div></td><td class='large-width'><span>-</span><input disabled value='"+row.confirmedquantity+"' type='text' /><span>+</span><br /><h3>Received</h3><span onclick='decrs_revsd_qty("+row.orderdetailid+")'>-</span><input id='reciqty"+row.orderdetailid+"' onClick='this.select();' value='"+row.receivedquantity+"' type='text' /><span onclick='incrs_revsd_qty("+row.orderdetailid+")' >+</span><h3>Confirmed</h3></td><td class='small-width'><u><img onclick='receive_small_turck("+row.orderdetailid+")' src='images/truck1.png' /></u></td></tr>";
		}
		$("#order_detail_table").html(str);
		$("#"+TBH).hide();
		$("#order_detail_div").show();
		backArr.push(TBH);
		TBH = "order_detail_div";
	});
}

var active_profile_ids = new Array();

function profile_default_setting(){
	var str ="<tr><td></td><td>DEFAULT</td><td>ACTIVE</td> <td colspan='2'>SETTINGS</td></tr>";
	start_loading();
	
	$.ajax({
		type: "POST",
		url: base_url+"get_profile_list.php",
		data: {customer:customerid}
	})
	.done(function(msg){
		//alert(msg);
		active_profile_ids = [];
		end_loading();
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			var strid = "" + row.id;
			var pad = "000000";
			var ord="DBAGP"+pad.substring(0, pad.length - strid.length) + strid;
			var temp = ord;
			ord = row.name;
			row.name = temp;
			if(row.type=='global'){
				if(row.active==1){
					active_profile_ids.push(parseInt(row.id));
					if(row.defaultp==1){
						str = str+"<tr class='profile_contain_tr'><td>"+ord+"<b>"+row.name+"</b></td><td><input type='radio' name='default' checked /></td><td><input checked type='checkbox' disabled /></td><td></td><td><a href='#'></a></td></tr>";
					}else{
						str = str+"<tr class='profile_contain_tr' ><td>"+ord+"<b>"+row.name+"</b></td><td><input type='radio' name='default' onclick='default_profile("+row.id+")' /></td><td><input onclick='active_profile("+row.id+",0)' checked type='checkbox' /></td><td></td><td><a href='#'></a></td></tr>";
					}
					
				}else{
					if(row.defaultp==1){
						str = str+"<tr class='profile_contain_tr' ><td>"+ord+"<b>"+row.name+"</b></td><td><input type='radio' name='default' checked /></td><td><input type='checkbox' disabled /></td><td></td><td><a href='#'></a></td></tr>";
					}else{
						str = str+"<tr class='profile_contain_tr' ><td>"+ord+"<b>"+row.name+"</b></td><td><input type='radio' name='default' onclick='default_profile("+row.id+")' /></td><td><input onclick='active_profile("+row.id+",1)' type='checkbox' /></td><td></td><td><a href='#'></a></td></tr>";
					}
				}
			}else{
				if(row.active==1){
					active_profile_ids.push(parseInt(row.id));
					if(row.defaultp==1){
						str = str+"<tr class='profile_contain_tr' ><td>"+ord+"<b>"+row.name+"</b></td><td><input type='radio' name='default' checked /></td><td><input checked type='checkbox' disabled /></td><td onclick='change_profile_name("+row.id+")'><a href='#'><img src='images/gear.png' /></a></td><td><a href='#'><img src='images/delete.png' onclick='delete_profile("+row.id+")' /></a></td></tr>";
					}else{
						str = str+"<tr class='profile_contain_tr' ><td>"+ord+"<b>"+row.name+"</b></td><td><input type='radio' name='default' onclick='default_profile("+row.id+")' /></td><td><input checked type='checkbox' onclick='active_profile("+row.id+",0)' /></td><td onclick='change_profile_name("+row.id+")'><a href='#'><img src='images/gear.png' /></a></td><td><a href='#'><img src='images/delete.png' onclick='delete_profile("+row.id+")' /></a></td></tr>";
					}
					
				}else{
					if(row.defaultp==1){
						str = str+"<tr class='profile_contain_tr' ><td>"+ord+"<b>"+row.name+"</b></td><td><input type='radio' name='default' checked /></td><td><input type='checkbox' disabled /></td><td onclick='change_profile_name("+row.id+")'><a href='#'><img src='images/gear.png' /></a></td><td><a href='#'><img src='images/delete.png' onclick='delete_profile("+row.id+")' /></a></td></tr>";
					}else{
						str = str+"<tr class='profile_contain_tr' ><td>"+ord+"<b>"+row.name+"</b></td><td><input type='radio' name='default' onclick='default_profile("+row.id+")' /></td><td><input onclick='active_profile("+row.id+",1)' type='checkbox' /></td><td onclick='change_profile_name("+row.id+")'><a href='#'><img src='images/gear.png' /></a></td><td><a href='#'><img src='images/delete.png' onclick='delete_profile("+row.id+")' /></a></td></tr>";
					}
				}
			}
		}
		$("#profile_setng_table").html(str);
	});
}

function active_profile(id, act){
	//start_loading();
	var indx = active_profile_ids.indexOf(id);
	//alert(indx);
	if(indx==-1){
		active_profile_ids.push(id);
	}else{
		active_profile_ids.splice(indx,1);
	}
	
	//var jsn = JSON.stringify(active_profile_ids);
	//alert(jsn);
	
	$.ajax({
		type: "GET",
		url: base_url+"change_profile_name.php",
		data: {customer_id:customerid, action:'active_new', active_array:active_profile_ids}
	})
	.done(function(msg){
		//end_loading();
			//alert(msg);
		//profile_default_setting();
	});
}

function default_profile(id){
	start_loading();
	var indx = active_profile_ids.indexOf(id);
	//alert(indx);
	if(indx==-1){
		active_profile_ids.push(id);
	}
	
	$.ajax({
		type: "GET",
		url: base_url+"change_profile_name.php",
		data: {default_profile_id:id, action:'default_new', customer_id:customerid, active_array:active_profile_ids}
	})
	.done(function(msg){
		end_loading();
			//alert(msg);
		profile_default_setting();
	});
}

function change_profile_name(id){
	var for_email = prompt("Change profile name: ","");
	if(for_email!=null){
		if(for_email!=""){
			start_loading();
			$.ajax({
				type: "GET",
				url: base_url+"change_profile_name.php",
				data: {pid:id, name:for_email, action:'update'}
			})
			.done(function(msg){
				end_loading();
				profile_default_setting();
			});
		}else{
			alert("Profile name can't be blank");
		}
	}
}

var dpid = '';
function delete_profile(id){
	dpid = id;
		navigator.notification.confirm(
			'Are you sure you want to delete this?',  // message
			ondelete,              // callback to invoke with index of button pressed
			'DBA',            // title
			'No, Yes'          // buttonLabels
		);
	}
	
function ondelete(button){
	if(button === 2)
		{   	
			start_loading();
			$.ajax({
				type: "GET",
				url: base_url+"change_profile_name.php",
				data: {pid:dpid, name:'nothing', action:'delete'}
			})
			.done(function(msg){
				end_loading();
				//alert(msg);
				profile_default_setting();
			});
		}
}

function get_event(){
start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"get_event.php",
		data: {customer_id:customerid}
	})
	.done(function(msg){
		//alert(msg);
		end_loading();
		var str ="<tr><td>Name</td><td>Max Quantity</td><td>Give away</td> </tr>";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			//alert(row.eventid);
			str = str+"<tr onclick=get_event_detail('"+row.eventid+"',"+row.maxquantity+")><td>"+row.eventname+"</td><td>"+row.maxquantity+"</td><td><u>$"+row.customergiveaway+"</u></td></tr>";
		}
		$("#event_list_table").html(str);
	});
}

var event_order_arr = new Array(); 
var event_id = "";
function get_event_detail(id,qty){
	//alert(id);
	menu_item('event_order_div');
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"get_event_detail.php",
		data: {eid:id}
	})
	.done(function(msg){
		//alert(msg);
		end_loading();
		event_id = id;
		event_order_arr = [];
		var str = "";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			var index = p_index.indexOf(row.productid);
			if(index!=-1){
				var detail = obj[index];
				var data = {
					id : row.productid,
					qty : 0
				}
				event_order_arr.push(data);
				str = str + "<tr><td class='one'><p>"+detail.productlabel+"<b>"+detail.packquantity+detail.unitofmeasure+"</b></p><div class='drop-1'><center></center><div class='open-info-main1'></div></b></div></td><td class='large-width'><span onclick='event_qty_minus("+i+")' >-</span><input type='number' value='0' id='event_qty"+i+"' onchange='event_qty_up("+i+","+qty+")' onClick='this.select();' /><span onclick='event_qty_plus("+i+","+qty+")'>+</span></td><td class='small-width'><u><img src='images/delete.png' /></u></td></tr>";
			}
		}
		$("#event_product_div").html(str);
		var kstr = "<option value=''>Select</option>";
		for(i=0;i<sup_obj.length;i++){
			kstr = kstr + "<option value='"+sup_obj[i].supplierid+"'>"+sup_obj[i].businessname+"</option>";
		}
		$("#event_supplier").html(kstr);
	});
}

function event_qty_plus(i,mqty){
//alert(mqty);
	var max = 0;
	for(j=0;j<event_order_arr.length;j++){
		max = max + parseInt(event_order_arr[j].qty);
	}
	if(max<mqty){
		event_order_arr[i].qty++
		$("#event_qty"+i).val(event_order_arr[i].qty);
	}else{

	}
}

function event_qty_minus(i){
	if(event_order_arr[i].qty>0){
		event_order_arr[i].qty--;
		$("#event_qty"+i).val(event_order_arr[i].qty);
	}
}

function event_qty_up(i,mqty){
	var max = 0;
	for(j=0;j<event_order_arr.length;j++){
		max = max + parseInt(event_order_arr[j].qty);
	}
	
	var qty = $("#event_qty"+i).val();
	//alert(qty+"---"+max+"---"+mqty);
	var n = parseInt(qty) + parseInt(max);
	//alert(n+"--"+mqty);
	if(n<mqty){
		event_order_arr[i].qty = qty;
	}else{
		$("#event_qty"+i).val(event_order_arr[i].qty);
	}
}

function send_event_order(){
var supplierid = $("#event_supplier").val();
if(supplierid!=""){
	start_loading();
	var jsn = JSON.stringify(event_order_arr);
	//alert(jsn);
	$.ajax({
		type: "POST",
		url: base_url+"place_event_order.php",
		data: {pro_data:jsn, id:event_id, customer:customerid, supplier:supplierid}
	})
	.done(function(msg){
		end_loading();
		event_order_arr = [];
		onBackKeyDown();
		get_event();
		alert("Event order has been placed");
	});
}
else{
	alert("Please select a supplier");
}
}

function notification(){
	start_loading();
	var from = $("#notify_last").val();
	$.ajax({
		type: "POST",
		url: base_url+"get_notification.php",
		data: {customer:customerid, last:from}
	})
	.done(function(msg){
		//alert(msg);
		end_loading();
		var str = "";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			if(row.readstatus==1){
			str = str + "<tr class='notify_tr' id='notify_"+row.notificationid+"'><td style='width: 33.3%;' onclick=info_notification('"+row.orderid+"',"+row.notificationid+") >"+row.message+"<b>"+row.notificationdatetime+"</b></td><td style='width: 33.3%;' onclick=info_notification('"+row.orderid+"',"+row.notificationid+") >"+row.notificatiototype+"-"+row.orderid+"</td><td style='width: 33.3%;'><img src='images/delete.png' onclick='delete_notification("+row.notificationid+")'></td></tr>";
			}
			else
			{
				str = str + "<tr class='notify_tr' id='notify_"+row.notificationid+"' style='background:#D4D4D4' ><td style='width: 33.3%;' onclick=info_notification('"+row.orderid+"',"+row.notificationid+") >"+row.message+"<b>"+row.notificationdatetime+"</b></td><td style='width: 33.3%;' onclick=info_notification('"+row.orderid+"',"+row.notificationid+")>"+row.notificatiototype+"-"+row.orderid+"</td><td style='width: 33.3%;'><img src='images/delete.png' onclick='delete_notification("+row.notificationid+")'></td></tr>";
			}
		}
		$("#notification_table").html(str);
		$('.not').hide();
		/*$.ajax({
			type: "POST",
			url: base_url+"read_notification.php",
			data: {jsn:msg}
		})
		.done(function(msag){
			
		});*/
	});
}

function notification_search(){
	var txt = $("#notify_search").val();
	if(txt==''){
		$('.notify_tr').show();
	}else{
		$('.notify_tr').hide();
		$('.notify_tr:containsIN("'+txt+'")').show();
	}
}

var open_notify_id = "";
function info_notification(id,notification_id){
	open_notify_id = id;
	menu_item('order_list_div'); 
	get_order_list2();
	info_notify_bool = true;
	$.ajax({
				type: "GET",
				url: base_url+"notification_update.php",
				data: {notification_id:notification_id,update:'1'}
			})
			.done(function( msg ){
				//alert(msg);
			});
}

function delete_notification(notification_id)
{
		var txt;
		var r = confirm("Are you sure you want to delete this notification?");
		if (r == true) {
			$("#notify_"+notification_id).fadeOut(1000);		
			$.ajax({
				type: "GET",
				url: base_url+"notification_update.php",
				data: {notification_id:notification_id,update:'2'}
			})
			.done(function( msg ){
				//alert(msg);
			});
		} else {
			
		}
		
		
}

function open_notify_order(){
	//alert();
	var pad = "000000";
	var ord="DBAO"+pad.substring(0, pad.length - open_notify_id.length) + open_notify_id;
	$('.contain_tr').hide();
	//$('tr:has(td:contains("'+txt+'"))').show();
	$('.contain_tr:containsIN("'+ord+'")').show();
	info_notify_bool = false;
}

function forgot_password()
{
	var cpass = prompt("Please enter your email with which you had created your DBA account", "");
	if(cpass!=null)
	{
		$.ajax({
				type: "GET",
				url: base_url+"update_password.php",
				data: {cp:cpass}
			})
			.done(function( msg ){
				//alert(msg);
				end_loading();
				if(msg==1){
					alert("Password has been send to you successfully");
				}else{
					alert("Sorry no Customer with this email address");
				}
			});
			
	}
}
function date_format_change(ctime)
{
	var d = new Date(ctime);
	var ctime2 = ""+(d.getMonth()+1)+"/"+(d.getDate())+"/"+(d.getFullYear());
	return ctime2;
}