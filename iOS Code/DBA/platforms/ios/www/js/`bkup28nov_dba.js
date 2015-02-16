var shortName = "fb";
var maxSize = 1024*1024*20;
var version = '1.0';
var displayName = "fb";
var db;
var customerid = "";
var userid = "";
var toggle=0;
var base_url = "http://antloc.com/dba/webservices/";
var base_url2 = "http://antloc.com/dba/admin/";
var TBH = "dashboard_div";
var backArr = new Array();
var sta_loading = false;
var smad = false;
document.addEventListener("deviceready", onDeviceReady, false);

function create_db(){
	if (!window.openDatabase){
		alert('Databases are not supported in this browser.');
		return;
	}
		
	db = window.openDatabase(shortName, version, displayName, maxSize);
	   	 
	db.transaction(function(tx){
	   	tx.executeSql( 'CREATE TABLE IF NOT EXISTS userinfo(id INTEGER NOT  NULL PRIMARY KEY, customerid TEXT NOT NULL, userid TEXT NOT NULL)', [],nullHandler,errorHandler);
	},errorHandler,successCallBack);
}

function errorHandler(transaction, error){
	alert('Error: ' + error.message + ' code: ' + error.code);
}
function nullHandler(){
}
function successCallBack(){
	check_login();
}

function check_login()
{
	db.transaction(function(transaction) {
		transaction.executeSql('SELECT * FROM userinfo;', [],
				     function(transaction, result) {
			if (result != null && result.rows.length != 0) 
			{
				var row = result.rows.item(0);
				customerid = row.customerid;	
				userid = row.userid;
				customerid = customerid.trim();
				//get_profile_list();
				loading();
				$("#login_div").hide();
				$("#dashboard_div").show();
				TBH = "dashboard_div";
			}
			else
			{
			}
		},errorHandler);
	},errorHandler,nullHandler);
}
function start_loading(){
	sta_loading = true;
	//setTimeout(function(){end_loading()},60000);
	$(".overlay").show();
	$(".loading_img").show();
}

function end_loading(){
	sta_loading = false;
	$(".overlay").hide();
	$(".loading_img").hide();
}
function onBackKeyDown(){
	if(TBH=="create_profile_div"){
		navigator.notification.confirm(
			'The changes made to the profile will not be saved if you navigate away from this page. Continue?',  // message
			ononBackKeyDown,   // callback to invoke with index of button pressed
			'DBA',            // title
			'No, Yes'          // buttonLabels
		);
	}else{	
		var last=backArr.pop();
		//alert(last);
		if(sta_loading){
			end_loading();
		}
		
		$('.overlay').hide();
		$('.pp-modal').hide();
		$('.ss-modal').hide();
		
		if(toggle==1){
			var effect = 'slide';
			var options = { direction:'left'};
		  
			// Set the duration (default: 400 milliseconds)
			var duration = 500;

			$('#myDiv').toggle(effect, options, duration);
			
			$( ".wrapper, .header" ).animate({
			left: "0",	
			}, 500, function() {
			// Animation complete.
			});
			$(".transperent").hide();
			toggle=0;
		}
		
		if(last=="dashboard_div"){
			$(".left_br").removeClass('menu_border');
			$("#menu_dashboard_div").addClass('menu_border');
		}
		
		if(last)
		{
			$("#"+TBH).hide();
			$("#"+last).show();
			TBH = last;			
		}
		else
		{
			el = true;
			showConfirm();		
		}	

	}
}

function ononBackKeyDown(button){
	if(button==2){
		var last=backArr.pop();
		//alert(last);
		if(sta_loading){
			end_loading();
		}
		
		$('.overlay').hide();
		$('.pp-modal').hide();
		$('.ss-modal').hide();
		
		if(toggle==1){
			var effect = 'slide';
			var options = { direction:'left'};
		  
			// Set the duration (default: 400 milliseconds)
			var duration = 500;

			$('#myDiv').toggle(effect, options, duration);
			
			$( ".wrapper, .header" ).animate({
			left: "0",	
			}, 500, function() {
			// Animation complete.
			});
			$(".transperent").hide();
			toggle=0;
		}
		
		if(last=="dashboard_div"){
			$(".left_br").removeClass('menu_border');
			$("#menu_dashboard_div").addClass('menu_border');
		}
		
		if(last)
		{
			$("#"+TBH).hide();
			$("#"+last).show();
			TBH = last;			
		}
		else
		{
			el = true;
			showConfirm();		
		}
	}
}
function showConfirm(){
	navigator.notification.confirm(
		'Are you sure you want to exit?',  // message
		onConfirm,              // callback to invoke with index of button pressed
		'DBA',            // title
		'No, Yes'          // buttonLabels
	);
}

	// If user selects 'Yes' then this function is executed
function onConfirm(button){
		if(button===2)
		{
			backArr=[];    	
			navigator.app.exitApp();
		}
		else
		{
			//backArr.push("login");
			//head.push('<center>JNA<span></span></center>');
		}
	}
 var pictureSource;   // picture source
    var destinationType;
function onDeviceReady(){
	document.addEventListener("backbutton", onBackKeyDown, false);
	pictureSource=navigator.camera.PictureSourceType;
	destinationType=navigator.camera.DestinationType;
	create_db();
	//loading();
}

$(function() {
	$("#add").click(function () {
		$('.overlay').fadeIn(100); 
		$('#product_picker').fadeIn(100); 	
	});
	
	$(".short span").click(function () {
		$('.save-save-as span').hide();
		$('.open-info').hide();
		$(".search_box1").hide();
		$("#profile_list").hide();
		$('.short li').slideToggle(100); 
	});
	
	$.extend($.expr[":"], {
	"containsIN": function(elem, i, match, array) {
	return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
	}
	});
		 
	$(".ok").click(function () {
		$('.open-info').hide();
		$('.short li').hide(); 
		$("#profile_list").hide();
		$('.save-save-as span').slideToggle(100); 
	});
	
	$(".search_li").click(function(){
		$(".search_box").toggle();
	});
	
	$(".search_li1").click(function(){
		$(".search_box1").toggle();
	});
	$(".search_li_catalog").click(function(){
		$(".search_box_catlog").toggle();
	});
		 
    $(".myButton").click(function () {

		if(toggle==0){
			var effect = 'slide';


			// Set the options for the effect type chosen
			var options = { direction:'left'};



			// Set the duration (default: 400 milliseconds)
			var duration = 500;

			$('#myDiv').toggle(effect, options, duration);


			$( ".wrapper, .header" ).animate({
			left: "70%",	
			}, 500, function() {
			// Animation complete.
			});

			$('.transperent').fadeIn(100); 
			toggle=1;
		}
		else{
			 var effect = 'slide';


			// Set the options for the effect type chosen
			var options = { direction:'left'};	
			
			// Set the duration (default: 400 milliseconds)
			var duration = 500;

			$('#myDiv').toggle(effect, options, duration);
			
			$( ".wrapper, .header" ).animate({
			left: "0",	
			}, 500, function() {
			// Animation complete.
			});			
			$(".transperent").hide();
			toggle=0;
			
			
		}
			 
	});
	$(".transperent").on("click", function(){
			
			var effect = 'slide';


			// Set the options for the effect type chosen
			var options = { direction:'left'};
		  
			
			
			// Set the duration (default: 400 milliseconds)
			var duration = 500;

			$('#myDiv').toggle(effect, options, duration);
			
			$( ".wrapper, .header" ).animate({
			left: "0",	
			}, 500, function() {
			// Animation complete.
			});
			
			$(".transperent").hide();

			toggle=0;
		
	});
	
	
});

function logout(){
	navigator.notification.confirm(
		'Are you sure you want to logout?',  // message
		onLogout,              // callback to invoke with index of button pressed
		'FarmBrain-DBA',            // title
		'No, Yes'          // buttonLabels
	);
}

function onLogout(button) {
	if(button === 2)
	{
		db.transaction(function(transaction)
		{
			transaction.executeSql('DELETE FROM userinfo;'); 
		});
		backArr = [];
		$("#"+TBH).hide();
		$("#login_div").show();
		TBH = "login_div";
		
		if(toggle==1){
			var effect = 'slide';
			var options = { direction:'left'};
		  
			// Set the duration (default: 400 milliseconds)
			var duration = 500;

			$('#myDiv').toggle(effect, options, duration);
			
			$( ".wrapper, .header" ).animate({
			left: "0",	
			}, 500, function() {
			// Animation complete.
			});
			$(".transperent").hide();
			toggle=0;
		}
	}
}
function change_password(){
	var cpass = prompt("Please enter your current password", "");
	if(cpass!=null){
		var npass = prompt("Please enter new password", "");
		if(npass!=null){
			start_loading();
			$.ajax({
				type: "GET",
				url: base_url+"change_password.php",
				data: {cp:cpass, np:npass, id:userid}
			})
			.done(function( msg ){
				//alert(msg);
				end_loading();
				if(msg==1){
					alert("Password has changed successfully");
				}else{
					alert("Current password is incorrect");
				}
			});
			
		}
	}
}
function login(){
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"login.php",
		data: {username:$("#myusername").val(), password:$("#mypassword").val()}
	})
	.done(function( msg ){
		//alert(msg);
		end_loading();
		if(msg!=0){
			msg = msg.split("#$");
			customerid = msg[0];
			userid = msg[1];
			/*var pswd = prompt("Change your password");
			if(pswd!=null){
				start_loading();
				$.ajax({
					type: "GET",
					url: base_url+"change_password.php",
					data: {np:pswd, id:userid, cp:$("#mypassword").val()}
				})
				.done(function(msg){
					//alert(msg);
					//end_loading();
					alert("Password changed successfully");
				});
			}*/
			$("#login_div").hide();
			$("#dashboard_div").show();
			TBH = "dashboard_div";
			if($("#keep_login").is(':checked')){
				db.transaction(function(transaction)
				{
					transaction.executeSql('REPLACE INTO userinfo(id, customerid, userid) VALUES(?,?,?)', [1,msg[0],msg[1]],nullHandler,errorHandler); 
			   	});
			}
			loading();
		}else{
			alert("Invalid username or password");
		}
	});
}
function active_subcategory(e)
{
       // active the sub header-- sub_header
       $('.sub_header ul li').each(function()
       {        
			$(this).attr('class', '');
			$(this).attr('class', 'tab_inactive');
       });
	    $(e).attr('class', 'tab_active');

}
function tog(){
	$("#shipto").slideToggle("slow","swing");
}
function tog1(){
	$("#billto").slideToggle("slow","swing");
}
var mnu_itemid = "";

function menu_item(id){
	mnu_itemid = id;
	if(TBH=="create_profile_div" || TBH=="next_profile_div" )
	{
		navigator.notification.confirm(
			'The changes made to the profile will not be saved if you navigate away from this page. Continue?',  // message
			onmenu_item,   // callback to invoke with index of button pressed
			'DBA',            // title
			'No, Yes'          // buttonLabels
		);
	}
	else
	{
		$(".left_br").removeClass('menu_border');
		$("#menu_"+id).addClass('menu_border');		
		$("#"+TBH).hide();
		$("#"+id).show();
		backArr.push(TBH);
		TBH = id;
		if(toggle!=0){
			var effect = 'slide';
			// Set the options for the effect type chosen
			var options = { direction:'left'};
		  
			// Set the duration (default: 400 milliseconds)
			var duration = 500;

			$('#myDiv').toggle(effect, options, duration);
			
			$( ".wrapper, .header" ).animate({
			left: "0",	
			}, 500, function() {
			// Animation complete.
			});
			$(".transperent").hide();
			toggle=0;
		}
	}
}

function onmenu_item(button)
{
	if(button==2)
	{
		$(".left_br").removeClass('menu_border');
		$("#menu_"+mnu_itemid).addClass('menu_border');
		$("#"+TBH).hide();
		$("#"+mnu_itemid).show();
		backArr.push(TBH);
		TBH = mnu_itemid;
		if(toggle!=0){
			var effect = 'slide';
			// Set the options for the effect type chosen
			var options = { direction:'left'};
		  
			// Set the duration (default: 400 milliseconds)
			var duration = 500;

			$('#myDiv').toggle(effect, options, duration);
			
			$( ".wrapper, .header" ).animate({
			left: "0",	
			}, 500, function() {
			// Animation complete.
			});
			$(".transperent").hide();
			toggle=0;
		}
	}
}

function cr()
{
	var data = {
		businessname : $("#businessname").val(), 
		email : $("#eml").val(),
		fname : $("#firstname").val(), 
		lname : $("#lastname").val(), 
		businessownername : $("#businessownername").val(), 
		billtoaddress1 : $("#bill_ad1").val(), 
		billtoaddress2 : $("#bill_ad2").val(), 
		billtocity : $("#bill_city").val(), 
		billtostate : $("#bill_state").val(), 
		billtocountry : $("#bill_country").val(), 
		billtozip : $("#bill_zip").val(), 
		billtophone : $("#bill_phone").val(), 
		billtofax : $("#bill_fax").val(), 
		billtoemail : $("#bill_email").val(), 
		billtocellphone : $("#bill_cellphone").val(), 
		shiptoaddress1 : $("#ship_ad1").val(), 
		shiptoaddress2 : $("#ship_ad2").val(), 
		shiptocity : $("#ship_city").val(), 
		shiptostate : $("#ship_state").val(), 
		shiptocountry : $("#ship_country").val(), 
		shiptozip : $("#ship_zip").val(), 
		shiptophone : $("#ship_phone").val(), 
		shiptofax : $("#ship_fax").val(), 
		shiptoemail : $("#ship_email").val(), 
		shiptocellphone : $("#ship_cellphone").val(), 
		defaultnotification : $("#defaultnotification").val(), 
		DUNS : $("#DUNS").val(), 
		federalidnumber : $("#federalidnumber").val(), 
		website : $("#website").val()
	}
	
	var header_str = JSON.stringify(data);
		
		$.ajax({
				type: "POST",
				url: base_url+"customer_registration.php",
				data: {cr:header_str}
		})
		.done(function(msg){
			
			alert("Thanks for registering on the DBA app. We will revert as soon as possible with the next steps.");
			onBackKeyDown();
		});

}

var product_index = new Array();
var obj = null;
var price_obj = null;
var price_index = new Array();
var price_values = new Array();
var price_index1 = new Array();
var price_values1 = new Array()
var sup_obj = null;
var global_suplier = new Array();
var global_premium = new Array();
var sc_obj = null;
var sc_index = new Array();
var supplier_order = new Array();
var p_index = new Array();
var s_index = new Array();

var final_list = new Array();
var active_profile_name= "";
var active_profile_id= -1;
var global_setting_checked=new Array();
var removed_supplier_history = new Array();
var removed_supplier_index = new Array();
var removed_product_index = new Array();
var removed_supplier_index1 = new Array();
var removed_product_index1= new Array();
function add_product(pid){
	//var jsn = JSON.stringify(final_list);
	//alert(jsn);
	var index = product_index.indexOf(pid);
	if(index==-1)
	{
		product_index.push(pid);
		var subsi = new Array();
		var premi = new Array();
		var premiv = new Array();
		if(global_suplier.length!=0)
		{
			var pack = {
				id : pid,
				subs: subsi,
				prem:global_suplier,
				premv:global_premium,
				qty: '',
				supplier : 0,
				price : 0,
				moq : 0,
				ioq : 0,
				invoice : 0,
				rebate : 0,
				peroff : 0,
				valoff : 0,
				minqty : 0,
				prchnd : 0
			}
			final_list.push(pack);
		}
		else
		{
			var pack = {
				id : pid,
				subs: subsi,
				prem:premi,
				premv:premiv,
				qty:'',
				supplier : 0,
				price : 0,
				moq : 0,
				ioq : 0,
				invoice : 0,
				rebate : 0,
				peroff : 0,
				valoff : 0,
				minqty : 0,
				prchnd : 0
			}
			final_list.push(pack);
		}
		
	}
	else
	{
		product_index.splice(index,1);
		final_list.splice(index,1);
		checked_product_list();
		product_list();
	}
	//var jsn = JSON.stringify(final_list);
	//alert(jsn);
	//$("#pro_data").val(jsn);
}
function product_list()
{
	supplier_order = [];
	var str = "";
	var footer_str = ""
	var count_sup = 0;
	var mov_total = new Array();
	var tbh_color_change = new Array();
	var DBA=-1;
	for(i=0;i<product_index.length;i++)
	{
		var id = product_index[i];
		var index = p_index.indexOf(id);		
		if(index!=-1)
		{
			var detail = obj[index];
			var pad = "000000";
			var ord="DBAP"+pad.substring(0, pad.length - detail.productid.length) + detail.productid;
			var img_paht = "";
			if(detail.picture1=='a' || detail.picture1==""){
				img_paht = "images/a.png";
			}else{
				img_paht = base_url2+"upload/"+detail.picture1;
			}
				
			//alert(detail.productlabel);
			var substr="<div class='substitutes' id='suvsd"+i+"' ><div class='addsubstitute' onclick=list_subsi_product("+i+","+detail.productcategoryid+","+detail.productsubcategoryid+")>Add/Edit Substitute</div><div class='substitute_list'>";
			
			for(j=0;j<obj.length;j++){
				var pid = obj[j].productid;
				var idx = final_list[i].subs.indexOf(pid);
				//alert();
				if(idx!=-1){
					substr = substr + "<div class='substitute'><div class='substitute_product'>"+obj[j].productlabel+"</div></div>";
					
				}else{
					
				}
				
			}
			
			substr = substr + "</div></div>";
			var price_idx = price_index.indexOf(detail.productid);
			if(price_idx!=-1)
			{
				
				var supindxof = s_index.indexOf(price_values[price_idx].id[0]);
				var so_indx = supplier_order.indexOf(price_values[price_idx].id[0]);
				if(so_indx==-1)
				{
					//alert(supplier_order.length);
					count_sup++
					var sum_mov = parseInt(final_list[i].qty) * parseInt(price_values[price_idx].id[0]);
					mov_total.push(sum_mov);
					
					var siddh = sup_obj[supindxof].supplierid;
					var fng = sum_mov;
					var indxgfd = sc_index.indexOf(siddh);
					//alert(indxgfd);
					var mov = sc_obj[indxgfd].minimumordervalue;
					//alert(fng+"----"+mov);
					if(fng>mov){
						tbh_color_change.push(siddh);
					}
					supplier_order.push(price_values[price_idx].id[0]);
					
					footer_str = footer_str + "<li id='footer"+sup_obj[supindxof].supplierid+"' style='border-top: 3px solid rgb(206, 0, 0);' onclick=place_supplier('"+sup_obj[supindxof].supplierid+"')>"+sup_obj[supindxof].businessname+"</li>";
					
				}else{
					var sum_mov = parseInt(final_list[i].qty) * parseInt(price_values[price_idx].id[0]);
					mov_total[so_indx] = mov_total[so_indx] + sum_mov;
					
					var siddh = sup_obj[supindxof].supplierid;
					var fng = mov_total[so_indx]
					var indxgfd = sc_index.indexOf(siddh);
					var mov = sc_obj[indxgfd].minimumordervalue;
					//alert(fng+"----"+mov);
					if(fng>mov){
						tbh_color_change.push(siddh);
					}
				}
				//alert(price_values[price_idx].moq[0]);
				str = str + "<tr class='co_contain_tr' ><td class='one' ><p onclick=togle_lower('"+detail.productid+"')>"+detail.productlabel+"<b>"+detail.packquantity+detail.unitofmeasure+"</b></p> <div class='drop-1' >$"+price_values[price_idx].price[0]+"<br />";
				if(price_values[price_idx].invoice[0]!=0){
					if(price_values[price_idx].peroff[0]!=0){
						str = str + "<p>"+price_values[price_idx].peroff[0]+"% on minimum qty "+price_values[price_idx].minqty[0]+"</p>";
					}else if(price_values[price_idx].valoff[0]!=0){
						str = str + "<p>"+price_values[price_idx].valoff[0]+" value off on minimum qty "+price_values[price_idx].minqty[0]+"</p>";
					}
				}
				
				var lod = price_values[price_idx].ldo[0];
				lod = lod.split("&&");
				
				var sup_id_match=sup_obj[supindxof].supplierid;
				// alert(final_list[i].prem.indexOf(sup_id_match));
				
				str = str+"<center onclick='rec_show("+i+")'>"+sup_obj[supindxof].businessname+"</center><img class='drop1' src='images/drop.png' onclick='rec_show("+i+")'/><div class='open-info-main1' id='recid"+i+"' >";	
				
				
				for(rec = 0;rec<price_values[price_idx].price.length;rec++)
				{
					var supindxof1 = s_index.indexOf(price_values[price_idx].id[rec]);
					
						DBA=0;
						str = str+"<li onclick='rec_click("+i+","+price_idx+","+rec+")'>$"+price_values[price_idx].price[rec]+" "+sup_obj[supindxof1].businessname+"</li>";
					
				}
				
				
				var dot_str = "";
				if(final_list[i].invoice!=0){
					dot_str = dot_str + ".";
				}
				if(final_list[i].rebate!=0){
					dot_str = dot_str + ".";
				}
				str = str + "</div></b></div><div class='more'><h1>"+dot_str+"</h1></div></td><td class='large-width'>";
				if(final_list[i].prchnd!=0){
					var dp = final_list[i].prchnd.split("&&");
					if(parseInt(final_list[i].price)>parseInt(dp[0])){
						str = str+"<i onclick='tooltip_show("+i+",2)' style='color:green;' >!</i>";
					}else if(parseInt(final_list[i].price)<parseInt(dp[0])){
						str = str+"<i onclick='tooltip_show("+i+",2)' style='color:red;' >!</i>";
					}
				}
				str = str + "<span onclick='pro_qty_up("+i+","+price_values[price_idx].moq[0]+")' >+</span><input ";
				if(parseInt(price_values[price_idx].moq[0])>parseInt(final_list[i].qty)){
					str = str + "style='border: 1px solid rgb(206, 0, 0)'";
				}
				
				if(final_list[i].qty==0)
				{
					final_list[i].qty='';
				}
				
				str = str +" type='number' id='pqty"+i+"' onClick='this.select();' value='"+final_list[i].qty+"' onchange='pro_qty("+i+","+price_values[price_idx].moq[0]+")' /><span onclick='pro_qty_down("+i+","+price_values[price_idx].moq[0]+")' >-</span></td><td class='small-width'><u><img onclick=delete_from_order('"+detail.productid+"') src='images/delete.png' /></u></td><tr class='open-info' id='lower"+detail.productid+"' ><td><div class='left'><img style='width:30%' src='"+img_paht+"' /></div><div class='right'><p>"+detail.productdescription+"</p><div class='large-width'><h4><b>Product ID:</b>"+ord+"</h4><br /><h4><b>Category:</b>"+detail.cat_name+"</h4><br /><h4><b>unit measure:</b>"+detail.unitofmeasure+"</h4><br/><h4><b>Case Quantity:</b>"+detail.casequantity+"</h4><br><h4><b>Case wt</b>"+detail.caseweight+"</h4><h4><b>Pack Qty</b>"+detail.packquantity+"</h4><br/><h4><b>Minimum Order Qty:</b>"+final_list[i].moq+"</h4><br/><h4><b>Incremental Order Qty:</b>"+final_list[i].ioq+"</h4><br/><h4><b>Last Order Qty:</b>"+lod[0]+"</h4><br/><h4><b>Last Order Date:</b>"+lod[1]+"</h4><br/></div><div class='large-width' ><ul>";
				if(final_list[i].invoice!=0){
					str = str + "<li onclick='tooltip_show("+i+",0)' style='color:rgb(96, 146, 223);'>$</li>";
				}
				if(final_list[i].rebate!=0){
					str = str + "<li onclick='tooltip_show("+i+",1)' style='color:#6AC224;'>R</li>";
				}
				
				str = str + "</ul></div></div></td><td><a href='#' onclick='supplier_setng("+i+"); return false;'>Supplier Settings</a><a href='#' onclick='show_svdhf("+i+")'>Substitutes </a>"+substr+"</td></tr></tr>";
				//alert(str);
				if(final_list[i].qty=='')
				{
					final_list[i].qty=0;
				}				
		}
		else
		{
			if(final_list[i].qty==0)
			{
				final_list[i].qty='';
			}
			str = str + "<tr class='co_contain_tr' ><td class='one' onclick=togle_lower('"+detail.productid+"') ><p>"+detail.productlabel+"<b>"+detail.packquantity+detail.unitofmeasure+"</b></p><div class='drop-1'><br /><center style='color:red'>No Supplier</center><img class='drop1' src='images/drop.png' /><div class='open-info-main1'></div></b></div><div class='more'><h1></h1></div></td><td class='large-width'><span onclick='pro_qty_up("+i+")' >+</span><input type='number' onClick='this.select();' id='pqty"+i+"' value='"+final_list[i].qty+"' onchange='pro_qty("+i+",0)' /><span onclick='pro_qty_down("+i+")' >-</span></td><td class='small-width'><u><img src='images/delete.png' onclick=delete_from_order('"+detail.productid+"') /></u></td><tr class='open-info' id='lower"+detail.productid+"' ><td><div class='left'><img style='width:30%' src='"+img_paht+"' /></div><div class='right'><p>"+detail.productdescription+"</p><h4><b>Product ID:</b>"+ord+"</h4><br /><h4><b>Category:</b>"+detail.cat_name+"</h4><br/><h4><b>unit measure:</b>"+detail.unitofmeasure+"</h4><br/><h4><b>Case Quantity:</b>"+detail.casequantity+"</h4><br><h4><b>Case wt</b>"+detail.caseweight+"</h4><h4><b>Pack Qty</b>"+detail.packquantity+"</h4><br/><h4><b>Minimum Order Qty:</b>"+final_list[i].moq+"</h4><br/><h4><b>Incremental Order Qty:</b>"+final_list[i].ioq+"</h4><br/><h4><b>Last Order Qty:</b> NA</h4><br/><h4><b>Last Order Date:</b> NA</h4><br/></div></td><td><a href='#' onclick='supplier_setng("+i+"); return false;'>Supplier Settings</a><a href='#' onclick='show_svdhf("+i+")' >Substitutes </a>"+substr+"</td></tr></tr>";
			if(final_list[i].qty=='')
			{
				final_list[i].qty=0;
			}
		}
		//str = str+substr+supstr;
	}else{
		product_index.splice(i,1);
		final_list.splice(i,1);
	}
	}
	if(count_sup==1){
		$("#footer_down").removeClass();
		$("#footer_down").addClass('footer-down');
	}
	else if(count_sup==2){
		$("#footer_down").removeClass();
		$("#footer_down").addClass('footer-down4');
	}else if(count_sup>2){
		$("#footer_down").removeClass();
		$("#footer_down").addClass('footer-down2');
	}
	//alert(str);
	$("#lis_div").html(str);
	$("#footer_down").html(footer_str);
	
	for(j=0;j<tbh_color_change.length;j++){
		document.getElementById("footer"+tbh_color_change[j]).style.borderTop = "3px solid rgb(105, 172, 53)";
	}
	$(".open-info-main1").hide();
}
function load_list(){
	
}
var tolip_bool = false;
function tooltip_show(id,r){
	var supplier = final_list[id].supplier;
	var sname = sup_obj[s_index.indexOf(supplier)].businessname;
	var type = "Off Invoice";
	if(r==1){
		type = "Rebate";
		var str = "<img src='images/cross.png' onclick='hide_tolip()' /><h1>"+type+"</h1><p><b>"+sname+"</b> Supplier is offering a discount of ";
		if(final_list[id].valoff!=0){
			str = str + "$"+final_list[id].valoff+" given a min. order Qty of "+final_list[id].minqty+"</p>";
		}else if(final_list[id].peroff!=0){
			str = str + ""+final_list[id].peroff+"% given a min. order Qty of "+final_list[id].minqty+"</p>";
		}
		$("#tooltip").html(str);
		$('.overlay').show();
		$("#tooltip").toggle();
	}else if(r==0){
		type = "Off Invoice";
		var str = "<img src='images/cross.png' onclick='hide_tolip()' /><h1>"+type+"</h1><p><b>"+sname+"</b> Supplier is offering a rebate of ";
		if(final_list[id].valoff!=0){
			str = str + "$"+final_list[id].valoff+" given a min. order Qty of "+final_list[id].minqty+"</p>";
		}else if(final_list[id].peroff!=0){
			str = str + ""+final_list[id].peroff+"% given a min. order Qty of "+final_list[id].minqty+"</p>";
		}
		$("#tooltip").html(str);
		$('.overlay').show();
		$("#tooltip").toggle();
	}else if(r==2){
		type = "Price Alert";
		var dp = final_list[id].prchnd.split("&&");
		var pfal = "increasing";
		if(parseInt(final_list[id].price)>parseInt(dp[0])){
			pfal = "decreasing";
		}else if(parseInt(final_list[id].price)<parseInt(dp[0])){
			pfal = "increasing";
		}else{
			pfal = "not changing";
		}
		
		var str = "<img src='images/cross.png' onclick='hide_tolip()' /><h1>"+type+"</h1><p><b>"+sname+"</b> Price of this product is "+pfal+" to "+dp[0]+" wef "+dp[1]+"</p>";
		
		$("#tooltip").html(str);
		
		$('.overlay').show();
		$("#tooltip").toggle();
	}
}
function cancel_send_order(){
	navigator.notification.confirm(
			'Canceling the order will delete the order in progress.Continue?',  // message
			oncancel_send_order,   // callback to invoke with index of button pressed
			'DBA',            // title
			'No, Yes'          // buttonLabels
	);
}
function oncancel_send_order(button){
	if(button==2){
		onBackKeyDown();
	}
}
function hide_tolip(){
	$('.overlay').hide();
	$("#tooltip").hide();
}
var dehgj = 0;
function delete_from_order(id){
dehgj = id;
		navigator.notification.confirm(
			'Are you sure you want to delete this item?',  // message
			delete_from_order1,              // callback to invoke with index of button pressed
			'DBA',            // title
			'No, Yes'          // buttonLabels
		);
}

function delete_from_order1(button){
	if(button==2){
		add_product(dehgj);
		//product_list();
	}
}

function rec_click(index,idx,min_k){
		//alert(min_k);
		$("#recid"+index).toggle();
		var temp = price_values[idx].price[0];
		price_values[idx].price[0] = price_values[idx].price[min_k];
		price_values[idx].price[min_k] = temp;
		var temp1 = price_values[idx].id[0];
		price_values[idx].id[0] = price_values[idx].id[min_k];
		price_values[idx].id[min_k] = temp1;
		var temp2 = price_values[idx].moq[0];
		price_values[idx].moq[0] = price_values[idx].moq[min_k];
		price_values[idx].moq[min_k] = temp2;
		var temp3 = price_values[idx].ioq[0];
		price_values[idx].ioq[0] = price_values[idx].ioq[min_k];
		price_values[idx].ioq[min_k] = temp3;
		
		var temp = price_values[idx].invoice[0];
		price_values[idx].invoice[0] = price_values[idx].invoice[min_k];
		price_values[idx].invoice[min_k] = temp;
		var temp1 = price_values[idx].rebate[0];
		price_values[idx].rebate[0] = price_values[idx].rebate[min_k];
		price_values[idx].rebate[min_k] = temp1;
		var temp2 = price_values[idx].valoff[0];
		price_values[idx].valoff[0] = price_values[idx].valoff[min_k];
		price_values[idx].valoff[min_k] = temp2;
		var temp3 = price_values[idx].peroff[0];
		price_values[idx].peroff[0] = price_values[idx].peroff[min_k];
		price_values[idx].peroff[min_k] = temp3;
		var temp3 = price_values[idx].minqty[0];
		price_values[idx].minqty[0] = price_values[idx].minqty[min_k];
		price_values[idx].minqty[min_k] = temp3;
		var temp3 = price_values[idx].prchnd[0];
		price_values[idx].prchnd[0] = price_values[idx].prchnd[min_k];
		price_values[idx].prchnd[min_k] = temp3;
		
		var temp3 = price_values[idx].ldo[0];
		price_values[idx].ldo[0] = price_values[idx].ldo[min_k];
		price_values[idx].ldo[min_k] = temp3;
		
		final_list[index].price = price_values[idx].price[0];
		final_list[index].supplier = price_values[idx].id[0];
		final_list[index].moq = price_values[idx].moq[0];
		final_list[index].ioq = price_values[idx].ioq[0];
		final_list[index].invoice = price_values[idx].invoice[0];
		final_list[index].rebate = price_values[idx].rebate[0];
		final_list[index].peroff = price_values[idx].peroff[0];
		final_list[index].valoff = price_values[idx].valoff[0];
		final_list[index].minqty = price_values[idx].minqty[0];
		final_list[index].prchnd = price_values[idx].prchnd[0];
		//var jsn = JSON.stringify(price_values);
		//alert(jsn);
		product_list();
}

function rec_show(id){
	$('.save-save-as span').hide();
	$('.short li').hide();
	//$('.open-info-main1').hide();
	$("#profile_list").hide();
	$("#recid"+id).toggle();
}
//This is for making product as supplierwise
var all_data_order = new Array();

//For making order summary page
function place_supplier(sid)
{
	$("#next_profile_div").show();
	$("#"+TBH).hide();
	backArr.push(TBH);
	TBH = "next_profile_div";
	var all_product_order = new Array();
	all_data_order = [];
	var ghi = true;
	//var jsn = JSON.stringify(final_list);
	//alert(jsn);
	var jk=0;
	for(i=0;i<final_list.length;i++)
	{
	var miq = parseInt(final_list[i].moq);
	var qiq = parseInt(final_list[i].qty);
	
	if(qiq=='NAN' || qiq==0)
	{
		if(jk==0)
		{
			alert('Items with 0 quantity will be dropped from the order.');
			jk++;
		}
	}
	if(miq>qiq && qiq!=0)
	{
		var message = "Minimum order quantity and incremental order quantity for '"+obj[p_index.indexOf(final_list[i].id)].productlabel+ "' not matched";
		ghi=false;
		alert(message);
		onBackKeyDown();
		break;
	}
	else
	{
		var k = (qiq - miq)%(final_list[i].ioq);
		//alert(k);
		if(k!=0){
			var message = "incremental order quantity for '"+obj[p_index.indexOf(final_list[i].id)].productlabel+ "' not matched";
			ghi=false;
			alert(message);
			onBackKeyDown();
			break;
		}
		}
	}
	if(ghi)
	{
	//var jsn = JSON.stringify(final_list);
	//alert(jsn);
	
	for(i=0;i<final_list.length;i++){
		var sid = final_list[i].supplier;
		var currentdate = new Date(); 
		currentdate.setDate(currentdate.getDate() + 2);
		var time = 	currentdate.getFullYear() + "-"
                + (currentdate.getMonth()+1) + "-" 
                + currentdate.getDate();
		//alert(sid);
		if(typeof(sid)!="undefined" && sid!=0)
		{
		//alert("in");
			if(final_list[i].qty!=0 && final_list[i].qty!='')
			{
				var pri = final_list[i].price;
				var index = all_product_order.indexOf(sid);
				if(index==-1){
					all_product_order.push(sid);
					var pridctid = new Array();
					var qt = new Array();
					var qtpri = new Array();
					var rpd = new Array();
					var rbte = new Array();
					var idisco = new Array();
					var disco = 0;
					pridctid.push(final_list[i].id);
					qt.push(final_list[i].qty);
					rpd.push(final_list[i].subs);
					//This if for rebate/invoice on a product if any
					var prigh = final_list[i].price * final_list[i].qty;
					//alert(final_list[i].invoice+"---"+final_list[i].qty+"---"+final_list[i].minqty);
					if(final_list[i].invoice!=0 && parseInt(final_list[i].qty) >= parseInt(final_list[i].minqty)){
						//alert(prigh);
						if(final_list[i].peroff!=0){
							disco = (prigh * parseInt(final_list[i].peroff))/100;
							prigh = prigh - (prigh * parseInt(final_list[i].peroff))/100;
							//alert(prigh);
						}else if(final_list[i].valoff!=0){
							disco =  parseInt(final_list[i].valoff);
							prigh = prigh - parseInt(final_list[i].valoff);
						}
					}
					//This is for fetching saving of the order
					var save_v = 0;
					var savinx = price_index.indexOf(final_list[i].id);
					if(savinx!=-1){
						var m = 1;
						for(m=1;m<price_values[savinx].price.length;m++){
							save_v = save_v + parseInt(price_values[savinx].price[m]);
						}
						save_v = parseInt(save_v/m)*parseInt(final_list[i].qty);
					}
					
					idisco.push(disco);
					qtpri.push(final_list[i].price);
					rbte.push(final_list[i].rebate);
					
						var data = {
							customer : customerid,
							supplier : sid,
							price : prigh,
							pid : pridctid,
							qty : qt,
							pris : qtpri,
							rpid: rpd,
							rebate : rbte,
							discount : disco,
							idisc : idisco,
							rqdlt : time,
							saving : save_v,
							mov : 0
						}
						all_data_order.push(data);
					
				}else{
					var disco = 0;
					var prigh = final_list[i].price * final_list[i].qty;
					if(final_list[i].invoice!=0 && parseInt(final_list[i].qty) >= parseInt(final_list[i].minqty)){
						if(final_list[i].peroff!=0){
							disco = (prigh * parseInt(final_list[i].peroff))/100;
							prigh = prigh - (prigh * parseInt(final_list[i].peroff))/100;
						}else if(final_list[i].valoff!=0){
							disco =  parseInt(final_list[i].valoff);
							prigh = prigh - parseInt(final_list[i].valoff);
						}
					}
					all_data_order[index].price = all_data_order[index].price + prigh;
					all_data_order[index].discount = all_data_order[index].discount + disco;
					all_data_order[index].pid.push(final_list[i].id);
					all_data_order[index].qty.push(final_list[i].qty);
					all_data_order[index].pris.push(final_list[i].price);
					all_data_order[index].rpid.push(final_list[i].subs);
					all_data_order[index].rebate.push(final_list[i].rebate);
					all_data_order[index].idisc.push(disco);
					var save_v = 0;
					var savinx = price_index.indexOf(final_list[i].id);
					if(savinx!=-1){
						var m = 1;
						for(m=1;m<price_values[savinx].price.length;m++){
							save_v = save_v + parseInt(price_values[savinx].price[m]);
						}
						save_v = parseInt(save_v/m)*parseInt(final_list[i].qty);
					}
					all_data_order[index].saving = all_data_order[index].saving + save_v;
				}
			}
			else
			{}
		}
		else
		{
			//alert();
			var pname = obj[p_index.indexOf(final_list[i].id)].productlabel;
			alert("There is no supplier for '"+pname+"'");
		}
	}
	//var jsn = JSON.stringify(all_data_order);
	//alert(jsn);
	var days_ary = ["Su","Mo","Tu","We","Th","Fr","Sa"];
	var currentdate = new Date(); 
	currentdate.setDate(currentdate.getDate() + 2);
	
	var time = 	currentdate.getFullYear()+"-"+(currentdate.getMonth()+1) + "-"
                +currentdate.getDate();
				
	var mday = 	currentdate.getDay();		
	var str="";
	//if (all_data_order.length>1) supplier_remove_disable = "" else  supplier_remove_disable = "disabled";
	for(i=0;i<all_data_order.length;i++)
	{	
		var index = s_index.indexOf(all_data_order[i].supplier);		
		var sc_idx = sc_index.indexOf(all_data_order[i].supplier);
		//alert(sc_idx);
		if(sc_idx!=-1){
			var mov = sc_obj[sc_idx].minimumordervalue;
			all_data_order[i].mov = mov;
			if(mov<=all_data_order[i].price){
				str = str + "<li id='li_single_order"+i+"'>";
				//alert(all_data_order.length);
				if(all_data_order.length==1){
					str = str+"<input checked type='checkbox' id='supplier_"+sup_obj[index].supplierid+"' onclick='cancel_send_order()'/>";
				}else{
					str = str+"<input checked type='checkbox' onclick=suffle_supplier('"+sup_obj[index].supplierid+"') id='supplier_"+sup_obj[index].supplierid+"' />";
				}
				str = str+"<label onclick='table_show("+i+")'>"+sup_obj[index].businessname+"</label><p class='price' onclick='table_show("+i+")' >$"+sc_obj[sc_idx].minimumordervalue+"</p><big id='total_sup_value"+i+"'>$"+all_data_order[i].price+"</big><i id='dayd"+i+"'>"+days_ary[mday]+"</i><input class='date_pic' type='date' id='rdlt"+i+"' onchange='date_change("+i+")' value='"+time+"' /><span><img src='images/select.png' onclick='send_order_single("+i+")' /></span></li><table class='dba-profile' id='tableor"+i+"' style='display:none' >";
				//alert(all_data_order[i].pid.length);
				for(q=0;q<all_data_order[i].pid.length;q++){
					var id = all_data_order[i].pid[q];
					var indo = p_index.indexOf(id);
					//alert(indo);
					var detail = obj[indo];
					
					str = str + "<tr id='all_product_tr"+i+""+q+"'><td class='one' ><p>"+detail.productlabel+"<b>"+detail.packquantity+detail.unitofmeasure+"</b></p><div class='drop-1'><div class='open-info-main1'></div></b></div></td><td class='large-width'><span onclick='all_qty_up("+mov+","+i+","+q+")'>+</span><input onblur='all_qty_change("+mov+","+i+","+q+")' id='all_qty"+i+""+q+"' type='number' onkeyup='all_qty_change("+mov+","+i+","+q+")' value='"+all_data_order[i].qty[q]+"' /><span onclick='all_qty_down("+mov+","+i+","+q+")' >-</span></td><td class='small-width'><u><img src='images/delete.png' onclick='all_delt_pro("+i+","+q+")' /></u></td></tr>";
					
				}
				str = str + "</table>"
			}else{
				//alert("Minimum order value for supplier "+sup_obj[index].businessname+" is $"+mov);
				//onBackKeyDown();
				//break;
				str = str + "<li id='li_single_order"+i+"'>";
				//alert(all_data_order.length);
				if(all_data_order.length==1){
					str = str+"<input checked type='checkbox' id='supplier_"+sup_obj[index].supplierid+"' onclick='cancel_send_order()'/>";
				}else{
					str = str+"<input checked type='checkbox' onclick=suffle_supplier('"+sup_obj[index].supplierid+"') id='supplier_"+sup_obj[index].supplierid+"' />";
				}
				str = str+"<label style='border-left: 3px solid rgb(206, 0, 0);' onclick='table_show("+i+")'>"+sup_obj[index].businessname+"</label><p class='price' onclick='table_show("+i+")' >$"+sc_obj[sc_idx].minimumordervalue+"</p><big id='total_sup_value"+i+"'>$"+all_data_order[i].price+"</big><i id='dayd"+i+"'>"+days_ary[mday]+"</i><input class='date_pic' type='date' id='rdlt"+i+"' onchange='date_change("+i+")' value='"+time+"' /><span><img src='images/select.png' onclick='send_order_single("+i+")' /></span></li><table class='dba-profile' id='tableor"+i+"' style='display:none' >";
				//alert(all_data_order[i].pid.length);
				for(q=0;q<all_data_order[i].pid.length;q++){
					var id = all_data_order[i].pid[q];
					var indo = p_index.indexOf(id);
					//alert(indo);
					var detail = obj[indo];
					
					str = str + "<tr id='all_product_tr"+i+""+q+"'><td class='one' ><p>"+detail.productlabel+"<b>"+detail.packquantity+detail.unitofmeasure+"</b></p><div class='drop-1'><div class='open-info-main1'></div></b></div></td><td class='large-width'><span onclick='all_qty_up("+mov+","+i+","+q+")'>+</span><input onblur='all_qty_change("+mov+","+i+","+q+")' id='all_qty"+i+""+q+"' type='number' onchange='all_qty_change("+mov+","+i+","+q+")' value='"+all_data_order[i].qty[q]+"' /><span onclick='all_qty_down("+mov+","+i+","+q+")' >-</span></td><td class='small-width'><u><img src='images/delete.png' onclick='all_delt_pro("+i+","+q+")' /></u></td></tr>";
					
				}
				str = str + "</table>"
			}
		}
		
		}
	}
	
	$("#supplier_by_order").html(str);
	//for request delivery date//
	/* $('.date_pic').mobiscroll().date({
		theme: 'android',
		display: 'modal',
		mode: 'scroller',
		animate: 'fade',
	}); */
	/*$('.date_pic').mobiscroll().calendar({
       theme: 'mobiscroll',
       display: 'bottom',
       controls: ['calendar']
   });*/      
}

function order_remove_zero(button)
{
	if(button==2)
	{
	
	}
}
function date_change(id)
{
	var rdate = $("#rdlt"+id).val();
	all_data_order[id].rqdlt = rdate;
	
	var days_ary = ["Su","Mo","Tu","We","Th","Fr","Sa"];
	var currentdate = new Date(rdate); 
	/* currentdate.setDate(currentdate.getDate() + 2);
	var time = 	(currentdate.getMonth()+1) + "/"
                +currentdate.getDate() + "/" 
                + currentdate.getFullYear();*/
	var mday = 	currentdate.getDay(); 
	$("#dayd"+id).html(days_ary[mday]);
}


var all_i = 0;
var all_q = 0;
function all_delt_pro(i,q){
all_i = i
all_q = q
navigator.notification.confirm(
			'Are you sure you want to delete this product?',  // message
			onall_delt_pro,              // callback to invoke with index of button pressed
			'DBA',            // title
			'No, Yes'          // buttonLabels
		);
}

function onall_delt_pro(button){
if(button==2){
	$("#all_product_tr"+all_i+""+all_q).hide();
	var productid = all_data_order[all_i].pid[all_q];
	all_data_order[all_i].pid.splice(all_q,1);
	all_data_order[all_i].qty.splice(all_q,1);
	all_data_order[all_i].pris.splice(all_q,1);
	all_data_order[all_i].rpid.splice(all_q,1);
	
	var indx = product_index.indexOf(productid);
	if(indx!=-1){
		product_index.splice(indx,1);
		final_list.splice(indx,1);
		onBackKeyDown();
		product_list();
		checked_product_list();
		place_supplier(0);
	}
}
}

function all_qty_up(mov,i,q){
	var price = all_data_order[i].pris[q];
	//alert(price);
	all_data_order[i].qty[q]++;
	$("#all_qty"+i+""+q).val(all_data_order[i].qty[q]);
	var decrmnt = parseInt(all_data_order[i].price) + parseInt(price);
	all_data_order[i].price = decrmnt;
	decrmnt = "$"+decrmnt;
	$("#total_sup_value"+i).html(decrmnt);
	//all_data_order[i].price = decrmnt;
}

function all_qty_down(mov,i,q){
	var price = all_data_order[i].pris[q];
	var qty = all_data_order[i].qty[q];
	if(qty>0){
	var decrmnt = parseInt(all_data_order[i].price) - parseInt(price);
	if(decrmnt>=mov){
		qty--;
		all_data_order[i].qty[q] = qty;
		all_data_order[i].price = decrmnt;
		decrmnt = "$"+decrmnt;
		$("#total_sup_value"+i).html(decrmnt);
		$("#all_qty"+i+""+q).val(all_data_order[i].qty[q]);
	}
	else
	{
		alert("Can't be less any more");
	}
	}
}

function all_qty_change(mov,i,q){
	var price = all_data_order[i].pris[q];
	var qty = $("#all_qty"+i+""+q).val(); 
	if(qty>0)
	{
	var k = (parseInt(all_data_order[i].qty[q])*parseInt(price)) - (parseInt(qty)*parseInt(price));
	var decrmnt = parseInt(all_data_order[i].price) - k;
	if(decrmnt>=mov){
		all_data_order[i].qty[q] = qty;
		all_data_order[i].price = decrmnt;
		decrmnt = "$"+decrmnt;
		$("#total_sup_value"+i).html(decrmnt);
	}
	else{
		//alert("Minimum order value is "+mov);
		alert("Order Qty doesn't match the supplier minimum order value");
		$("#all_qty"+i+""+q).val(all_data_order[i].qty[q]);
	}
	}
}

var suffle_supplierid = "";
function suffle_supplier(id){
suffle_supplierid = id;
	navigator.notification.confirm(
		'This will remove the supplier from order and its ordered products will go to other supplier and if there is no supplier for any product it will be delete from order. Are you sure you want to do this?',  // message
		onsuffle_supplier,              // callback to invoke with index of button pressed
		'DBA',            // title
		'No, Yes'          // buttonLabels
	);
}

function onsuffle_supplier(button){
//alert(id);
	if(button==2){
		//find supplier id of the clicked checkbox 
		var jsn = JSON.stringify(final_list);
		//alert(jsn);
		var id = suffle_supplierid;
		var supplierid = id
		var productindx = new Array();
		//find all products under this supplier 
		for (i=0;i<final_list.length;i++)
		{	
			if (final_list[i].supplier==supplierid)
			{
				productindx.push(final_list[i].id);
			}
		}
		//find short supplier list 
		// this is the list of suppliers on order review page excluding the one which has just been clicked 
		var selected_supplier = new Array();
		for(i=0;i<final_list.length;i++){
			var sid = final_list[i].supplier;
			if(selected_supplier.indexOf(sid)==-1){
				selected_supplier.push(sid);
			}
		}
		//remove the unchecked supplier
		var iki = selected_supplier.indexOf(supplierid);
		selected_supplier.splice(iki,1);
		//for each product find supplier price table from the limited supplier list
		var shuffled_product_price_array = new Array();
		for (i=0;i<productindx.length;i++)
		{
			shuffled_product_price_array[i] = new Array();
			//price_value 
			var productid = productindx[i];
			var indexp = product_index.indexOf(productid);
			var idx = price_index.indexOf(productid);
			//alert(idx);
			var find_sup_bool = false;
			for(j=0;j<selected_supplier.length;j++){
				var min_k = price_values[idx].id.indexOf(selected_supplier[j]);
				//alert(min_k);
				if(min_k!=-1){
					find_sup_bool = true;
					var temp = price_values[idx].price[0];
					price_values[idx].price[0] = price_values[idx].price[min_k];
					price_values[idx].price[min_k] = temp;
					var temp1 = price_values[idx].id[0];
					price_values[idx].id[0] = price_values[idx].id[min_k];
					price_values[idx].id[min_k] = temp1;
					var temp2 = price_values[idx].moq[0];
					price_values[idx].moq[0] = price_values[idx].moq[min_k];
					price_values[idx].moq[min_k] = temp2;
					var temp3 = price_values[idx].ioq[0];
					price_values[idx].ioq[0] = price_values[idx].ioq[min_k];
					price_values[idx].ioq[min_k] = temp3;
					
					var temp = price_values[idx].invoice[0];
					price_values[idx].invoice[0] = price_values[idx].invoice[min_k];
					price_values[idx].invoice[min_k] = temp;
					var temp1 = price_values[idx].rebate[0];
					price_values[idx].rebate[0] = price_values[idx].rebate[min_k];
					price_values[idx].rebate[min_k] = temp1;
					var temp2 = price_values[idx].valoff[0];
					price_values[idx].valoff[0] = price_values[idx].valoff[min_k];
					price_values[idx].valoff[min_k] = temp2;
					var temp3 = price_values[idx].peroff[0];
					price_values[idx].peroff[0] = price_values[idx].peroff[min_k];
					price_values[idx].peroff[min_k] = temp3;
					var temp3 = price_values[idx].minqty[0];
					price_values[idx].minqty[0] = price_values[idx].minqty[min_k];
					price_values[idx].minqty[min_k] = temp3;
					var temp3 = price_values[idx].prchnd[0];
					price_values[idx].prchnd[0] = price_values[idx].prchnd[min_k];
					price_values[idx].prchnd[min_k] = temp3;
					
					var temp3 = price_values[idx].ldo[0];
					price_values[idx].ldo[0] = price_values[idx].ldo[min_k];
					price_values[idx].ldo[min_k] = temp3;
					//alert(indexp);
					var jsn = JSON.stringify(final_list);
					//alert(jsn);
					if(indexp!=-1){
					//alert(indexp);
					final_list[indexp].price = price_values[idx].price[0];
					final_list[indexp].supplier = price_values[idx].id[0];
					final_list[indexp].moq = price_values[idx].moq[0];
					final_list[indexp].ioq = price_values[idx].ioq[0];
					final_list[indexp].invoice = price_values[idx].invoice[0];
					final_list[indexp].rebate = price_values[idx].rebate[0];
					final_list[indexp].peroff = price_values[idx].peroff[0];
					final_list[indexp].valoff = price_values[idx].valoff[0];
					final_list[indexp].minqty = price_values[idx].minqty[0];
					final_list[indexp].prchnd = price_values[idx].prchnd[0];
					}
				}
			}		
			if(!find_sup_bool){
				final_list.splice(indexp,1);
				product_index.splice(indexp,1);
			}
		}
	
	onBackKeyDown();
	product_list();
	checked_product_list();
	place_supplier(id);
	
	}
	else{
		document.getElementById("supplier_"+suffle_supplierid).checked=true;
	}
}
var didi = ""
function capturePhoto(id) {
	didi = id;
	//alert(didi);
      navigator.camera.getPicture(onPhotoDataSuccess, onFail, { quality: 50,
        destinationType: destinationType.DATA_URL });
}

function onPhotoDataSuccess(imageData) {
	//alert(didi);
    var pmt_caption = prompt("Enter Comment");
	if(pmt_caption!=null){
		start_loading();
		$.ajax({
			type: "POST",
			url: base_url+"feedback.php",
			data: {id:didi, img:imageData, mg:pmt_caption}
		})
		.done(function(msg){
			end_loading();
			//alert(msg)
		});
	}
}

function onFail(message) {
	alert(message);
}

function hide_all_drop(){
	
}
	
function table_show(id){
	//alert();
	$("#tableor"+id).toggle();
}

function recommend_supplier(){
}
//This is for placing complete order
function send_order(){
var mov_bool = true;
var order_item = new Array();
for(i=0;i<all_data_order.length;i++){
	if(all_data_order[i]!=0){
		if(all_data_order[i].mov<=all_data_order[i].price){
			order_item.push(all_data_order[i]);
		}else{
			mov_bool = false;
			alert("Minimum order value is not satisfied");
			break;
		}
	}
}
if(order_item.length!=0 && mov_bool){
	var jsn = JSON.stringify(order_item);
	//alert(jsn);
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"place_order.php",
		data: {customer:customerid, pro_data:jsn}
	})
	.done(function( msg ){
	//alert(msg)
		end_loading();
		all_data_order = [];
		var jsn = JSON.parse(msg);
		
		var str = "";
		for(i=0;i<jsn.length;i++){
			var num = jsn[i];
			var pad = "000000";
			var ord="DBAO"+pad.substring(0, pad.length - num.length) + num;
			str = str+"<li>Order No. "+ord+" has been placed</li>";
		}
		$("#supplier_by_order").html(str);
		//alert("Order No. "+msg+" has been placed")
		setTimeout(function(){
			$(".left_br").removeClass('menu_border');
			$("#menu_order_list_div").addClass('menu_border');
			$("#"+TBH).hide();
			$("#order_list_div").show();
			backArr.push(TBH);
			TBH = "order_list_div";
			get_order_list2();
		},5000);
	});
}else{
if(!mov_bool){
	alert("Order has been already placed");
}
}
}
//This is for placing single order
function send_order_single(i){
if(all_data_order[i].mov<=all_data_order[i].price){

	var single_order = new Array();
	single_order.push(all_data_order[i]);
	
	var jsn = JSON.stringify(single_order);
	//alert(customerid);
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"place_order.php",
		data: {customer:customerid, pro_data:jsn}
	})
	.done(function( msg ){
		//alert(msg);
		//alert("Order No. "+msg+" has been placed")
		end_loading();
		for(q=0;q<all_data_order[i].pid.length;q++){
			var indx = product_index.indexOf(all_data_order[i].pid[q]);
			if(indx!=-1){
				product_index.splice(indx,1);
				final_list.splice(indx,1);
			}else{
				alert("Product not found");
			}
		}
		checked_product_list();
		product_list();
		var jsn = JSON.parse(msg);
		var str = "";
		for(r=0;r<jsn.length;r++){
			var num = jsn[r];
			var pad = "000000";
			var ord="DBAO"+pad.substring(0, pad.length - num.length) + num;
			str = str+"Order No. "+ord+" has been placed";
			$("#li_single_order"+i).html(str);
			$("#tableor"+i).hide();
		}
		all_data_order[i] = 0;
		var order_item = new Array();
		for(i=0;i<all_data_order.length;i++){
			if(all_data_order[i]!=0){
				order_item.push(all_data_order[i]);
			}
		}
		if(order_item.length==0){
			setTimeout(function(){
				$(".left_br").removeClass('menu_border');
				$("#menu_order_list_div").addClass('menu_border');
				$("#"+TBH).hide();
				$("#order_list_div").show();
				backArr.push(TBH);
				TBH = "order_list_div";
				get_order_list2();
			},5000);
		}
		//onBackKeyDown();
		
	});
}else{
	alert("Miniorder value is not satisfied");
}
}

function show_svdhf(i){
	$("#suvsd"+i).toggle();
}

function get_pricing()
{
	alert();
	start_loading();
	$.ajax({
		type: "GET",
		url: base_url+"recommend.php",
		data: {customer:customerid, pid:product_index}
	})
	.done(function( msg ){
		price_index = [];
		price_values = [];
		//document.getElementsByClassName('checkbox_product_list').checked = false;
		end_loading();
		price_obj = JSON.parse(msg);
		
		for(i=0;i<price_obj.length;i++){
			var row = price_obj[i];
			//document.getElementById('checkbox_product_list'+row.productid).checked=true;
			var indx = price_index.indexOf(row.productid);
			var pidxof = product_index.indexOf(row.productid);
			if(indx==-1)
			{
				price_index.push(row.productid);
				var supid = new Array();
				var pval = new Array();
				var moqi = new Array();
				var ioqi = new Array();
				var invo = new Array();
				var reba = new Array();
				var pert = new Array();
				var minq = new Array();
				var valu = new Array();
				var pcd = new Array();
				var lod = new Array();
				
				supid.push(row.supplierid)
				pval.push(row.price);
				moqi.push(row.minodrqty);
				ioqi.push(row.incrementodrqty);
				invo.push(row.offinvoice)
				reba.push(row.rebate);
				pert.push(row.precentageoff);
				valu.push(row.valueoff);
				minq.push(row.pro_min_qty);
				pcd.push(row.price_change_date);
				lod.push(row.LOD);
				var price_data = {
					id : supid,
					price : pval,
					moq : moqi,
					ioq : ioqi,
					invoice : invo,
					rebate : reba,
					peroff : pert,
					valoff : valu,
					minqty : minq,
					prchnd : pcd,
					ldo : lod
				};
				price_values.push(price_data);
				//final_list[pidxof].prem.push(parseInt(row.supplierid));
				//final_list[pidxof].premv.push(0);
				final_list[pidxof].supplier = row.supplierid;
				final_list[pidxof].price = row.price;
				final_list[pidxof].moq = row.minodrqty;
				final_list[pidxof].ioq = row.incrementodrqty;
				final_list[pidxof].invoice = row.offinvoice;
				final_list[pidxof].rebate = row.rebate;
				final_list[pidxof].peroff = row.precentageoff;
				final_list[pidxof].valoff = row.valueoff;
				final_list[pidxof].minqty = row.pro_min_qty;
				final_list[pidxof].prchnd = row.price_change_date;
			}
			else
			{
				price_values[indx].id.push(row.supplierid);
				price_values[indx].price.push(row.price);
				price_values[indx].moq.push(row.minodrqty);
				price_values[indx].ioq.push(row.incrementodrqty);
				price_values[indx].invoice.push(row.offinvoice);
				price_values[indx].rebate.push(row.rebate);
				price_values[indx].peroff.push(row.precentageoff);
				price_values[indx].valoff.push(row.valueoff);
				price_values[indx].minqty.push(row.pro_min_qty);
				price_values[indx].prchnd.push(row.price_change_date);
				price_values[indx].ldo.push(row.LOD);
				//final_list[pidxof].prem.push(parseInt(row.supplierid));
				//final_list[pidxof].premv.push(0);				
			}
			
			var indx = price_index1.indexOf(row.productid);
			var pidxof = product_index.indexOf(row.productid);
			if(indx==-1)
			{
				price_index1.push(row.productid);
				var supid = new Array();
				var pval = new Array();
				var moqi = new Array();
				var ioqi = new Array();
				var invo = new Array();
				var reba = new Array();
				var pert = new Array();
				var minq = new Array();
				var valu = new Array();
				var pcd = new Array();
				var lod = new Array();
				
				supid.push(row.supplierid)
				pval.push(row.price);
				moqi.push(row.minodrqty);
				ioqi.push(row.incrementodrqty);
				invo.push(row.offinvoice)
				reba.push(row.rebate);
				pert.push(row.precentageoff);
				valu.push(row.valueoff);
				minq.push(row.pro_min_qty);
				pcd.push(row.price_change_date);
				lod.push(row.LOD);
				var price_data = {
					id : supid,
					price : pval,
					moq : moqi,
					ioq : ioqi,
					invoice : invo,
					rebate : reba,
					peroff : pert,
					valoff : valu,
					minqty : minq,
					prchnd : pcd,
					ldo : lod
				};
				price_values1.push(price_data);
			}
			else
			{
				price_values1[indx].id.push(row.supplierid);
				price_values1[indx].price.push(row.price);
				price_values1[indx].moq.push(row.minodrqty);
				price_values1[indx].ioq.push(row.incrementodrqty);
				price_values1[indx].invoice.push(row.offinvoice);
				price_values1[indx].rebate.push(row.rebate);
				price_values1[indx].peroff.push(row.precentageoff);
				price_values1[indx].valoff.push(row.valueoff);
				price_values1[indx].minqty.push(row.pro_min_qty);
				price_values1[indx].prchnd.push(row.price_change_date);
				price_values1[indx].ldo.push(row.LOD);
			}
			
		}
	
		checked_product_list();
		product_list();
	});
}

function get_pricing_test(){
	start_loading();
	$.ajax({
		type: "GET",
		url: base_url+"recommend.php",
		data: {customer:customerid, pid:product_index}
	})
	.done(function( msg ){
		price_index = [];
		price_values = [];
		//document.getElementsByClassName('checkbox_product_list').checked = false;
		end_loading();
		//alert(msg);
		price_obj = JSON.parse(msg);
		for(i=0;i<price_obj.length;i++){
			var row = price_obj[i];
			//document.getElementById('checkbox_product_list'+row.productid).checked=true;
			var indx = price_index.indexOf(row.productid);
			var pidxof = product_index.indexOf(row.productid);
			if(indx==-1)
			{
				price_index.push(row.productid);
				var supid = new Array();
				var pval = new Array();
				var moqi = new Array();
				var ioqi = new Array();
				var invo = new Array();
				var reba = new Array();
				var pert = new Array();
				var minq = new Array();
				var valu = new Array();
				var pcd = new Array();
				var lod = new Array();
				
				supid.push(row.supplierid)
				pval.push(row.price);
				moqi.push(row.minodrqty);
				ioqi.push(row.incrementodrqty);
				invo.push(row.offinvoice)
				reba.push(row.rebate);
				pert.push(row.precentageoff);
				valu.push(row.valueoff);
				minq.push(row.pro_min_qty);
				pcd.push(row.price_change_date);
				lod.push(row.LOD);
				var price_data = {
					id : supid,
					price : pval,
					moq : moqi,
					ioq : ioqi,
					invoice : invo,
					rebate : reba,
					peroff : pert,
					valoff : valu,
					minqty : minq,
					prchnd : pcd,
					ldo : lod
				};
				price_values.push(price_data);
				//final_list[pidxof].prem.push(parseInt(row.supplierid));
				//final_list[pidxof].premv.push(0);
				final_list[pidxof].supplier = row.supplierid;
				final_list[pidxof].price = row.price;
				final_list[pidxof].moq = row.minodrqty;
				final_list[pidxof].ioq = row.incrementodrqty;
				final_list[pidxof].invoice = row.offinvoice;
				final_list[pidxof].rebate = row.rebate;
				final_list[pidxof].peroff = row.precentageoff;
				final_list[pidxof].valoff = row.valueoff;
				final_list[pidxof].minqty = row.pro_min_qty;
				final_list[pidxof].prchnd = row.price_change_date;
			}
			else
			{
				price_values[indx].id.push(row.supplierid);
				price_values[indx].price.push(row.price);
				price_values[indx].moq.push(row.minodrqty);
				price_values[indx].ioq.push(row.incrementodrqty);
				price_values[indx].invoice.push(row.offinvoice);
				price_values[indx].rebate.push(row.rebate);
				price_values[indx].peroff.push(row.precentageoff);
				price_values[indx].valoff.push(row.valueoff);
				price_values[indx].minqty.push(row.pro_min_qty);
				price_values[indx].prchnd.push(row.price_change_date);
				price_values[indx].ldo.push(row.LOD);
				//final_list[pidxof].prem.push(parseInt(row.supplierid));
				//final_list[pidxof].premv.push(0);				
			}
		}
	});
}

function get_pricing1(){
	start_loading();
	$.ajax({
		type: "GET",
		url: base_url+"recommend.php",
		data: {customer:customerid, pid:product_index}
	})
	.done(function( msg ){
		price_index = [];
		price_values = [];
		//document.getElementsByClassName('checkbox_product_list').checked = false;
		end_loading();
		//alert(msg);
		price_obj = JSON.parse(msg);
		for(i=0;i<price_obj.length;i++){
			var row = price_obj[i];
			//document.getElementById('checkbox_product_list'+row.productid).checked=true;
			var indx = price_index.indexOf(row.productid);
			var pidxof = product_index.indexOf(row.productid);
			if(indx==-1)
			{
				var supid = new Array();
				var pval = new Array();
				var moqi = new Array();
				var ioqi = new Array();
				var invo = new Array();
				var reba = new Array();
				var pert = new Array();
				var minq = new Array();
				var valu = new Array();
				var pcd = new Array();
				var lod = new Array();
				// Jatin updation
				var sp_id=parseInt(row.supplierid);
				if(final_list[pidxof].prem.indexOf(sp_id)!='-1')
				{
					price_index.push(row.productid);
					supid.push(row.supplierid)
					pval.push(row.price);
					moqi.push(row.minodrqty);
					ioqi.push(row.incrementodrqty);
					invo.push(row.offinvoice)
					reba.push(row.rebate);
					pert.push(row.precentageoff);
					valu.push(row.valueoff);
					minq.push(row.pro_min_qty);
					pcd.push(row.price_change_date);
					lod.push(row.LOD);
					var price_data = {
						id : supid,
						price : pval,
						moq : moqi,
						ioq : ioqi,
						invoice : invo,
						rebate : reba,
						peroff : pert,
						valoff : valu,
						minqty : minq,
						prchnd : pcd,
						ldo : lod
					};
					price_values.push(price_data);
				}
				
					//final_list[pidxof].prem.push(parseInt(row.supplierid));
					//final_list[pidxof].premv.push(0);
					final_list[pidxof].supplier = row.supplierid;
					final_list[pidxof].price = row.price;
					final_list[pidxof].moq = row.minodrqty;
					final_list[pidxof].ioq = row.incrementodrqty;
					final_list[pidxof].invoice = row.offinvoice;
					final_list[pidxof].rebate = row.rebate;
					final_list[pidxof].peroff = row.precentageoff;
					final_list[pidxof].valoff = row.valueoff;
					final_list[pidxof].minqty = row.pro_min_qty;
					final_list[pidxof].prchnd = row.price_change_date;
				
			}
			else
			{
					price_values[indx].id.push(row.supplierid);
					price_values[indx].price.push(row.price);
					price_values[indx].moq.push(row.minodrqty);
					price_values[indx].ioq.push(row.incrementodrqty);
					price_values[indx].invoice.push(row.offinvoice);
					price_values[indx].rebate.push(row.rebate);
					price_values[indx].peroff.push(row.precentageoff);
					price_values[indx].valoff.push(row.valueoff);
					price_values[indx].minqty.push(row.pro_min_qty);
					price_values[indx].prchnd.push(row.price_change_date);
					price_values[indx].ldo.push(row.LOD);
					//final_list[pidxof].prem.push(parseInt(row.supplierid));
					//final_list[pidxof].premv.push(0);	
									
			}
		}
		checked_product_list();
		product_list();
	});
}

function get_pricing2(id){
	start_loading();
	$.ajax({
		type: "GET",
		url: base_url+"recommend.php",
		data: {customer:customerid, pid:product_index}
	})
	.done(function( msg ){
		
		end_loading();
		price_obj = JSON.parse(msg);
		for(i=0;i<price_obj.length;i++){
			var row = price_obj[i];
			if(id==row.productid)
			var indx = price_index.indexOf(row.productid);
			var pidxof = product_index.indexOf(row.productid);
			alert("This is inside get pricing"+indx);
			if(indx==-1)
			{
				var supid = new Array();
				var pval = new Array();
				var moqi = new Array();
				var ioqi = new Array();
				var invo = new Array();
				var reba = new Array();
				var pert = new Array();
				var minq = new Array();
				var valu = new Array();
				var pcd = new Array();
				var lod = new Array();
				// Jatin updation
				var sp_id=parseInt(row.supplierid);
				if(final_list[pidxof].prem.indexOf(sp_id)!='-1')
				{
					price_index.push(row.productid);
					supid.push(row.supplierid)
					pval.push(row.price);
					moqi.push(row.minodrqty);
					ioqi.push(row.incrementodrqty);
					invo.push(row.offinvoice)
					reba.push(row.rebate);
					pert.push(row.precentageoff);
					valu.push(row.valueoff);
					minq.push(row.pro_min_qty);
					pcd.push(row.price_change_date);
					lod.push(row.LOD);
					var price_data = {
						id : supid,
						price : pval,
						moq : moqi,
						ioq : ioqi,
						invoice : invo,
						rebate : reba,
						peroff : pert,
						valoff : valu,
						minqty : minq,
						prchnd : pcd,
						ldo : lod
					};
					price_values.push(price_data);
				}
				
					//final_list[pidxof].prem.push(parseInt(row.supplierid));
					//final_list[pidxof].premv.push(0);
					final_list[pidxof].supplier = row.supplierid;
					final_list[pidxof].price = row.price;
					final_list[pidxof].moq = row.minodrqty;
					final_list[pidxof].ioq = row.incrementodrqty;
					final_list[pidxof].invoice = row.offinvoice;
					final_list[pidxof].rebate = row.rebate;
					final_list[pidxof].peroff = row.precentageoff;
					final_list[pidxof].valoff = row.valueoff;
					final_list[pidxof].minqty = row.pro_min_qty;
					final_list[pidxof].prchnd = row.price_change_date;
				
			}
			else
			{
					price_values[indx].id.push(row.supplierid);
					price_values[indx].price.push(row.price);
					price_values[indx].moq.push(row.minodrqty);
					price_values[indx].ioq.push(row.incrementodrqty);
					price_values[indx].invoice.push(row.offinvoice);
					price_values[indx].rebate.push(row.rebate);
					price_values[indx].peroff.push(row.precentageoff);
					price_values[indx].valoff.push(row.valueoff);
					price_values[indx].minqty.push(row.pro_min_qty);
					price_values[indx].prchnd.push(row.price_change_date);
					price_values[indx].ldo.push(row.LOD);
					//final_list[pidxof].prem.push(parseInt(row.supplierid));
					//final_list[pidxof].premv.push(0);	
									
			}
			}
	
		/* checked_product_list();
		product_list(); */
	});
}

function list_subsi_product(index,cat_id_to_show,sub_cat_to_show){
var kpr = "";
var idx = -1;
	for(i=0;i<obj.length;i++)
	{
		var row = obj[i];
		var pid = obj[i].productid;
		var pad = "000000";
		var ord="DBAP"+pad.substring(0, pad.length - row.productid.length) + row.productid;
		idx = final_list[index].subs.indexOf(pid);
			var img_paht = "";
			if(row.picture1=='a' || row.picture1==""){
				img_paht = "images/a.png";
			}else{
				img_paht = base_url2+"upload/"+row.picture1;
			}
		if(row.productcategoryid==cat_id_to_show && row.productsubcategoryid==sub_cat_to_show)
			{
			if(idx!=-1){
				
				kpr = kpr + "<div class='pp-product'><div class='pp-product-selector'><input type='checkbox' checked onclick=subpro("+index+",'"+row.productid+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_paht+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+row.productlabel+"</div><div class='pp-product-description'>Product ID-"+ord+" - "+row.productdescription+"</div></div></div>";
			}else{
				kpr = kpr + "<div class='pp-product'><div class='pp-product-selector'><input type='checkbox' onclick=subpro("+index+",'"+row.productid+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_paht+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+row.productlabel+"</div><div class='pp-product-description'>Product ID-"+ord+" - "+row.productdescription+"</div></div></div>";
			}
		}
	}
	$('#category_id2').val(cat_id_to_show);
	$("#product_view2").html(kpr);
	$('.overlay').fadeIn(100); 
	$('#product_picker2').fadeIn(100); 
}

function checked_product_list(){
		var kpr="";
		var kpr1="";
		for(i=0;i<obj.length;i++){
			var row = obj[i];
			var img_paht = "";
			
			if(row.picture1=='a' || row.picture1==""){
				img_paht = "images/a.png";
			}else{
				img_paht = base_url2+"upload/"+row.picture1;
			}
			if(product_index.indexOf(row.productid)!=-1){
				kpr = kpr+ "<div class='pp-product pickpc'><div class='pp-product-selector'><input type='checkbox' checked onclick=add_product('"+row.productid+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_paht+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+row.productlabel+"</div><div class='pp-product-description'>"+row.productdescription+"</div></div></div>";
			}
			else{
				kpr = kpr+ "<div class='pp-product pickpc'><div class='pp-product-selector'><input type='checkbox' onclick=add_product('"+row.productid+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_paht+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+row.productlabel+"</div><div class='pp-product-description'>"+row.productdescription+"</div></div></div>";
			}
		}
		$("#product_view1").html(kpr);
}

function loading(){
	product_index = [];
	price_index = [];
	price_values = [];
	global_suplier = [];
	global_premium = [];
	sc_index = [];
	//supplier id is s_index,product ids is p_index
	s_index = [];
	p_index = [];
	supplier_order = [];
	final_list = [];
	global_setting_checked = [];
	start_loading();
	$.ajax({
		type: "GET",
		url: base_url+"get_product.php",
		data: {}
	})
	.done(function( msg ){
		//alert(msg);
		obj = JSON.parse(msg);
		var kpr="";
		var kpr1="";
		for(i=0;i<obj.length;i++){
			var row = obj[i];
			p_index.push(row.productid);
			var img_paht = "";
			if(row.picture1=='a' || row.picture1==""){
				img_paht = "images/a.png";
			}else{
				img_paht = base_url2+"upload/"+row.picture1;
			}
			if(product_index.indexOf(row.productid)!=-1){
				kpr = kpr+ "<div class='pp-product'><div class='pp-product-selector'><input type='checkbox' checked onclick=add_product('"+row.productid+"') id='checkbox_product_list"+row.productid+"' class='checkbox_product_list' /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_paht+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+row.productlabel+"</div><div class='pp-product-description'>"+row.productdescription+"</div></div></div>";
			}
			else{
				kpr = kpr+ "<div class='pp-product'><div class='pp-product-selector'><input type='checkbox' onclick=add_product('"+row.productid+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_paht+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+row.productlabel+"</div><div class='pp-product-description'>"+row.productdescription+"</div></div></div>";
			}
		}
		$("#product_view1").html(kpr);
		get_profile_list();
		dash_bord_report(1);
	});
	$.ajax({
		type: "GET",
		url: base_url2+"get_supplier.php",
		data: {}
	})
	.done(function( msg ){
		//alert(msg);
		sup_obj = JSON.parse(msg);
		global_suplier = [];
		global_premium = [];
		for(i=0;i<sup_obj.length;i++){
			var row = sup_obj[i];
			s_index.push(row.supplierid);
			global_suplier.push(parseInt(row.supplierid));
			global_premium.push(0);
		}
	});
	$.ajax({
		type: "GET",
		url: base_url2+"get_cat.php",
		data: {}
	})
	.done(function( msg ){
		//alert(msg);
		var ofj = JSON.parse(msg);
		var str_cat = "<option value=''>All</option>";
		for(i=0;i<ofj.length;i++){
			var row = ofj[i];
			str_cat = str_cat + "<option value='"+row.productcategoryid+"'>"+row.productcategoryname+"</option>";
		}
		$("#category_id").html(str_cat);
		$("#category_id2").html(str_cat);
	});
	//alert(customerid);
	$.ajax({
		type: "GET",
		url: base_url+"relation.php",
		data: {customer:customerid}
	})
	.done(function( msg ){
		//alert(msg);
		sc_obj = JSON.parse(msg);
		//alert(sc_obj.length);
		for(i=0;i<sc_obj.length;i++){
			//alert(sc_obj[i].minimumordervalue);
			sc_index.push(sc_obj[i].supplierid);
		}
	});
	
	$.ajax({
		type: "POST",
		url: base_url+"get_notification.php",
		data: {customer:customerid}
	})
	.done(function(msg){
		//alert(msg);
		
		var str = "";
		var jsn = JSON.parse(msg);
		var nc = 0 ;
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			if(row.readstatus!=1){
				nc++;
			}
		}
		
		//alert(jsn.length);
		if(nc==0){
			$('.not').hide();
		}else{
			$("#not_num").html(nc);
		}
	});
	
}

function dash_bord_report(time){
if(time==12){
	$("#mtd").removeClass();
	$("#ytd").addClass("a-active");
	$("#nmtd1").html("Total Spend (YTD)");
	$("#nmtd2").html("Total Savings (YTD)");
}else{
	$("#ytd").removeClass();
	$("#mtd").addClass("a-active");
	$("#nmtd1").html("Total Spend (MTD)");
	$("#nmtd2").html("Total Savings (MTD)");
}
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"get_report.php",
		data: {customer:customerid, t:time}
	})
	.done(function(msg){
		//alert(msg);
		end_loading();
		msg = JSON.parse(msg);
		
		$("#dash_max_supplier").html("$"+msg.max_supplier);
		$("#dash_save").html("$"+msg.t_saving);
		$("#dash_total_spend").html("$"+msg.total_spend);
		$("#dash_max_pro_spend").html("$"+msg.max_pro_spend);
		if(obj!=null){
			var index = p_index.indexOf(msg.max_pro_id);
			if(index!=-1){
			$("#dash_max_pro_id").html("Max. Spend with Product – "+obj[index].productlabel);
			}
		}
		if(sup_obj!=null){
			var index = s_index.indexOf(msg.max_supplierid);
			if(index!=-1){
			$("#dash_max_supplierid").html("Max. Spend with Supplier – "+sup_obj[index].businessname);
			}
		}
	});
}

function subpro(index, id){
	//alert(index+"----"+id);
	var idx = final_list[index].subs.indexOf(id);
	if(idx==-1){
		final_list[index].subs.push(id);
	}else{
		final_list[index].subs.splice(idx,1);
	}
	var jsn = JSON.stringify(final_list);
	//alert(jsn);
	$("#pro_data").val(jsn);
}


//These are not used now
function presup(index, id)
{
	var idx = final_list[index].prem.indexOf(id);	
	if(idx==-1)
	{
		var prvid = index+"prem"+id;
		final_list[index].prem.push(id);
		final_list[index].premv.push($("#"+prvid).val());		
		var indx = removed_product_index.indexOf(final_list[index].id);		
		if(indx!=-1)
		{
			var prinx = price_index.indexOf(final_list[index].id);
			if(prinx!=-1)
			{
				var rvix = removed_supplier_index[indx].sid.indexOf(id);
				if(rvix!=-1){
					//alert(removed_supplier_index[indx].pda[rvix].id);
					price_values[prinx].id.push(removed_supplier_index[indx].pda[rvix].id);
					price_values[prinx].price.push(removed_supplier_index[indx].pda[rvix].price);
					price_values[prinx].moq.push(removed_supplier_index[indx].pda[rvix].moq);
					price_values[prinx].ioq.push(removed_supplier_index[indx].pda[rvix].ioq);
					price_values[prinx].invoice.push(removed_supplier_index[indx].pda[rvix].invoice);
					price_values[prinx].rebate.push(removed_supplier_index[indx].pda[rvix].rebate);
					price_values[prinx].peroff.push(removed_supplier_index[indx].pda[rvix].peroff);
					price_values[prinx].valoff.push(removed_supplier_index[indx].pda[rvix].valoff);
					price_values[prinx].minqty.push(removed_supplier_index[indx].pda[rvix].minqty);
					price_values[prinx].prchnd.push(removed_supplier_index[indx].pda[rvix].prchnd);
					price_values[prinx].ldo.push(removed_supplier_index[indx].pda[rvix].ldo);
				}
			}
			else
			{
				var rvix = removed_supplier_index[indx].sid.indexOf(id);
				if(rvix!=-1){
					price_index.push(final_list[index].id);
					var supid = new Array();
					var pval = new Array();
					var moqi = new Array();
					var ioqi = new Array();
					var invo = new Array();
					var reba = new Array();
					var pert = new Array();
					var minq = new Array();
					var valu = new Array();
					var pcd = new Array();
					var lod = new Array();
					supid.push(removed_supplier_index[indx].pda[rvix].id);
					pval.push(removed_supplier_index[indx].pda[rvix].price);
					moqi.push(removed_supplier_index[indx].pda[rvix].moq);
					ioqi.push(removed_supplier_index[indx].pda[rvix].ioq);
					invo.push(removed_supplier_index[indx].pda[rvix].invoice)
					reba.push(removed_supplier_index[indx].pda[rvix].rebate);
					pert.push(removed_supplier_index[indx].pda[rvix].peroff);
					valu.push(removed_supplier_index[indx].pda[rvix].valoff);
					minq.push(removed_supplier_index[indx].pda[rvix].minqty);
					pcd.push(removed_supplier_index[indx].pda[rvix].prchnd);
					lod.push(removed_supplier_index[indx].pda[rvix].ldo);
					var price_data = {
						id : supid,
						price : pval,
						moq : moqi,
						ioq : ioqi,
						invoice : invo,
						rebate : reba,
						peroff : pert,
						valoff : valu,
						minqty : minq,
						prchnd : pcd,
						ldo : lod
					};
					price_values.push(price_data);
				}
			}		
		}
		else
		{
			var pid_n=final_list[index].id;
			get_pricing2(pid_n);
			//alert(final_list[index].id);
		}
	}
	else
	{
		final_list[index].prem.splice(idx,1);
		final_list[index].premv.splice(idx,1);
		var indx = price_index.indexOf(final_list[index].id);
		//alert(indx);
		if(indx!=-1){
			var kid = ""+id;
			var kxd = price_values[indx].id.indexOf(kid);
			//alert(kxd);
			if(kxd!=-1){
				var price_data = {
					id : price_values[indx].id[kxd],
					price : price_values[indx].price[kxd],
					moq : price_values[indx].moq[kxd],
					ioq : price_values[indx].ioq[kxd],
					invoice : price_values[indx].invoice[kxd],
					rebate : price_values[indx].rebate[kxd],
					peroff : price_values[indx].peroff[kxd],
					valoff : price_values[indx].valoff[kxd],
					minqty : price_values[indx].minqty[kxd],
					prchnd : price_values[indx].prchnd[kxd],
					ldo : price_values[indx].ldo[kxd]
				};
				var rindx = removed_product_index.indexOf(final_list[index].id);
				if(rindx==-1){
					var sidg = new Array();
					var padt = new Array();
					padt.push(price_data);
					sidg.push(id);
					var da = {
						pid : final_list[index].id,
						sid : sidg,
						pda : padt
					}
					removed_supplier_index.push(da);
					removed_product_index.push(final_list[index].id);
				}else{
					removed_supplier_index[rindx].sid.push(id);
					removed_supplier_index[rindx].pda.push(price_data);
				}
				price_values[indx].id.splice(kxd,1);
				price_values[indx].price.splice(kxd,1);
				price_values[indx].moq.splice(kxd,1);
				price_values[indx].ioq.splice(kxd,1);
				price_values[indx].invoice.splice(kxd,1);
				price_values[indx].rebate.splice(kxd,1);
				price_values[indx].peroff.splice(kxd,1);
				price_values[indx].valoff.splice(kxd,1);
				price_values[indx].minqty.splice(kxd,1);
				price_values[indx].prchnd.splice(kxd,1);
				price_values[indx].ldo.splice(kxd,1);
				
				//alert(price_values[indx].id.length);
				
				if(price_values[indx].id.length==0){
					price_values.splice(indx,1);
					price_index.splice(indx,1);
				}
			}
		}
	}
	var jsn = JSON.stringify(final_list);
	//alert(jsn);
	$("#pro_data").val(jsn);
}

function presup1(sid)
{
	alert("Presup1 called");
	var index = global_suplier.indexOf(sid);
	if(index==-1)
	{
		global_suplier.push(sid);
		global_premium.push($("#gprem"+sid).val());
	}
	else
	{
		global_suplier.splice(index,1);
		global_premium.splice(index,1);
	}
	for(var i=0;i< final_list.length;i++)
	{
		id=sid;
		index=i;		
		if($("#checkbox_"+sid).prop('checked'))
		{			
			var idx = final_list[index].prem.indexOf(id);
			if(idx==-1)
			{
				var prvid = index+"prem"+id;
				final_list[index].prem.push(id);
				final_list[index].premv.push($("#gprem"+sid).val());					
				var indx = removed_product_index1.indexOf(final_list[index].id);
				if(indx!=-1)
				{
					var prinx = price_index.indexOf(final_list[index].id);
					if(prinx!=-1)
					{
						var rvix = removed_supplier_index1[indx].sid.indexOf(id);
						if(rvix!=-1)
						{
							price_values[prinx].id.push(removed_supplier_index1[indx].pda[rvix].id);
							price_values[prinx].price.push(removed_supplier_index1[indx].pda[rvix].price);
							price_values[prinx].moq.push(removed_supplier_index1[indx].pda[rvix].moq);
							price_values[prinx].ioq.push(removed_supplier_index1[indx].pda[rvix].ioq);
							price_values[prinx].invoice.push(removed_supplier_index1[indx].pda[rvix].invoice);
							price_values[prinx].rebate.push(removed_supplier_index1[indx].pda[rvix].rebate);
							price_values[prinx].peroff.push(removed_supplier_index1[indx].pda[rvix].peroff);
							price_values[prinx].valoff.push(removed_supplier_index1[indx].pda[rvix].valoff);
							price_values[prinx].minqty.push(removed_supplier_index1[indx].pda[rvix].minqty);
							price_values[prinx].prchnd.push(removed_supplier_index1[indx].pda[rvix].prchnd);
							price_values[prinx].ldo.push(removed_supplier_index1[indx].pda[rvix].ldo);
						}
					}
				else
				{
					var rvix = removed_supplier_index1[indx].sid.indexOf(id);
					if(rvix!=-1)
					{
							price_index.push(final_list[index].id);
							var supid = new Array();
							var pval = new Array();
							var moqi = new Array();
							var ioqi = new Array();
							var invo = new Array();
							var reba = new Array();
							var pert = new Array();
							var minq = new Array();
							var valu = new Array();
							var pcd = new Array();
							var lod = new Array();
							supid.push(removed_supplier_index1[indx].pda[rvix].id);
							pval.push(removed_supplier_index1[indx].pda[rvix].price);
							moqi.push(removed_supplier_index1[indx].pda[rvix].moq);
							ioqi.push(removed_supplier_index1[indx].pda[rvix].ioq);
							invo.push(removed_supplier_index1[indx].pda[rvix].invoice)
							reba.push(removed_supplier_index1[indx].pda[rvix].rebate);
							pert.push(removed_supplier_index1[indx].pda[rvix].peroff);
							valu.push(removed_supplier_index1[indx].pda[rvix].valoff);
							minq.push(removed_supplier_index1[indx].pda[rvix].minqty);
							pcd.push(removed_supplier_index1[indx].pda[rvix].prchnd);
							lod.push(removed_supplier_index1[indx].pda[rvix].ldo);
							var price_data = 
							{
								id : supid,
								price : pval,
								moq : moqi,
								ioq : ioqi,
								invoice : invo,
								rebate : reba,
								peroff : pert,
								valoff : valu,
								minqty : minq,
								prchnd : pcd,
								ldo : lod
							};
							price_values.push(price_data);
						}
					}
				}
				
			}
		}
		else
		{
			var idx = final_list[index].prem.indexOf(id);
			final_list[index].prem.splice(idx,1);
			final_list[index].premv.splice(idx,1);
			var indx = price_index.indexOf(final_list[index].id);
			//alert(indx);
			if(indx!=-1){
				var kid = ""+id;
				var kxd = price_values[indx].id.indexOf(kid);
				//alert(kxd);
				if(kxd!=-1){
					var price_data = {
						id : price_values[indx].id[kxd],
						price : price_values[indx].price[kxd],
						moq : price_values[indx].moq[kxd],
						ioq : price_values[indx].ioq[kxd],
						invoice : price_values[indx].invoice[kxd],
						rebate : price_values[indx].rebate[kxd],
						peroff : price_values[indx].peroff[kxd],
						valoff : price_values[indx].valoff[kxd],
						minqty : price_values[indx].minqty[kxd],
						prchnd : price_values[indx].prchnd[kxd],
						ldo : price_values[indx].ldo[kxd]
					};
					var rindx = removed_product_index1.indexOf(final_list[index].id);
					if(rindx==-1){
						var sidg = new Array();
						var padt = new Array();
						padt.push(price_data);
						sidg.push(id);
						var da = {
							pid : final_list[index].id,
							sid : sidg,
							pda : padt
						}
						removed_supplier_index1.push(da);
						removed_product_index1.push(final_list[index].id);
					}else{
						removed_supplier_index1[rindx].sid.push(id);
						removed_supplier_index1[rindx].pda.push(price_data);
					}
					price_values[indx].id.splice(kxd,1);
					price_values[indx].price.splice(kxd,1);
					price_values[indx].moq.splice(kxd,1);
					price_values[indx].ioq.splice(kxd,1);
					price_values[indx].invoice.splice(kxd,1);
					price_values[indx].rebate.splice(kxd,1);
					price_values[indx].peroff.splice(kxd,1);
					price_values[indx].valoff.splice(kxd,1);
					price_values[indx].minqty.splice(kxd,1);
					price_values[indx].prchnd.splice(kxd,1);
					price_values[indx].ldo.splice(kxd,1);
					
					//alert(price_values[indx].id.length);
					
					if(price_values[indx].id.length==0){
						price_values.splice(indx,1);
						price_index.splice(indx,1);
					}
				}
			}
		}	
	}
}
function presup2(k,sid)
{
	global_premium[k] = $("#gprem"+sid).val();
	
}

// These function are changed

function pro_qty_up(index, moq){
	var fhgti = $("#pqty"+index).val();
	fhgti++;
	//alert(fhgti);
	final_list[index].qty= fhgti;
	$("#pqty"+index).val(final_list[index].qty);
	
	if(final_list[index].qty==moq){
		$("#pqty"+index).css("border", "1px solid silver");
	}else if(final_list[index].qty<moq){
		$("#pqty"+index).css("border", "1px solid rgb(206, 0, 0)");
	}else if(final_list[index].qty>moq){
		var ipo = parseInt(final_list[index].qty) - parseInt(final_list[index].moq);
		var kpo = ipo%parseInt(final_list[index].ioq);
		if(kpo==0){
			$("#pqty"+index).css("border", "1px solid silver");
		}else{
			$("#pqty"+index).css("border", "1px solid rgb(206, 0, 0)");
		}
		//$("#pqty"+index).css("border", "1px solid silver");
	}
	var jsn = JSON.stringify(final_list);
	//alert(jsn);
	$("#pro_data").val(jsn);
	var fng = 0;
	var siddh = final_list[index].supplier;
	for(m=0;m<final_list.length;m++){
		if(siddh==final_list[m].supplier){
			var hjkf = parseInt(final_list[m].qty);
			var sdjn = parseInt(final_list[m].price);
			fng = fng + (hjkf*sdjn);
		}
	}
	var indxgfd = sc_index.indexOf(siddh);
	var mov = sc_obj[indxgfd].minimumordervalue;
	//alert(fng+"----"+mov);
	if(fng>=mov){
		document.getElementById("footer"+siddh).style.borderTop = "3px solid rgb(105, 172, 53)";
	}else{
		document.getElementById("footer"+siddh).style.borderTop = "3px solid rgb(206, 0, 0)";
	}
}

function pro_qty(index, moq)
{
	final_list[index].qty = $("#pqty"+index).val();
	if(final_list[index].qty==moq)
	{
		$("#pqty"+index).css("border", "1px solid silver");
	}else if(final_list[index].qty<moq){
		$("#pqty"+index).css("border", "1px solid rgb(206, 0, 0)");
	}else if(final_list[index].qty>moq)
	{
		var ipo = parseInt(final_list[index].qty) - parseInt(final_list[index].moq);
		var kpo = ipo%parseInt(final_list[index].ioq);
		if(kpo==0){
			$("#pqty"+index).css("border", "1px solid silver");
		}else{
			$("#pqty"+index).css("border", "1px solid rgb(206, 0, 0)");
		}
		//$("#pqty"+index).css("border", "1px solid silver");
	}
	var fng = 0;
	var siddh = final_list[index].supplier;
	for(m=0;m<final_list.length;m++){
		if(siddh==final_list[m].supplier){
			var hjkf = parseInt(final_list[m].qty);
			var sdjn = parseInt(final_list[m].price);
			fng = fng + (hjkf*sdjn);
		}
	}
	var indxgfd = sc_index.indexOf(siddh);
	var mov = sc_obj[indxgfd].minimumordervalue;
	if(fng>=mov){
		document.getElementById("footer"+siddh).style.borderTop = "3px solid rgb(105, 172, 53)";
	}else{
		document.getElementById("footer"+siddh).style.borderTop = "3px solid rgb(206, 0, 0)";
	}
}
function pro_qty_down(index, moq){
	var hbsdg = $("#pqty"+index).val();
	if(hbsdg>0){
		hbsdg--;
		final_list[index].qty= hbsdg;
		$("#pqty"+index).val(final_list[index].qty);
	}
	if(final_list[index].qty==moq){
		$("#pqty"+index).css("border", "1px solid silver");
	}else if(final_list[index].qty<moq){
		$("#pqty"+index).css("border", "1px solid rgb(206, 0, 0)");
	}else if(final_list[index].qty>moq){
		var ipo = parseInt(final_list[index].qty) - parseInt(final_list[index].moq);
		var kpo = ipo%parseInt(final_list[index].ioq);
		if(kpo==0){
			$("#pqty"+index).css("border", "1px solid silver");
		}else{
			$("#pqty"+index).css("border", "1px solid rgb(206, 0, 0)");
		}
		//$("#pqty"+index).css("border", "1px solid silver");
	}
	var jsn = JSON.stringify(final_list);
	//alert(jsn);
	$("#pro_data").val(jsn);
	var fng = 0;
	var siddh = final_list[index].supplier;
	for(m=0;m<final_list.length;m++){
		if(siddh==final_list[m].supplier){
			var hjkf = parseInt(final_list[m].qty);
			var sdjn = parseInt(final_list[m].price);
			fng = fng + (hjkf*sdjn);
		}
	}
	var indxgfd = sc_index.indexOf(siddh);
	var mov = sc_obj[indxgfd].minimumordervalue;
	if(fng>=mov){
		document.getElementById("footer"+siddh).style.borderTop = "3px solid rgb(105, 172, 53)";
	}else{
		document.getElementById("footer"+siddh).style.borderTop = "3px solid rgb(206, 0, 0)";
	}
}

function prem_val(index){
	var va = $("#pqty"+index).val();
	final_list[index].qty = $("#pqty"+index).val();
	
	var jsn = JSON.stringify(final_list);
	//alert(jsn);
	$("#pro_data").val(jsn);
}

function save_profile(){
	$('.save-save-as span').hide();
	var jsn = JSON.stringify(final_list);
	var for_email = prompt("Enter profile name: ","");
	if(for_email!=null){
	start_loading();
	//alert(jsn);
	$.ajax({
		type: "POST",
		url: base_url+"profile.php",
		data: {pro_data:jsn, customer:customerid, name:for_email, id:0}
	})
	.done(function( msg ){
		//alert(msg);
		end_loading();
		alert("Profile saved");
		//msg = msg.trim();
		var str = "<li onclick='product_edit("+msg+")'>"+for_email+"</li>";
		$("#profile_list").append(str);
		product_edit(msg);
		//final_list = [];
		//product_index = [];
		//product_list();
	});
	
	}else{
	}
}

function showt(pref, index){
	$("#"+pref+index).toggle();
}
var togle_lower_pre  = ""
function togle_lower(id){
	$('.save-save-as span').hide();
	//$('.open-info').hide();
	$("#profile_list").hide();
	if(togle_lower_pre==id){
		//alert("in");
		$("#lower"+id).toggle();
	}else{
		//alert("el");
		$("#lower"+id).toggle();
		$("#lower"+togle_lower_pre).hide();
	}
	togle_lower_pre = id;
}

function set_premv(id){
	//alert($("#"+id).val());
	var p = id.split("prem");
	var index = p[0];
	var i = parseInt(p[1]);
	var pindx = final_list[index].prem.indexOf(i);
	if(pindx!=-1){
		final_list[index].premv[pindx]= $("#"+id).val();
	}
	var productid = final_list[index].id;
	var idx = price_index.indexOf(productid);
	if(idx!=-1){
		var min_a = 100000; 
		var min_k = 0;
		for(k=0;k<price_values[idx].price.length;k++){
			var p = parseInt(price_values[idx].price[k]);
			var v = parseInt(final_list[index].premv[k]);
			var virtual_price = p - ((p*v)/100);
			//alert(virtual_price)
			if(min_a>virtual_price){
				min_a = virtual_price;
				min_k = k;
			}
		}
		//alert(min_k);
		var temp = price_values[idx].price[0];
		price_values[idx].price[0] = price_values[idx].price[min_k];
		price_values[idx].price[min_k] = temp;
		var temp1 = price_values[idx].id[0];
		price_values[idx].id[0] = price_values[idx].id[min_k];
		price_values[idx].id[min_k] = temp1;
		var temp2 = price_values[idx].moq[0];
		price_values[idx].moq[0] = price_values[idx].moq[min_k];
		price_values[idx].moq[min_k] = temp2;
		var temp3 = price_values[idx].ioq[0];
		price_values[idx].ioq[0] = price_values[idx].ioq[min_k];
		price_values[idx].ioq[min_k] = temp3;
		
		var temp = price_values[idx].invoice[0];
		price_values[idx].invoice[0] = price_values[idx].invoice[min_k];
		price_values[idx].invoice[min_k] = temp;
		var temp1 = price_values[idx].rebate[0];
		price_values[idx].rebate[0] = price_values[idx].rebate[min_k];
		price_values[idx].rebate[min_k] = temp1;
		var temp2 = price_values[idx].valoff[0];
		price_values[idx].valoff[0] = price_values[idx].valoff[min_k];
		price_values[idx].valoff[min_k] = temp2;
		var temp3 = price_values[idx].peroff[0];
		price_values[idx].peroff[0] = price_values[idx].peroff[min_k];
		price_values[idx].peroff[min_k] = temp3;
		var temp3 = price_values[idx].minqty[0];
		price_values[idx].minqty[0] = price_values[idx].minqty[min_k];
		price_values[idx].minqty[min_k] = temp3;
		var temp3 = price_values[idx].prchnd[0];
		price_values[idx].prchnd[0] = price_values[idx].prchnd[min_k];
		price_values[idx].prchnd[min_k] = temp3;
		
		var temp3 = price_values[idx].ldo[0];
		price_values[idx].ldo[0] = price_values[idx].ldo[min_k];
		price_values[idx].ldo[min_k] = temp3;
		
		final_list[index].price = price_values[idx].price[0];
		final_list[index].supplier = price_values[idx].id[0];
		final_list[index].moq = price_values[idx].moq[0];
		final_list[index].ioq = price_values[idx].ioq[0];
		final_list[index].invoice = price_values[idx].invoice[0];
		final_list[index].rebate = price_values[idx].rebate[0];
		final_list[index].peroff = price_values[idx].peroff[0];
		final_list[index].valoff = price_values[idx].valoff[0];
		final_list[index].minqty = price_values[idx].minqty[0];
		final_list[index].prchnd = price_values[idx].prchnd[0];
		product_list();
	}
}

function hide()
{					
	$("#myModal").hide();
	$(".fade").removeClass('in');
	$( ".modal-backdrop" ).remove();					
}

function product_edit(id){
	start_loading();
	$("#profile_list").hide();
	$.ajax({
		type: "GET",
		url: base_url2+"get_profile.php",
		data: {d:id}
	})
	.done(function( msg ){
		end_loading();
		//alert(msg);
		final_list=[];
		product_index = [];
		price_values = [];
		price_index = [];
		
		var objt = JSON.parse(msg);
		$("#profile_name").html(objt['head']['name']);
		active_profile_name=objt['head']['name'];
		active_profile_id = id;
		var ord  = objt['orderdetails'];
		for(i=0;i<ord.length;i++){
			var pid = ord[i]['id'];
			var qt = ord[i]['qty'];
			var subp = ord[i]['subs'];
			subp = subp.split(",");
			var subsi = new Array();
			for(j=0;j<subp.length;j++){
				subsi.push(subp[j]);
			}
			var premiv = new Array();
			var premi = new Array();
			var prems = ord[i]['prem'];
			prems = prems.split(",");
			for(j=0;j<global_suplier.length;j++){
				premi.push(global_suplier[j]);
				premiv.push(0);
			}
			
			
			var premvs = ord[i]['premv'];
			premvs = premvs.split(",");
			for(j=0;j<prems.length;j++){
				var inkx = global_suplier.indexOf(parseInt(prems[j]));
				if(inkx!=-1){
					premiv[inkx] = premvs[j];
				}
			}
			var pack = {
				id : pid,
				subs: subsi,
				prem:premi,
				premv:premiv,
				qty: qt
			}
			//Final_list contains profile data like id,subs,prem,premv
			final_list.push(pack);
			product_index.push(pid);
		}
		var jsn = JSON.stringify(final_list);
		get_pricing();
	});
}
function update_personal_profile(){
	navigator.notification.confirm(
		'Are you sure that you want to update this profile?',  // message
		onupdate_personal_profile,              // callback to invoke with index of button pressed
		'DBA',            // title
		'No, Yes'          // buttonLabels
	);
}

function onupdate_personal_profile(button){
if(button==2){
	$('.save-save-as span').hide();
	var jsn = JSON.stringify(final_list);
	//alert(jsn)
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"profile.php",
		data: {pro_data:jsn, customer:customerid, name:active_profile_name, id:active_profile_id}
	})
	.done(function( msg ){
		//alert(msg);
		end_loading();
		alert("Profile saved");
		//final_list = [];
		//product_index = [];
		//product_list();
	}); 
}
}

function add_new_function()
{	
	$("#add_edit").val(0);
	$("#all")[0].reset();
	$("#lis_div").html('');
	$(".modal-footer").show();
	$("#update").hide();
	final_list = [];
	product_index = [];
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
		data: {local:str, table:"orderprofile", column:"id"}
	})
	.done(function( msg ){
						
	});
	
	for(i=0;i<checklist.length;i++){
		$("#"+checklist[i]).hide();
	}
}

function get_subcat(){
	//start_loading();
	var id=$("#category_id").val();
	$.ajax({
		type: "GET",
		url: base_url+"get_subcat.php",
		data: {cid:id}
	})
	.done(function( msg ) {
		//end_loading();
		var str = "<option value=''>ALL</option>";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			str = str + "<option value='"+row.productsubcategoryid+"'>"+row.productsubcategoryname+"</option>";
		}
		$("#subcat_id").html(str);
		$("#subcat_id2").html(str);
	});
}

function product_filter(){
	//start_loading();
	var catid=$("#category_id").val();
	var subcatid=$("#subcat_id").val();
	$.ajax({
		type: "GET",
		url: base_url2+"product_filter.php",
		data: {cat:catid, sub:subcatid, srch:""}
	})
	.done(function( msg ){
		//alert(msg)
		//end_loading();
		var objt = JSON.parse(msg);
		var kpr = "";
		for(i=0;i<objt.length;i++){
			var row = objt[i];
			var img_paht = "";
			if(row.picture1=='a' || row.picture1==""){
				img_paht = "images/a.png";
			}else{
				img_paht = base_url2+"upload/"+row.picture1;
			}
			if(product_index.indexOf(row.productid)!=-1){
				kpr = kpr+ "<div class='pp-product pickpc'><div class='pp-product-selector'><input type='checkbox' checked onclick=add_product('"+row.productid+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_paht+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+row.productlabel+"</div><div class='pp-product-description'>"+row.productdescription+"</div></div></div>";
			}
			else{
				kpr = kpr+ "<div class='pp-product pickpc'><div class='pp-product-selector'><input type='checkbox' onclick=add_product('"+row.productid+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_paht+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+row.productlabel+"</div><div class='pp-product-description'>"+row.productdescription+"</div></div></div>";
			}
		}
		$("#product_view1").html(kpr);
	});
}

function search_filter(){
	var txt = $("#pp_searchtxt").val();
	$(".pickpc").hide();
	$( ".pickpc:containsIN('"+txt+"')" ).show();
}

function all_product(){
	var catid=$("#category_id").val();
	var subcatid=$("#subcat_id").val();
	$.ajax({
		type: "GET",
		url: base_url2+"product_filter.php",
		data: {cat:"", sub:"", srch:""}
	})
	.done(function( msg ) {
	//alert(msg);
		var objt = JSON.parse(msg);
		var kpr = "";
		for(i=0;i<objt.length;i++){
			var row = objt[i];
			var img_paht = "";
			if(row.picture1=='a' || row.picture1==""){
				img_paht = "images/a.png";
			}else{
				img_paht = base_url2+"upload/"+row.picture1;
			}
			if(product_index.indexOf(row.productid)!=-1){
				kpr = kpr+ "<div class='pp-product pickpc'><div class='pp-product-selector'><input type='checkbox' checked onclick=add_product('"+row.productid+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_paht+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+row.productlabel+"</div><div class='pp-product-description'>"+row.productdescription+"</div></div></div>";
			}
			else{
				kpr = kpr+ "<div class='pp-product pickpc'><div class='pp-product-selector'><input type='checkbox' onclick=add_product('"+row.productid+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_paht+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+row.productlabel+"</div><div class='pp-product-description'>"+row.productdescription+"</div></div></div>";
			}
		}
		$("#product_view1").html(kpr);
	});
}

function show_pro_over(id){

	$('#overlay_box').show();
	$('#product_popup2').show();
	var catid=$("#category_id1").val();
	var subcatid=$("#subcat_id1").val();
	$.ajax({
		type: "GET",
		url: base_url2+"product_filter.php",
		data: {cat:"", sub:""}
	})
	.done(function( msg ) {
	//alert(msg);
		var objt = JSON.parse(msg);
		var str = "";
		for(i=0;i<objt.length;i++){
			var indx = final_list[id].subs.indexOf(objt[i]['productid']);
			if(indx!=-1){
				str = str + "<div class='left'><input type='checkbox' checked onclick=subpro("+id+",'"+objt[i]['productid']+"') /><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><label>"+objt[i]['productdescription']+"</label></div>";
			}else{
				str = str + "<div class='left'><input type='checkbox' onclick=subpro("+id+",'"+objt[i]['productid']+"') /><img src='upload/"+objt[i]['picture1']+"'><small>"+objt[i]['productlabel']+"</small><label>"+objt[i]['productdescription']+"</label></div>";
			}
		}
		$("#product_list2").html(str);
	});
}
function show_customer(){
					var customer=$("#customergroup").val();
					
					$.ajax({
						type: "GET",
						url: "get_customer_fromgroup.php",
						data: {id:customer}
					})
					.done(function( msg ){
						$("#customerids").html(msg);
					});
					
				}
function supplier_name_checked(id)
{
	var index = global_setting_checked.indexOf(id);
	var value=$("#"+id).val();
					
	if(index==-1){
		var ide = 
		{
			key:id
		}
		global_setting_checked.push(id);
	}
	else
	{							
		global_setting_checked.splice(index,1);
	}
	console.log(global_setting_checked);
}
function supplier_setng(i){
	setng_supplier = ""
	var str = ""
	for(k=0;k<sup_obj.length;k++){
			var pid = parseInt(sup_obj[k].supplierid);
			var idx = final_list[i].prem.indexOf(pid);
			var prvid=i+"prem"+sup_obj[k].supplierid;
			if(idx!=-1)
			{
				str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' checked onclick='presup("+i+","+sup_obj[k].supplierid+")' /></div><div class='ss-supplier-label'>"+sup_obj[k].businessname+"</div><div class='ss-supplier-percentage' ><input type='number' value='"+final_list[i].premv[idx]+"' onkeyup=set_premv('"+prvid+"') id='"+i+"prem"+sup_obj[k].supplierid+"' /> %</div></div>";

			}else{
				str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' onclick='presup("+i+","+sup_obj[k].supplierid+")' /></div><div class='ss-supplier-label'>"+sup_obj[k].businessname+"</div><div class='ss-supplier-percentage' ><input type='number' id='"+i+"prem"+sup_obj[k].supplierid+"' value='0' onkeyup=set_premv('"+prvid+"') id='"+i+"prem"+sup_obj[k].supplierid+"' /> %</div></div>";
			}
		}
		$("#sup_list_view").html(str);		
		$('.overlay').fadeIn(100); 
		$('#setng_supplier').fadeIn(100); 	
}
function sup_setng_confim(){
		navigator.notification.confirm(
			'This will effect the supplier setting for individual product. Are you sure you want to change this?',  // message
			sup_global_setng,              // callback to invoke with index of button pressed
			'DBA',            // title
			'No, Yes'          // buttonLabels
		);
	}

function sup_global_setng(button)
{
	if(button==2)
		{
		setng_supplier = ""
		var str = "";	
		for(k=0;k<sup_obj.length;k++)
		{
			var pid = parseInt(sup_obj[k].supplierid);
			var idx = global_suplier.indexOf(pid);
			alert(global_suplier);
			var prvid=i+"prem"+sup_obj[k].supplierid;
			if(idx!=-1)
			{
				str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' checked onclick='presup1("+sup_obj[k].supplierid+")' id='checkbox_"+sup_obj[k].supplierid+"' /></div><div class='ss-supplier-label'>"+sup_obj[k].businessname+"</div><div class='ss-supplier-percentage' ><input type='number' value='"+global_premium[k]+"' id='gprem"+sup_obj[k].supplierid+"' onkeyup='presup2("+k+","+sup_obj[k].supplierid+")' /> %</div></div>";
			}
			else
			{
				str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' onclick='presup1("+sup_obj[k].supplierid+")' id='checkbox_"+sup_obj[k].supplierid+"' /></div><div class='ss-supplier-label'>"+sup_obj[k].businessname+"</div><div class='ss-supplier-percentage' ><input type='number' id='gprem"+sup_obj[k].supplierid+"' value='0' onkeyup='presup2("+k+","+sup_obj[k].supplierid+")' /> %</div></div>";
			}
			
		}
		$("#sup_list_view_global").html(str);
		//get_pricing();
		for(k=0;k<sup_obj.length;k++)
		{
			if($('#checkbox_'+sup_obj[k].supplierid).prop('checked'))
			{
				var sup_id_newvar=sup_obj[k].supplierid;
				presup2(k,sup_id_newvar);
			}
		}
		
		$('.overlay').fadeIn(100); 
		$('#setng_supplier_global').fadeIn(100);
		//glob_supplier_update2();
	}
}
function glob_supplier_update1()
{
	for(k=0;k<sup_obj.length;k++)
	{
		var sup_id_newvar=sup_obj[k].supplierid;
		presup2(k,sup_id_newvar);
	}
	product_list();
}

function get_profile_list(){
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"get_profile_list.php",
		data: {customer:customerid}
	})
	.done(function(msg){
		//alert(msg);
		end_loading();
		var str = "";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			if(row.active==1){
				str = str+"<li onclick=product_edit('"+row.id+"')>"+row.name+"</li>";
				if(row.defaultp==1){
					product_edit(row.id);
				}
			}
		}
		$("#profile_list").html(str);
		$("#lis_div").html('');
		$("#footer_down").html('');
	});
}

function regis_cust(id){
	$("#login_div").hide();
	$("#"+id).show();
	backArr.push("login_div");
	TBH = id;
	var s = '';
					s=s+"<input value='All' type='checkbox' id='all_chk' onclick='check_all_days()'>All";
					var days = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];
					for (var i = 0; i < 7; i++) 
					{
						if(i==6 || i==0)
						{
							s=s+"<input name='dopr[]' value='"+days[i]+"' type='checkbox' class='chk_box_all'>"+days[i];								
						}
						else
						{
							s=s+"<input name='dopr[]' value='"+days[i]+"' type='checkbox' class='chk_box_all' checked>"+days[i];		
						}
					}
					$("#daysofoperation").html(s);
					$("#all")[0].reset();	
}
//Jatin
function fill_address(){
var ad1 = $("#bill_ad1").val();
var ad2 = $("#bill_ad2").val();
var city = $("#bill_city").val();
var state = $("#bill_state").val();
var country = $("#bill_country").val();
var zip = $("#bill_zip").val();
var phone = $("#bill_phone").val();
var fax = $("#bill_fax").val();
var cell = $("#bill_cellphone").val();
var email = $("#bill_email").val();

if(!smad){
	$("#ship_ad1").val(ad1);
	$("#ship_ad2").val(ad2);
	$("#ship_city").val(city);
	$("#ship_state").val(state);
	$("#ship_zip").val(zip);
	$("#ship_country").val(country);
	$("#ship_phone").val(phone);
	$("#ship_cellphone").val(cell);
	$("#ship_fax").val(fax);	
	$("#ship_email").val(email);
	smad = true;
}else{
	$("#ship_ad1").val('');
	$("#ship_ad2").val('');
	$("#ship_city").val('');
	$("#ship_state").val('');
	$("#ship_zip").val('');
	$("#ship_country").val('');
	$("#ship_phone").val('');
	$("#ship_cellphone").val('');
	$("#shiptofax").val('');
	$("#ship_email").val('');
	smad = false;
}
}
function zipcode(id)
{
	var zip_code=$("#"+id).val();
		$.ajax({
				type: "GET",
				url: base_url2+"getinfo.php",
				data: {zip:zip_code}
			})
			.done(function( msg )
			{
				if((msg!=0)||(msg!=2))
				{
					var obj = JSON.parse(msg);
					if(id=="bill_zip")
					{
						$("#bill_city").val(obj[1]);
						$("#bill_state").val(obj[2]);
					}else{
							$("#ship_city").val(obj[1]);
							$("#ship_state").val(obj[2]);
						}
						
					}
				});
}
function net_cmsn(){
	var t = parseInt($("#totalcmsn").val());
	var a = parseInt($("#agentcmsn").val());
	var r = parseInt($("#repcmsn").val());
	var s = parseInt($("#seccmsn").val());
	var o = parseInt($("#othercmsn").val());
	var n = parseInt($("#netcmsn").val());
	//alert(t+"--"+a+"---"+r+"---"+s+"---"+o)
	var k = a+r+s+o;
	var p = t-k;
	//alert(p);
	if(p<=0){
		alert("Net commission cannot be less zero");
	}
	else{
		$("#netcmsn").val(p);
	}
}
var specialKeys = new Array();
        specialKeys.push(8); //Backspace
		  function IsNumeric(e,id) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById(id).style.display = ret ? "none" : "inline";
            return ret;
        }
	function usr_pop()
					{
						var x = document.getElementById("eml").value;
						var atpos = x.indexOf("@");
						var dotpos = x.lastIndexOf(".");
						if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) 
						{
							$("#eml").focus();
							$("#eml").css('border','1px solid red');
							
							return false;
						}
						else
						{
							$("#eml").css('border','none');
							$("#partner_user_id").val($("#eml").val());
							search_uniq();
						}
					}
function search_uniq(){
		var str = $("#partner_user_id").val();
		//alert(str);
		$.ajax({
			type: "GET",
			url: base_url2+"search_partner.php",
			data: {term:str}
			}).done(function( msg )
			{//alert(msg);
				if(msg==1){
				$("#alreaytag").show();
				//document.getElementById("alsubmt").disabled = true;
				}else{
						$("#alreaytag").hide();
						//document.getElementById("alsubmt").disabled = false;
					}
			});
	}
									

