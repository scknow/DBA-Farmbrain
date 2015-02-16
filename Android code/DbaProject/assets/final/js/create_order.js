var shortName = "fb";
var maxSize = 1024*1024*20;
var version = '1.0';
var displayName = "fb";
var db;
var customerid = "";
var userid = "";
var toggle=0;
var base_url = "http://104.131.176.201/webservices/";
//var base_url="http://antloc.com/dba/webservices/";
var base_url2 = "http://104.131.176.201/admin/";
//var base_url2 = "http://antloc.com/dba/admin/";
var TBH = "dashboard_div";
var backArr = new Array();
var sta_loading = false;
var smad = false;
var toggle_value=0;
var name_customer='';
document.addEventListener("deviceready", onDeviceReady, false);
var open_table_array=[];
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
		//init_add_product();
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
	
	var windowWidth = $(window).width();
    var windowHeight = $(window).height();
	$("#chart_div").width(windowWidth).height(windowHeight-150);
	$("#series_chart_div").width(windowWidth).height(windowHeight-150);
	$("#piechart").width(windowWidth).height(windowHeight-windowHeight/2-90);	
	$("#piechart2").width(windowWidth).height(windowHeight-(windowHeight/3+160)+30);
	
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
			name_customer=msg[2];
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
	
	if(TBH=="create_profile_div" || TBH=="next_profile_div" ){
		navigator.notification.confirm(
			'The changes made to the profile will not be saved if you navigate away from this page. Continue?',  // message
			onmenu_item,   // callback to invoke with index of button pressed
			'DBA',            // title
			'No, Yes'          // buttonLabels
		);
	}else
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

function onmenu_item(button){
	if(button==2){
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
		.done(function(msg)
{
			
			alert("Thanks for registering on the DBA app. We will revert as soon as possible with the next steps.");
			onBackKeyDown();
		});

}

var product_index = new Array();
var obj = null;
var price_obj = null;
var price_index = new Array();
var price_values = new Array()
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
/* KC change
function add_product(pid)
{
	//find the index of the product which is just added 
	var index = product_index.indexOf(pid);
	//alert(index);
	if(index==-1)
	{
		//didnt find the product in the list
		product_index.push(pid);
		var subsi = new Array();
		var premi = new Array();
		var premiv = new Array();
		if(global_suplier.length!=0)
		{
			var global_suplier1=new Array;
			var global_premium1=new Array;
			
			for(var kk=0;kk<global_suplier.length;kk++)
			{
				global_premium1.push(global_premium[kk]);
				global_suplier1.push(global_suplier[kk]);
				
			}
			
			
			var pack = {
				id : pid,
				subs: subsi,
				prem:global_suplier1,
				premv:global_premium1,
				qty: 0,
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
			get_pricing_test(pid);
			
		}else{
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
}*/ //KC change

function product_list()
{
	supplier_order = [];
	var str = "";
	var footer_str = ""
	var count_sup = 0;
	var mov_total = new Array();
	var tbh_color_change = new Array();
	for(i=0;i<product_index.length;i++)
	{
		var id = product_index[i];
		var index = p_index.indexOf(id);		
		if(index!=-1){
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
			if(so_indx==-1){
			//alert(supplier_order.length);
			count_sup++
				var sum_mov = parseFloat(final_list[i].qty) * parseFloat(price_values[price_idx].id[0]);
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
				var sum_mov = parseFloat(final_list[i].qty) * parseFloat(price_values[price_idx].id[0]);
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
			
			str = str+"<center onclick='rec_show("+i+")'>"+sup_obj[supindxof].businessname+"</center><img class='drop1' src='images/drop.png' onclick='rec_show("+i+")' /><div class='open-info-main1' id='recid"+i+"' >";
			
			for(rec = 0;rec<price_values[price_idx].price.length;rec++){
				var supindxof1 = s_index.indexOf(price_values[price_idx].id[rec]);
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
				if(parseFloat(final_list[i].price)>parseFloat(dp[0])){
					str = str+"<i onclick='tooltip_show("+i+",2)' style='color:green;' >!</i>";
				}else if(parseFloat(final_list[i].price)<parseFloat(dp[0])){
					str = str+"<i onclick='tooltip_show("+i+",2)' style='color:red;' >!</i>";
				}
			}
			str = str + "<span onclick='pro_qty_up("+i+","+price_values[price_idx].moq[0]+")' >+</span><input ";
			if(parseFloat(price_values[price_idx].moq[0])>parseFloat(final_list[i].qty)){
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
	}
	else
	{
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
function load_list(){}
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
		if(parseFloat(final_list[id].price)>parseFloat(dp[0])){
			pfal = "decreasing";
		}else if(parseFloat(final_list[id].price)<parseFloat(dp[0])){
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
	var miq = parseFloat(final_list[i].moq);
	var qiq = parseFloat(final_list[i].qty);
	
	if(qiq=='NAN' || qiq==0)
	{
		if(jk==0)
		{
			alert('Items with 0 quantity will be dropped from the order.');
			jk++;
		}
	}
	else
	{
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
			if(k!=0)
			{
				var message = "Incremental order quantity for '"+obj[p_index.indexOf(final_list[i].id)].productlabel+ "' not matched";
				ghi=false;
				alert(message);
				onBackKeyDown();
				break;
			}
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
					if(final_list[i].invoice!=0 && parseFloat(final_list[i].qty) >= parseFloat(final_list[i].minqty)){
						//alert(prigh);
						if(final_list[i].peroff!=0){
							disco = (prigh * parseFloat(final_list[i].peroff))/100;
							prigh = prigh - (prigh * parseFloat(final_list[i].peroff))/100;
							//alert(prigh);
						}else if(final_list[i].valoff!=0){
							disco =  parseFloat(final_list[i].valoff);
							prigh = prigh - parseFloat(final_list[i].valoff);
						}
					}
					//This is for fetching saving of the order
					var save_v = 0;
					var savinx = price_index.indexOf(final_list[i].id);
					if(savinx!=-1){
						var m = 1;
						for(m=1;m<price_values[savinx].price.length;m++){
							save_v = save_v + parseFloat(price_values[savinx].price[m]);
						}
						save_v = parseFloat(save_v/m)*parseFloat(final_list[i].qty);
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
					if(final_list[i].invoice!=0 && parseFloat(final_list[i].qty) >= parseFloat(final_list[i].minqty)){
						if(final_list[i].peroff!=0){
							disco = (prigh * parseFloat(final_list[i].peroff))/100;
							prigh = prigh - (prigh * parseFloat(final_list[i].peroff))/100;
						}else if(final_list[i].valoff!=0){
							disco =  parseFloat(final_list[i].valoff);
							prigh = prigh - parseFloat(final_list[i].valoff);
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
							save_v = save_v + parseFloat(price_values[savinx].price[m]);
						}
						save_v = parseFloat(save_v/m)*parseFloat(final_list[i].qty);
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
				str = str+"<label onclick='table_show("+i+")'>"+sup_obj[index].businessname+"</label><p class='price' onclick='table_show("+i+")' >$"+sc_obj[sc_idx].minimumordervalue+"</p><big id='total_sup_value"+i+"'>$"+all_data_order[i].price+"</big><i style='margin: 9px 10px;' id='dayd"+i+"'>"+days_ary[mday]+"</i><input class='date_pic' type='date' id='rdlt"+i+"' style='padding: 4px 0px;float: left;width: 20%;border: 1px solid silver;' onchange='date_change("+i+")' value='"+time+"' /><span><img src='images/select.png' onclick='send_order_single("+i+")' /></span></li><table class='dba-profile' id='tableor"+i+"' style='display:none' >";
				//alert(all_data_order[i].pid.length);
				for(q=0;q<all_data_order[i].pid.length;q++){
					var id = all_data_order[i].pid[q];
					var indo = p_index.indexOf(id);
					//alert(indo);
					var detail = obj[indo];
					
					str = str + "<tr id='all_product_tr"+i+""+q+"'><td class='one' ><p>"+detail.productlabel+"<b>"+detail.packquantity+detail.unitofmeasure+"</b></p><div class='drop-1'><div class='open-info-main1'></div></b></div></td><td class='large-width'><span onclick='all_qty_up("+mov+","+i+","+q+")'>+</span><input onblur='all_qty_change("+mov+","+i+","+q+")' id='all_qty"+i+""+q+"' type='number' onkeyup='all_qty_change("+mov+","+i+","+q+")' value='"+all_data_order[i].qty[q]+"' onClick='this.select();'/><span onclick='all_qty_down("+mov+","+i+","+q+")' >-</span></td><td class='small-width'><u><img src='images/delete.png' onclick='all_delt_pro("+i+","+q+")' /></u></td></tr>";
					
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
				str = str+"<label style='border-left: 3px solid rgb(206, 0, 0);' onclick='table_show("+i+")'>"+sup_obj[index].businessname+"</label><p class='price' onclick='table_show("+i+")' >$"+sc_obj[sc_idx].minimumordervalue+"</p><big id='total_sup_value"+i+"'>$"+parseFloat(all_data_order[i].price).toFixed(2)+"</big><i style='margin: 9px 10px;' id='dayd"+i+"'>"+days_ary[mday]+"</i><input class='date_pic' style='padding: 4px 0px;float: left;width: 20%;border: 1px solid silver;' type='date' id='rdlt"+i+"' onchange='date_change("+i+")' value='"+time+"' /><span><img src='images/select.png' onclick='send_order_single("+i+")' /></span></li><table class='dba-profile' id='tableor"+i+"' style='display:none' >";
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
	var decrmnt = parseFloat(all_data_order[i].price) + parseFloat(price);
	all_data_order[i].price = decrmnt;
	decrmnt = "$"+decrmnt;
	$("#total_sup_value"+i).html(decrmnt);
	//all_data_order[i].price = decrmnt;
}

function all_qty_down(mov,i,q){
	var price = all_data_order[i].pris[q];
	var qty = all_data_order[i].qty[q];
	if(qty>0){
	var decrmnt = parseFloat(all_data_order[i].price) - parseFloat(price);
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
	var k = (parseFloat(all_data_order[i].qty[q])*parseFloat(price)) - (parseFloat(qty)*parseFloat(price));
	var decrmnt = parseFloat(all_data_order[i].price) - k;
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
	var a = open_table_array.indexOf(id);
	if(a==-1){open_table_array[id]=id;}
	else{open_table_array.splice(a,1);}
	
}

function table_show_test(id){
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
			//alert(final_list[pidxof]);
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
				//final_list[pidxof].prem.push(parseFloat(row.supplierid));
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
			}else{
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
				
			}
		}
	
		//This is for checking the checkbox of selected products
		checked_product_list();
		//This is for making all product screen
		product_list();
	});

}

function get_pricing_test(pid_new)
{
	start_loading();
	
	$.ajax({
		type: "GET",
		url: base_url+"recommend.php",
		data: {customer:customerid, pid:product_index}
	})
	.done(function( msg )
	{
		end_loading();
		
		price_obj = JSON.parse(msg);
		
		for(i=0;i<price_obj.length;i++)
		{
			var row = price_obj[i];
			
			if(row.productid==pid_new)
			{
				var glob_sup_id=-1;
				for(var l=0;l<global_suplier.length;l++)
				{
					
					if(global_suplier[l]==row.supplierid)
					{
						var indx = price_index.indexOf(row.productid);
						var pidxof = product_index.indexOf(row.productid);
						glob_sup_id=l;
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
							//final_list[pidxof].prem.push(parseFloat(row.supplierid));
							//final_list[pidxof].premv.push(0);
							
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
							//final_list[pidxof].prem.push(parseFloat(row.supplierid));
							//final_list[pidxof].premv.push(0);
						}
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
					
				}
				if(glob_sup_id==-1)
				{
					
					var indx = removed_product_index.indexOf(row.productid);
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
					if(indx==-1)
					{
						var sidg = new Array();
						var padt = new Array();
						padt.push(price_data);
						sidg.push(row.supplierid);
						var da = {
								pid : row.productid,
								sid : sidg,
								pda : padt
							}
							removed_supplier_index.push(da);
							removed_product_index.push(row.productid);
					}
					else
					{
						removed_supplier_index[indx].sid.push(row.supplierid);
						removed_supplier_index[indx].pda.push(price_data);
					}
				}
			}				
		}
		
		//var jsn = JSON.stringify(price_values);
		//alert(jsn);
		//This is for checking the checkbox of selected products
		checked_product_list();
		//This is for making all product screen
		product_list();
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
function checked_product_list()
{
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
		//get_profile_list();
		
	});
	$.ajax({
		type: "GET",
		url: base_url+"get_supplier.php",
		data: {customer_id:customerid}
	})
	.done(function( msg ){
		//alert(msg);
		sup_obj = JSON.parse(msg);
		global_suplier = [];
		global_premium = [];
		for(i=0;i<sup_obj.length;i++){
			var row = sup_obj[i];
			s_index.push(row.supplierid);
			global_suplier.push(parseFloat(row.supplierid));
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
		dash_bord_report(1);
	});
	
	$.ajax({
		type: "POST",
		url: base_url+"get_notification.php",
		data: {customer:customerid,last:'-1'}
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
		
		$("#dash_max_supplier").html("$"+tocurrency_int(msg.max_supplier));
		$("#dash_save").html("$"+tocurrency_int(msg.t_saving));
		$("#dash_total_spend").html("$"+tocurrency_int(msg.total_spend));
		$("#dash_max_pro_spend").html("$"+tocurrency_int(msg.max_pro_spend));
		if(obj!=null){
			var index = p_index.indexOf(msg.max_pro_id);
			if(index!=-1){
			$("#dash_max_pro_id").html("Max. Spend with Product ? "+obj[index].productlabel);
			}
		}
		if(sup_obj!=null){
			var index = s_index.indexOf(msg.max_supplierid);
			if(index!=-1){
			$("#dash_max_supplierid").html("Max. Spend with Supplier ? "+sup_obj[index].businessname);
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
				if(rvix!=-1)
				{
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
				//TBD create removesupplierindex 
				
			}
			else
			{
				var rvix = removed_supplier_index[indx].sid.indexOf(id);
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
	else
	{
		
		final_list[index].prem.splice(idx,1);
		final_list[index].premv.splice(idx,1);
		var indx = price_index.indexOf(final_list[index].id);
		if(indx!=-1)
		{
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
				if(rindx==-1)
				{
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
				}
				else
				{
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
				//To be checked later
				
				if(price_values[indx].id.length==0)
				{
					price_values.splice(indx,1);
					price_index.splice(indx,1);
				}
			}
		}		
	}
	
	var jsn = JSON.stringify(final_list);
	$("#pro_data").val(jsn);
}

function presup_for_add_new(index,id)
{	
	var indx = price_index.indexOf(final_list[index].id);
	if(indx!=-1)
	{
		var kid = ""+id;
		var kxd = price_values[indx].id.indexOf(kid);
		if(kxd!=-1)
		{
			var price_data = 
			{
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
			if(rindx==-1)
			{
				
				var sidg = new Array();
				var padt = new Array();
				padt.push(price_data);
				sidg.push(id);
				var da = 
				{
					pid : final_list[index].id,
					sid : sidg,
					pda : padt
				}
				
				removed_supplier_index.push(da);
				removed_product_index.push(final_list[index].id);
				console.log("removed_product_index in if condition--------"+removed_product_index);
				len=removed_supplier_index.length-1;
				console.log("removed_supplier_index in if condition--------"+removed_supplier_index[len].pid+"******"+removed_supplier_index[len].sid+"!!!!!"+removed_supplier_index[len].pda);
			}
			else
			{
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
			
			if(price_values[indx].id.length==0)
			{
				price_values.splice(indx,1);
				price_index.splice(indx,1);
			}
		}		
	}
}
function presup_glob_select(sid)
{
	for(var i=0;i<final_list.length;i++)
		{	
			//insert new global values into an array 
			var global_suplier1=new Array();
			var global_premium1=new Array();
			
			for(var kk=0;kk<global_suplier.length;kk++)
			{
				global_premium1.push(global_premium[kk]);
				global_suplier1.push(global_suplier[kk]);				
			}
			final_list[i].prem=global_suplier1;
			final_list[i].premv=global_premium1;		
			//see if this is from a product which had some suppliers removed 	
			var indx = removed_product_index.indexOf(final_list[i].id);	
			
			var id_glob="glob_"+sid;			
			//if this supplier is now selected 
			if($("#"+id_glob).prop("checked") == true)
			{
				//see if this suppliers price was already being considered
				var rvix = removed_supplier_index[indx].sid.indexOf(sid);
				//alert(removed_supplier_index[indx].sid+"&&&&&"+sid);
				for(var ik=0;ik<removed_supplier_index[indx].sid.length;ik++)
				{
					if(removed_supplier_index[indx].sid[ik]==sid)
					{
						rvix=ik;
					}
				}
				
				if(rvix!=-1)
				{
					//alert(removed_supplier_index[indx].pda[rvix].id);
					var prinx = price_index.indexOf(final_list[i].id);
					
					if(prinx==-1)
					{
						//alert("price index had been spliced");
						price_index.push(final_list[i].id);
						prinx = price_index.indexOf(final_list[i].id);						
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
					removed_supplier_index[indx].sid.splice(rvix,1);
					removed_supplier_index[indx].pda.splice(rvix,1);
					
					//KC}
				}
				/* else
				//no wasnt being considered 
				{
					if(indx!=-1)
					{
						var rvix = removed_supplier_index[indx].sid.indexOf(sid);			
						if(rvix!=-1)
						{
							price_index.push(final_list[i].id);
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
							//TBD - recalculate recommended supplier 
						}
					}
				}
				 */
			}
			else
			//if supplier is now unselected
			{
				//see if this supplier was being considered
			
			var indx = price_index.indexOf(final_list[i].id);
			//alert("in else-------"+indx);
			if(indx!=-1)
			{			
				var kid = ""+sid;
				var kxd = price_values[indx].id.indexOf(kid);
				//alert("In unchecked kxd"+kxd)					
				if(kxd!=-1)
				{
					alert("In unchecked"+kxd)
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
					var rindx = removed_product_index.indexOf(final_list[i].id);
					//alert("In unchecked rindx"+rindx);
					if(rindx==-1)
					{
						var sidg = new Array();
						var padt = new Array();
						padt.push(price_data);
						sidg.push(sid);
						var da = {
							pid : final_list[i].id,
							sid : sidg,
							pda : padt
						}
						removed_supplier_index.push(da);
						removed_product_index.push(final_list[i].id);
					}
					else
					{
						removed_supplier_index[rindx].sid.push(sid);
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
					
					//To be checked later
				if(price_values[indx].id.length==0)
					{
						price_values.splice(indx,1);
						price_index.splice(indx,1);
					} 
					
					//TBD - Recalculate recommended supplier
				
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
	//find the supplier id 
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
	//repeat the change for all products 	
	for(var i=0;i<final_list.length;i++)
		{	
			//insert new global values into an array 
			var global_suplier1=new Array();
			var global_premium1=new Array();
			
			for(var kk=0;kk<global_suplier.length;kk++)
			{
				global_premium1.push(global_premium[kk]);
				global_suplier1.push(global_suplier[kk]);				
			}
			final_list[i].prem=global_suplier1;
			final_list[i].premv=global_premium1;		
			//see if this is from a product which had some suppliers removed 	
			var indx = removed_product_index.indexOf(final_list[i].id);	
			
			var id_glob="glob_"+sid;			
			//if this supplier is now selected 
			if($("#"+id_glob).prop("checked") == true)
			{
				//see if this suppliers price was already being considered
				var rvix = removed_supplier_index[indx].sid.indexOf(sid);				
				if(rvix!=-1)
				{
					//alert(removed_supplier_index[indx].pda[rvix].id);
					var prinx = price_index.indexOf(final_list[i].id);
					if(prinx==-1)
					{
						price_index.push(final_list[i].id);
						prinx = price_index.indexOf(final_list[i].id);						
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
					removed_supplier_index[indx].sid.splice(rvix,1);
					removed_supplier_index[indx].pda.splice(rvix,1);
					/* if(removed_supplier_index[indx].sid.length==0)
					{
						
						removed_product_index[indx].splice(rvix,1);
					} */
					//KC}
				}
				/* else
				//no wasnt being considered 
				{
					if(indx!=-1)
					{
						var rvix = removed_supplier_index[indx].sid.indexOf(sid);			
						if(rvix!=-1)
						{
							price_index.push(final_list[i].id);
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
							//TBD - recalculate recommended supplier 
						}
					}
				}
				 */
			}
			else
			//if supplier is now unselected
			{
				//see if this supplier was being considered
			
			var indx = price_index.indexOf(final_list[i].id);
			if(indx!=-1)
			{			
				var kid = ""+sid;
				var kxd = price_values[indx].id.indexOf(kid);
				//alert("In unchecked kxd"+kxd)					
				if(kxd!=-1)
				{
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
					var rindx = removed_product_index.indexOf(final_list[i].id);
					//alert("In unchecked rindx"+rindx);
					if(rindx==-1)
					{
						var sidg = new Array();
						var padt = new Array();
						padt.push(price_data);
						sidg.push(sid);
						var da = {
							pid : final_list[i].id,
							sid : sidg,
							pda : padt
						}
						removed_supplier_index.push(da);
						removed_product_index.push(final_list[i].id);
					}
					else
					{
						removed_supplier_index[rindx].sid.push(sid);
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
					
					//To be checked later
				if(price_values[indx].id.length==0)
					{
						price_values.splice(indx,1);
						price_index.splice(indx,1);
					} 
					
					//TBD - Recalculate recommended supplier
				
				}					
				}
		}		
			
	}	
		var jsn = JSON.stringify(final_list);
		//alert(jsn);
		$("#pro_data").val(jsn);
}

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
		var ipo = parseFloat(final_list[index].qty) - parseFloat(final_list[index].moq);
		var kpo = ipo%parseFloat(final_list[index].ioq);
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
			var hjkf = parseFloat(final_list[m].qty);
			var sdjn = parseFloat(final_list[m].price);
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
		var ipo = parseFloat(final_list[index].qty) - parseFloat(final_list[index].moq);
		var kpo = ipo%parseFloat(final_list[index].ioq);
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
			var hjkf = parseFloat(final_list[m].qty);
			var sdjn = parseFloat(final_list[m].price);
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
		var ipo = parseFloat(final_list[index].qty) - parseFloat(final_list[index].moq);
		var kpo = ipo%parseFloat(final_list[index].ioq);
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
			var hjkf = parseFloat(final_list[m].qty);
			var sdjn = parseFloat(final_list[m].price);
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
	var i = parseFloat(p[1]);
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
			var p = parseFloat(price_values[idx].price[k]);
			var v = parseFloat(final_list[index].premv[k]);
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
				var inkx = global_suplier.indexOf(parseFloat(prems[j]));
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
			var pid = parseFloat(sup_obj[k].supplierid);
			var idx = final_list[i].prem.indexOf(pid);
			var prvid=i+"prem"+sup_obj[k].supplierid;
			if(idx!=-1)
			{
				str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' checked onclick='presup("+i+","+sup_obj[k].supplierid+")' /></div><div class='ss-supplier-label'>"+sup_obj[k].businessname+"</div><div class='ss-supplier-percentage' ><input type='number' value='"+final_list[i].premv[idx]+"' onClick='this.select();' onkeyup=set_premv('"+prvid+"') id='"+i+"prem"+sup_obj[k].supplierid+"' /> %</div></div>";

			}else{
				str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' onclick='presup("+i+","+sup_obj[k].supplierid+")' /></div><div class='ss-supplier-label'>"+sup_obj[k].businessname+"</div><div class='ss-supplier-percentage' ><input type='number' id='"+i+"prem"+sup_obj[k].supplierid+"' value='0' onClick='this.select();' onkeyup=set_premv('"+prvid+"') id='"+i+"prem"+sup_obj[k].supplierid+"' /> %</div></div>";
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

function sup_global_setng(button){
if(button==2)
{
	setng_supplier = ""
	var str = ""
	
	for(k=0;k<sup_obj.length;k++){
		var pid = parseFloat(sup_obj[k].supplierid);
		var idx = global_suplier.indexOf(pid);
		var prvid=i+"prem"+sup_obj[k].supplierid;
		if(idx!=-1)
		{
			str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' id='glob_"+sup_obj[k].supplierid+"' checked onclick='presup1("+sup_obj[k].supplierid+")' /></div><div class='ss-supplier-label'>"+sup_obj[k].businessname+"</div><div class='ss-supplier-percentage' ><input type='number' value='"+global_premium[k]+"' id='gprem"+sup_obj[k].supplierid+"' onClick='this.select();' onkeyup='presup2("+k+","+sup_obj[k].supplierid+")' /> %</div></div>";

		}else{
			str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' id='glob_"+sup_obj[k].supplierid+"' onclick='presup1("+sup_obj[k].supplierid+")' /></div><div class='ss-supplier-label'>"+sup_obj[k].businessname+"</div><div class='ss-supplier-percentage' ><input type='number' id='gprem"+sup_obj[k].supplierid+"' onClick='this.select();' value='0' onkeyup='presup2("+k+","+sup_obj[k].supplierid+")' /> %</div></div>";
		}
	}
		$("#sup_list_view_global").html(str);		
		$('.overlay').fadeIn(100); 
		$('#setng_supplier_global').fadeIn(100);
	
		for(k=0;k<sup_obj.length;k++)
		{	
			var sid=sup_obj[k].supplierid;
			presup_glob_select(sid);		
			/* //presup(k,sid); */
			
		}
	}
}
function glob_supplier_update1()
{
	product_list();
}
function presup2(k,sid)
{
	var index = global_suplier.indexOf(sid);
	global_premium[index] = $("#gprem"+sid).val();
	test_presup(sid);
}

function test_presup(sid)
{
	for(var i=0;i<final_list.length;i++)
		{
			var global_suplier1=new Array;
			var global_premium1=new Array;
			
			for(var kk=0;kk<global_suplier.length;kk++)
			{
				global_premium1.push(global_premium[kk]);
				global_suplier1.push(global_suplier[kk]);
				
			}
			final_list[i].prem=global_suplier1;
			final_list[i].premv=global_premium1;
		}
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
	var t = parseFloat($("#totalcmsn").val());
	var a = parseFloat($("#agentcmsn").val());
	var r = parseFloat($("#repcmsn").val());
	var s = parseFloat($("#seccmsn").val());
	var o = parseFloat($("#othercmsn").val());
	var n = parseFloat($("#netcmsn").val());
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
									
/*********************New create order code*************************/
//Create Order screen DS
var products_list = new Array(); //Stores all products data indexed by product_id
/*
products_list[product_id]
	.product_data
		.title
		.description 
		.image 
		.weight
		.pack_quantity
		.case_quantity
		.unitofmeasure
	.pricing_list[supplier_id]
		.supplierid
		.price
		.ioq
		.moq
		.rebate
		.valueinvoice
		.percentinvoice
		.minimum_quantity 
		.priceincrease = true/false
		.last_order_date
		.last_order_quantity
*/
var order_list = new Array(); //Stores present order list indexed by product_id
/*
order_list[product_id]
	.product_data
		.title
		.description 
		.image 
		.weight
		.pack_quantity
		.case_quantity
		.unitofmeasure
	.pricing_list[supplier_id]
		.supplierid
		.price
		.ioq
		.moq
		.rebate
		.valueinvoice 
		.percentinvoice 
		.minimum_quantity 
		.priceincrease = true/false
		.last_order_date
		.last_order_quantity
	.moqioqflag = true/false
	.substitutes[product_id]
	.supplier_settings[supplier_id]
		.premium
		.name 
	.selected_supplier = -1/supplier_id
	.selectedprice
	.available_suppliers[supplierid]
	.quantity
*/
var global_supplier_settings = new Array(); //Stores global supplier settings indexed by supplier_id
/*
global_supplier_settings[supplier_id]
	.premium
	.name
*/
var suppliers_list = new Array(); //Stores all suppliers and their mov values indexed by supplier_id
/*
suppliers_list[supplier_id]
	.name
	.mov
	.tolerance
*/
var selected_suppliers_list = new Array(); //Store the selected suppliers and their total order values by supplier_id
/*
selected_suppliers_list[supplier_id]
	.totalvalue
	.color
*/


//Order review screen DS
var supplier_orders_list = new Array();  //Stores all finalized orders indexed by supplier_id
/*
supplier_orders_list[supplier_id]
	.products_list[product_id]
		.product_data 
			.title
			.description 
			.image
			.price
			.quantity
			.rebate
			.offinvoice
			.moqioqflag = false/true
	.totalvalue
	.color 0 - RED, 1 - YELLOW, 2 - GREEN
	.requested_delivery_date
	.ordered - false/true

*/
var default_order_profile_id='';
var order_profiles_list = new Array();

/*
order_profiles_list[profile_id]
	.name
	.default
	.profile_id 
	.type global/personal
	.products_list[product_id]
		.quantity
		.supplier_settings[supplier_id]
			.premium
			.name 
*/
//Creates an onscreen notification 					

// for login customer
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

var fetch_counter=0;

//Init of create order - on launch 
function init_create_order()
{
	fetch_counter=0;
	start_loading();
	//Fetch product data and pricing data from server 
	fetch_product_data();
	//Fetch the suppliers list from server 
	fetch_suppliers_list();	
	//Get the order profiles and load them too
	fetch_order_profiles_list();	
	//fetch product cat/subcategory
	fetch_categories();
	
}

// After all data from init_create_order this function has to call
function check_counter()
{
//	console.log(fetch_counter)
	if(fetch_counter==4)
	{
		//Initialize the add product modal window
		init_add_product();
		//Set zero values into global supplier settings
		init_global_supplier_settings();
		//Draw everything 
		redraw_order_list();
		// To be checked
		init_product_filter();
		
		
		/* $.each(order_profiles_list, function(profile_id, profile_details)
		{
				//TBD if (profile_details.defaults=="1")
					//default_order_profile_id = profile_id;
					default_order_profile_id=2;
			}); */
		
		var profile_str='';
			$.each(order_profiles_list, function (key, value)
			{	
				if(typeof(value!='undefined'))
				{
					if(value.defaults==1)
					{
						
						default_order_profile_id=key;
					}
					profile_str=profile_str+"<li onclick=load_order_profile("+key+")>"+order_profiles_list[key].name+"</li>";				
				}				
			});
		//alert(default_order_profile_id);
		load_order_profile(default_order_profile_id);
		$("#profile_list").html(profile_str);
		end_loading();
	}
}

//Function to fetch product and pricing data
function fetch_product_data()
{	
	//Call server api to get all products data - TBD
	$.ajax({
		type: "GET",
		url: base_url+"get_product.php",
		data: {}
	})
	.done(function( msg )
	{	
		var obj_p = JSON.parse(msg);
		//run a loop and
		//insert into products_list array 
		/* .product_data
		.title
		.description 
		.image 
		.weight
		.pack_quantity
		.case_quantity
		.unitofmeasure
	.pricing_list[supplier_id]
		.supplierid
		.price
		.ioq
		.moq
		.rebate
		.valueinvoice - TBD
		.percentinvoice - TBD
		.minimum_quantity - TBD
		.priceincrease = true/false
		.priceincreasedate
		.priceincreasenew
		.last_order_date
		.last_order_quantity 
		.rebate_offinovice_dates
		
		
		*/
		
		for(i=0;i<obj_p.length;i++)
		{
			var row = obj_p[i];
			var img_path = "";
			if(row.picture1=='a' || row.picture1=="")img_path = "images/a.png";
			else img_path = base_url2+"upload/"+row.picture1;
		
			
			var product_data_inside = 
				{
					title : row.productlabel,
					description : row.productdescription,
					image:img_path,
					weight:row.caseweight,
					pack_quantity:row.packquantity,
					case_quantity:row.casequantity,
					unitofmeasure:row.unitofmeasure,
					category_id:row.productcategoryid,
					subcategory_id:row.productsubcategoryid
					
					
					
				};
				var pid_q=row.productid;
				var pricing_list={};
				var product_data_id=
				{
					product_data:product_data_inside,
					pricing_list:''
				};	
			
			products_list[pid_q]=product_data_id;
			//products_list.pid_q.product_data = $.extend({}, product_data_inside);
			//When using above line Uncaught TypeError: Cannot set property 'product_data' of undefined
		}
	
	
	$.ajax({
		type: "GET",
		url: base_url+"get_product_price1.php",
		data: {cutomer_id:customerid}
	})
	.done(function( msg )
	{	
		var obj_price = JSON.parse(msg);
		//run a loop and
		//insert into products_list array 
		for(i=0;i<obj_price.length;i++)
		{
			var row = obj_price[i];
			var pid_q=row.productid;
			var	price_by_supplier=row.supplierid;
			var pricings_list={};
			//Last order date
			var last_order_date_value=row.LOD;
			last_order_date_value=last_order_date_value.split("&&");
			
			var supplier_details=
			{
				price:row.price,
				ioq:row.incrementodrqty,
				moq:row.minodrqty,
				rebate:row.rebate,
				offinvoice:row.offinvoice,
				priceincrease:row.price_change_after_week,
				valueinvoice : row.valueoff,
				percentinvoice : row.precentageoff,
				minimum_quantity:row.pro_min_qty,
				last_order_date:last_order_date_value[1],
				last_order_quantity:last_order_date_value[0],
				priceincreasedate:row.price_change_date,
				priceincreasenew:row.price_change_after_week,
				rebate_offinovice_dates:row.promotion_date_from_to,
				promotion_text:row.promotion_text
			}
		
		pricings_list[price_by_supplier]=supplier_details;
		/* if(!('pricing_list' in products_list))
		{
			products_list[pid_q]['pricing_list']=pricing_list;
		}
		else
		{
			products_list[pid_q]['pricing_list'].push(pricing_list);
		} */
		if(i==0)
		{
			products_list[pid_q].pricing_list = $.extend({}, pricings_list);
		}
		else
		{
			products_list[pid_q].pricing_list = $.extend(products_list[pid_q].pricing_list, pricings_list);
		}
		
		/*products_list[pid_q]=product_data_id;			
		.pricing_list[supplier_id]
		.supplierid
		.price
		.ioq
		.moq
		.rebate
		.offinvoice 
		.priceincrease = true/false */		
		
		}
		fetch_counter++;
		check_counter();
	});
	});
}

//Function to fetch order profiles list
function fetch_order_profiles_list()
{
	/*
	order_profiles_list[profile_id]
	.name
	.default
	.profile_id 
	.type
	.products_list[product_id]
		.quantity
		.supplier_settings[supplier_id]
			.premium
			.name 
	*/
		$.ajax({
				type: "POST",
				url: base_url+"get_profile.php",
				data: {cutomer_id:customerid}
			})
			.done(function( msg )
			{
				var objt = JSON.parse(msg);				
				order_profiles_list = $.extend({},objt);				
				fetch_counter++;
				check_counter();			
			});					
}

//Function to fetch order profiles list when save as profile is done
function fetch_order_profiles_list_save_as(profile_id_to_load)
{
		/*
	order_profiles_list[profile_id]
	.name
	.default
	.profile_id 
	.type
	.products_list[product_id]
		.quantity
		.supplier_settings[supplier_id]
			.premium
			.name 
	*/
		$.ajax({
				type: "POST",
				url: base_url+"get_profile.php",
				data: {cutomer_id:customerid}
			})
			.done(function( msg )
			{
				var objt = JSON.parse(msg);
				order_profiles_list = $.extend({},objt);			
				//
				var profile_str='';
				$.each(order_profiles_list, function (key, value)
				{	
					if(typeof(value!='undefined'))
					{
						if(value.defaults==1)
						{
							//load_order_profile(key);
							default_order_profile_id=key;
						}
						profile_str=profile_str+"<li onclick=load_order_profile("+key+")>"+order_profiles_list[key].name+"</li>";				
					}				
				});
				$("#profile_list").html(profile_str);
				//alert(profile_id_to_load.trim()+"-------"+profile_id_to_load);
				profile_id_to_load=profile_id_to_load.trim();
				load_order_profile(profile_id_to_load);
				//alert(profile_id_to_load);
			});					

}


//Function to fetch suppliers list 
function fetch_suppliers_list()
{	
		$.ajax({
		type: "GET",
		url: base_url+"get_supplier.php",
		data: {customer_id:customerid}
	})
	.done(function( msg )
	{
		//alert(msg);
		var sup_objt = JSON.parse(msg);
		for(i=0;i<sup_objt.length;i++)
		{
			var row = sup_objt[i];
			//suppliers_list[row.supplierid]={};
			var supplier_data_detail={};
			var supplier_data_inside = 
			{
				name : row.businessname,
				mov : row.mov,
				tolerance:row.otv
			};
			//console.log(row.supplierid);
			//supplier_data_detail.push(supplier_data_inside);
				supplier_data_detail = $.extend({},supplier_data_inside);
			suppliers_list[row.supplierid] = $.extend({},supplier_data_detail);
		
			
			
			//Stores all suppliers and their mov values indexed by supplier_id
			/*
			suppliers_list[supplier_id]
				.name
				.mov
				.tolerance
			*/
		}
		fetch_counter++;
		check_counter();
	});
		
	/*
	order_profiles_list[profile_id]
		.name
		.default
		.profile_id 
		.products_list[product_id]
			.quantity
			.supplier_settings[supplier_id]
				.premium
				.name 
	*/
	
		
	//find out all pricing data for the product and place in the pricing data or the products list;
	
	// products_list[product_id].pricing_list[supplier_id] = $.extend({}, pricing_data_inside);
}

//Initialize the global supplier settings 
function init_global_supplier_settings()
{
	//for each supplier 

	$.each(suppliers_list, function (key, value)
	{
		
		if(typeof(value)!='undefined')
		{
			global_supplier_settings[key]={};
			var prem_name=
				{
					premium:0,
					name:suppliers_list[key].name					
				};
			global_supplier_settings[key]=$.extend({},prem_name); 
		
		}
	});

}

//Function init_add_product 
function init_add_product()
{
	var str='';
	$.each(products_list, function (product_id, product_details)
	{
		if(typeof(product_id, product_details)!='undefined')
		{
			var productlabel = products_list[product_id].product_data.title;
			var productdescription = products_list[product_id].product_data.description;
			var img_str = products_list[product_id].product_data.image;
			if (product_id in order_list) checked = " checked "; else checked = "";
			//Write the product box html 
			/* str = str + "<div class='pp-product pickpc'><div class='pp-product-selector'><input class='product_picker_check' id='product_picker_check_'"+product_id+"' type='checkbox' "+checked+" onclick=toggle_product('"+product_id+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_str+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+productlabel+"</div><div class='pp-product-description'>"+productdescription+"</div></div></div>"; */
			
			var cat_insert = "category ='"+product_details.product_data.category_id+"' subcategory = '"+product_details.product_data.subcategory_id+"'"; //TBI
			
			str = str + "<div class='pp-product pickpc' "+cat_insert+"><div class='pp-product-selector'><input class='product_picker_check' id='product_picker_check_"+product_id+"' type='checkbox' "+checked+" onclick=toggle_product('"+product_id+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_str+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+productlabel+"</div><div class='pp-product-description'>"+productdescription+"</div></div></div>"; //TBI
		}
		

	});
	
	
	$("#product_view1").html(str);
}

//Load order profile 
function load_order_profile(profile_id)
{
	$("#profile_list").hide();
	//If order profile exists 
	if (profile_id in order_profiles_list)
	{
		//Empty order list first 
		if (typeof(order_list)!='undefined') while (order_list.length>0) {order_list.pop();}
		order_list = {};		
		init_global_supplier_settings();
		//Go through each item in the order profile 
		$.each(order_profiles_list[profile_id].products_list, function (product_id, product_details)
		{
			if(typeof(product_details)!='undefined')
			{
				var temp_product = {};
				product_id=""+product_id;
				temp_product = $.extend({}, products_list[product_id]);
				temp_product.moqioqflag = false;
				temp_product.substitutes = new Array;
				//Copy global supplier settings 
				temp_product.supplier_settings = new Array();
				temp_product.selected_supplier = -1;
				temp_product.selected_price = 0;
				temp_product.selected_discount = 0;
				temp_product.selected_rebate = 0;
				temp_product.quantity = 0;
				//Copy whatever is in the temp 
				order_list[product_id] = $.extend({},temp_product);
				//Copy product supplier settings
				order_list[product_id].supplier_settings = $.extend({},product_details.supplier_settings);
				order_list[product_id].quantity = product_details.quantity;
				order_list[product_id].available_suppliers = [];
				find_recommended_supplier(product_id);
			}
		});
		//recalculate_selected_suppliers();
		$("#profile_name").html(order_profiles_list[profile_id].name);
		//Save active profile id in global variable
		active_profile_id=profile_id;
		redraw_order_list();
		$("#save_update_profile").html('<img onclick="save_order_profile('+profile_id+')" src="images/save.png">');
	}
}

//Function which redraws the order list page - TBD - WIP
function redraw_order_list()
{
	//Find out selected suppliers list 
	recalculate_selected_suppliers();
	var html_str = "";
	//Iterate through each product 
	$.each(order_list, function(product_id, product_details)
	{
		if (typeof(product_details)!='undefined') 
		{//KC		//var product_details = order_list[product_id];
		var padding = "000000" ;
		var padded_product_id = "DBAP" + padding.substring(0, 6 - product_id.length) + product_id;
		var img_str;
		var productlabel = product_details.product_data.title;
		var productquantity = product_details.quantity;
		if(productquantity=='')productquantity=0;
		var productpackquantity = product_details.product_data.pack_quantity;
		var productunitofmeasure = product_details.product_data.unitofmeasure;
		var productselectedprice = parseFloat(product_details.selected_price).toFixed(2);
		var productselectedsupplier = product_details.selected_supplier;
		var productselectedsuppliername = "";
		var product_last_order_date = "";
		var product_last_order_qty = "";
		var productioq = "";
		var productmoq = "";
		var productpriceincrease = "";
		var productpriceincreasedate = "";
		var productpriceincreasenew = "";
		var productvalueinvoice = "";
		var productpercentinvoice = "";
		var productminimumquantity= "";
		if (productselectedsupplier!=-1) 
		{
			productselectedsuppliername = suppliers_list[productselectedsupplier].name;
			product_last_order_date = product_details.pricing_list[productselectedsupplier].last_order_date;
			product_last_order_qty = product_details.pricing_list[productselectedsupplier].last_order_quantity;
			productioq = product_details.pricing_list[productselectedsupplier].ioq;
			productmoq = product_details.pricing_list[productselectedsupplier].moq;
			productpriceincrease = product_details.pricing_list[productselectedsupplier].priceincrease; //TBI
			productpriceincreasedate = product_details.pricing_list[productselectedsupplier].priceincreasedate; //TBI
			productpriceincreasenew = product_details.pricing_list[productselectedsupplier].priceincreasenew; //TBI
			productvalueinvoice = product_details.pricing_list[productselectedsupplier].valueinvoice; //TBI
			productpercentinvoice = product_details.pricing_list[productselectedsupplier].percentinvoice; //TBI
			productminimumquantity = product_details.pricing_list[productselectedsupplier].minimum_quantity; //TBI
		}
		var product_category = product_details.product_data.category_id;
		var product_DESC = product_details.product_data.description;
		
		product_category=category_list[product_category].name;
		
		var productcasequantity = product_details.product_data.case_quantity;
		
		
		img_str = product_details.product_data.image;
		var pricing_html = "";
		var quantity_html = "";
		
		var qty_border = "";
		if (!product_details.moqioqflag)qty_border='style="border:1px solid rgb(206, 0, 0);" '; 
		
		//PRomotion and PRice increase 
		var rebates_button = "";
		var offinvoice_button ="";
		var priceincrease_button = "";
		var offinvoice_message = "";
		var dots_rebate_offinvoice = "";
		var popup_rebate_text = "";
		var popup_offinvoice_text = "";
		var rebate_flag = false;
		var offinvoice_flag = false;
		$.each(product_details.pricing_list, function (supplier_id, supplier_pricing)
		{
			if (typeof(supplier_pricing)!='undefined')
			{
				var supplier_name = suppliers_list[supplier_id].name;
				var supplier_valueinvoice = supplier_pricing.valueinvoice;
				var supplier_percentinvoice = supplier_pricing.percentinvoice;
				var supplier_minimumqty = supplier_pricing.minimum_quantity;
				var offinvoice_rebate_dates=supplier_pricing.rebate_offinovice_dates;
				//Check if any vendors are giving rebate
				if (supplier_pricing.rebate!=0)
				{	
					//this is to turn on the rebate flag
					rebate_flag = true;
					offinvoice_rebate_dates=offinvoice_rebate_dates.split("%%%%");
					var date_from=date_format_change(offinvoice_rebate_dates[0]);
					var date_to=date_format_change(offinvoice_rebate_dates[1]);
					//create the message for the suppliers who are giving rebate
					//popup_rebate_text = popup_rebate_text + "<p><b>"+supplier_name+"</b> Supplier is offering a rebate of $"+supplier_valueinvoice+" given a min. order Qty of "+supplier_minimumqty+"</p>";
					popup_rebate_text = popup_rebate_text + "<p><b>"+supplier_name+"</b> is offering a $"+supplier_valueinvoice+" per case rebate for "+date_from+" - "+date_to+"</p>";
					popup_rebate_text=popup_rebate_text+supplier_pricing.promotion_text;
					
				}
				if (supplier_pricing.offinvoice==1)
				{
					//this is to turn on the offinvoice flag
					offinvoice_flag = true;
					
					offinvoice_rebate_dates=offinvoice_rebate_dates.split("%%%%");
					var date_from=date_format_change(offinvoice_rebate_dates[0]);
					var date_to=date_format_change(offinvoice_rebate_dates[1]);
					
					//create the message for the suppliers who are giving offinvoice
					var temp_message = "";
					if (supplier_valueinvoice!=0) 
						temp_message = "$"+supplier_valueinvoice;
					else if (supplier_percentinvoice!=0) 
						temp_message = ""+supplier_percentinvoice+"%";
					//popup_offinvoice_text = popup_offinvoice_text + "<p><b>"+supplier_name+"</b> Supplier is offering a discount of "+temp_message+" given a min. order Qty of "+supplier_minimumqty+"</p>";
					
					popup_offinvoice_text = popup_offinvoice_text + "<p><b>"+supplier_name+"</b> is offering a $"+supplier_valueinvoice+" per case offinvoice for "+date_from+" - "+date_to+"</p>";
					
					popup_offinvoice_text=popup_offinvoice_text+supplier_pricing.promotion_text;
					
					//if present supplier is giving offinvoice share that info below the price
					if (supplier_id==productselectedsupplier) 
					{
						var temp_message = "";
						if (productvalueinvoice!=0) 
							temp_message = "$"+productvalueinvoice;
						else if (productpercentinvoice!=0) 
							temp_message = ""+productpercentinvoice+"%";
						offinvoice_message = "<p>"+temp_message+" off on minimum qty of "+productminimumquantity+"</p>";
					}
				}
			}
		});
		if (rebate_flag) 
		{
			//Is there Rebate by anyone - if yes add a dot
			dots_rebate_offinvoice=".";
			popup_rebate_text = popup_rebate_text;
			rebates_button = '<li onclick=\'show_popup("Rebates", \"'+popup_rebate_text+'\")\' style="color:#6AC224;">R</li></ul>'; 
		}
		if (offinvoice_flag) 
		{
			//Is there off invoice by anyone - if yes add a dot 
			dots_rebate_offinvoice=dots_rebate_offinvoice+".";
			offinvoice_button = '<li onclick=\'show_popup("OffInvoice", \"'+popup_offinvoice_text+'\")\' style="color:rgb(96, 146, 223);">$</li>';
		}

		if (productpriceincrease!=0)
		{
			var popup_priceincrease_text = "<p><b>"+productselectedsuppliername+"</b> is changing the Price of this product to $"+productpriceincreasenew+" wef "+productpriceincreasedate+"</p>";
			priceincrease_button = '<i onclick=\'show_popup("Price Change alert",\"'+popup_priceincrease_text+'\")\' style="color:green;">!</i>';
		}
		//TBI		

		//Supplier selector HTML
		if (productselectedsupplier!=-1) 
		{
			productselectedprice=tocurrency(productselectedprice)
			pricing_html = '<div class="drop-1">$'+productselectedprice+'<br>'+offinvoice_message+'<center onclick=show_supplier_selector('+product_id+')>'+productselectedsuppliername+'</center><img class="drop1" src="images/drop.png"onclick=show_supplier_selector('+product_id+')><div class="open-info-main1" id="supplier_selector_dropdown_'+product_id+'" style="display: none;">';
			
			$.each(order_list[product_id].pricing_list, function (supplier_id, pricing_details)
			{
				if (supplier_id in order_list[product_id].available_suppliers)	
				{
					var available_suppliername = suppliers_list[supplier_id].name;
					if(available_suppliername.length > 5) available_suppliername = available_suppliername.substring(0,5)+"....";
					var available_supplierprice = products_list[product_id].pricing_list[supplier_id].price;
					pricing_html = pricing_html + '<li onclick=change_supplier('+product_id+','+supplier_id+') >$'+available_supplierprice+' '+available_suppliername+'</li>'; 
				}
			});
			pricing_html = pricing_html + '</div></div>';
		}
		else
		{
			pricing_html = '<div class="drop-1"><br><center style="color:red">No Supplier</center><img class="drop1" src="images/drop.png"><div class="open-info-main1" style="display: none;"></div></div>';
		}
		
		//Quantity and Deletion HTML
		// Jatin change
		var productquantity_disp='';
		if (productquantity==0) 
			productquantity_disp = ""; 
		else 
			productquantity_disp= "" + productquantity;
		
		if(!isNaN(productquantity))
		{
			prodplus = parseInt(productquantity) + 1;
			prodminus = parseInt(productquantity) - 1;
		}
		else
		{
			prodplus = 1;
			prodminus = 0;			
		}
			
		quantity_html = '<td class="large-width">'+priceincrease_button+'<span onclick=change_product_quantity('+product_id+','+prodplus+')>+</span><input type="number" '+qty_border+' onclick="this.select();" value="'+productquantity_disp+'" id="product_'+product_id+'" onchange=change_product_quantity('+product_id+',this.value)><span onclick=change_product_quantity('+product_id+','+prodminus+')>-</span></td><td class="small-width"><u><img src="images/delete.png" onclick=remove_product("'+product_id+'")></u></td>';

		html_str = html_str + '<tr class="co_contain_tr"><td class="one" ><p onclick="togle_lower('+product_id+')">'+productlabel+'<b>'+productunitofmeasure+'</b></p>'+ pricing_html + '<div class="more"><h1>'+dots_rebate_offinvoice+'</h1></div></td>'+ quantity_html + '</tr>"';

		var substitute_html="<div class='substitutes'><div class='addsubstitute' onclick='show_product_substitutes("+product_id+")'>Add/Edit Substitute</div><div class='substitute_list'>";
		//Iterate through each substitute already added 
		$.each(order_list[product_id].substitutes, function(substitute_id, substitute_details)
		{
			substitute_html = substitute_html + "<div class='substitute'><div class='substitute_product'>"+products_list[substitute_id].product_data.title+"</div></div>";
		});
		substitute_html = substitute_html + "</div></div>";

		//html_str = html_str + '<tr class="open-info" id="lower'+product_id+'" style="display:none;"><td><div class="left"><img style="width:30%" src="'+img_str+'"></div><div class="right"><p></p><div class="large-width"><h4><b>Product ID:</b>'+padded_product_id+'</h4><br><h4><b>Category:</b>'+product_category+'</h4><br><h4><b>unit measure:</b>'+productunitofmeasure+'</h4><br><h4><b>Case Quantity:</b>'+productcasequantity+'</h4><br><h4><b>Case wt</b></h4><h4><b>Pack Qty</b>'+productpackquantity+'</h4><br><h4><b>Minimum Order Qty:</b>'+productmoq+'</h4><br><h4><b>Incremental Order Qty:</b>'+productioq+'</h4><br><h4><b>Last Order Qty:</b> '+product_last_order_qty+'</h4><br><h4><b>Last Order Date:</b> '+product_last_order_date+'</h4><br></div>'+'<div class="large-width"><ul>'+offinvoice_button+rebates_button+'</ul></div></div></td>'+'<td><a href="#" onclick=show_product_supplier_settings('+product_id+') >Supplier Settings</a><a href="#" onclick="show_product_substitutes('+product_id+')">Substitutes </a>'+substitute_html+'</td></tr>';
		
		html_str = html_str + '<tr class="open-info" id="lower'+product_id+'" style="display:none;"><td><div class="left"><img style="width:30%" src="'+img_str+'"></div><div class="right"><p></p><div class="large-width"><h4><b>Product ID:</b>'+padded_product_id+'</h4><br><h4><b>Product desc:</b>'+product_DESC+'</h4><h4><b>Category:</b>'+product_category+'</h4><br><h4><b>unit measure:</b>'+productunitofmeasure+'</h4><br><h4><b>Case Quantity:</b>'+productcasequantity+'</h4><h4><b>Last Order Qty:</b> '+product_last_order_qty+'</h4><br><h4><b>Last Order Date:</b> '+product_last_order_date+'</h4><br></div>'+'<div class="large-width"><ul>'+offinvoice_button+rebates_button+'</ul></div></div></td>'+'<td><a href="#" onclick=show_product_supplier_settings('+product_id+') >Supplier Settings</a><a href="#" onclick="show_product_substitutes('+product_id+')">Substitutes </a>'+substitute_html+'</td></tr>';			
		
					
		}//KC
	});
	
	//Draw the base line with coloring as per MOV and Tolerance 
	var footer_html = "";
	//Get the total number of suppliers 
	var supplier_count = 0;
	$.each (selected_suppliers_list, function(supplier_id, supplier_details)
	{
		if (typeof(supplier_details)!='undefined')
		{
			var color;
			if (supplier_details.color==0) 
				color =  "style='border-top: 3px solid rgb(206, 0, 0);'";
			else if (supplier_details.color==1)
				color =  "style='border-top: 3px solid rgb(238, 252, 32);'" ;				
			else 
				color =  "style='border-top: 3px solid rgb(105, 172, 53);'";
			//Make the box div 
			footer_html = footer_html + "<li id='footer"+supplier_id+"' "+color+" onclick='create_review_order()'>"+suppliers_list[supplier_id].name+"</li>"; //TBD - add create_order_review
			supplier_count++;
		}
	});

	//Depending on count of suppliers change the width classes  
	if(supplier_count==1)
	{
		$("#footer_down").removeClass();
		$("#footer_down").addClass('footer-down');
	}
	else if(supplier_count==2){
		$("#footer_down").removeClass();
		$("#footer_down").addClass('footer-down4');
	}else if(supplier_count>2){
		$("#footer_down").removeClass();
		$("#footer_down").addClass('footer-down2');
	}
	$("#lis_div").html(html_str);
	$("#footer_down").html(footer_html);

}


//Remove a product from order_list 
function remove_product(product_id)
{
	//find the product id in order_list
	if (product_id in order_list)
	{
		//if found then splice the order from 
		/* var index = $.inArray(product_id, order_list);
		//var index=order_list.product_id.indexOf(product_id)
		order_list.splice(index,1); */
		delete order_list[product_id];
		//Recalculate selected suppliers list 
		redraw_order_list();
		recalculate_selected_suppliers();
	}	
}

//Add or remove depending on whats present status
function toggle_product(product_id)
{
	if (product_id in order_list)
		remove_product(product_id);
	else
		add_product(product_id);
}

//Calculates the the most suitable supplier for the product_id within the order_list
function find_recommended_supplier(product_id)
{
	find_available_suppliers(product_id);
	//if available_suppliers are zero show no suppliers and put -1 in selected supplier 
	if ((typeof(order_list[product_id].available_suppliers)=='undefined'))
	{
		order_list[product_id].selected_supplier = -1;
		order_list[product_id].selected_price = 0;
		order_list[product_id].selected_discount = 0; //TBI
		order_list[product_id].selected_rebate = 0; //TBI
		return "glob";
	}
	if ((order_list[product_id].available_suppliers.length==0))
	{
		order_list[product_id].selected_supplier = -1;
		order_list[product_id].selected_price = 0;
		return "blo";
	}
	var temp_supplier_pricing = {};
	var minimum_price = 10000000;
	var minimum_supplier_id = -1;
	//Create a temp list of supplier ids and prices (with premium adjustment) of available suppliers
	$.each(order_list[product_id].available_suppliers, function(supplier_id, value)
	{
		if (typeof(value)!='undefined')
		{
			temp_supplier_pricing[supplier_id] = parseFloat(parseFloat(order_list[product_id].pricing_list[supplier_id].price) * (1-(parseInt(order_list[product_id].supplier_settings[supplier_id].premium)/100))).toFixed(2);
			if (parseFloat(temp_supplier_pricing[supplier_id])<minimum_price) {minimum_supplier_id = supplier_id; minimum_price = parseFloat(temp_supplier_pricing[supplier_id]).toFixed(2);}
		}
	});
	//recommended_supplier_id = temp_supplier_pricing.indexOf(""+minimum_price);
	if (minimum_supplier_id!=-1)
	{
		recommended_supplier_id = minimum_supplier_id;
		change_supplier(product_id, recommended_supplier_id);
	}
}

//Filter available suppliers based on supplier settings of the product 
function find_available_suppliers(product_id)
{
	//iterate through available suppliers and prices and put filtered ones into a available list in the order_list 
	//Empty the available suppliers list 
	if (typeof(order_list[product_id].available_suppliers)!= 'undefined') while(order_list[product_id].available_suppliers.length>0) order_list[product_id].available_suppliers.pop();
	//Iterate through all Suppliers 
	for (var supplier_id in products_list[product_id].pricing_list)
	{
		//supplier_id = order_list[product_id].pricing_list[].supplierid;
		if (supplier_id in order_list[product_id].supplier_settings)
			order_list[product_id].available_suppliers[supplier_id] = true;
	}
}

//Change the product qty - State saving
function change_product_quantity(product_id, qty)
{
	
	//Save new quantity into the product in order_list 
	if(qty<0) return;
	
	if (product_id in order_list)
	{
		order_list[product_id].quantity = qty;
		recalculate_moqioq_flag(product_id);
		//Highlight the box - TBD
		redraw_order_list()
	}
}

//Change the supplier - Redraws
function change_supplier(product_id, supplier_id)
{
	//Check if product_id is in the order_list 
	if (product_id in order_list)
	{
		//see if supplier_id is in available_suppliers_list 
		if (supplier_id in order_list[product_id].available_suppliers)
		{
			//change the selected supplier 
			order_list[product_id].selected_supplier = supplier_id;
			order_list[product_id].selected_price = parseFloat(order_list[product_id].pricing_list[supplier_id].price).toFixed(2);
			//Recaluclate MOQ/IOQ validation as per present selected Supplier
			recalculate_moqioq_flag(product_id);
			//recalculate_selected_suppliers();
			redraw_order_list();
		}
	}
}

//Recalculate the MOQ/IOQ flag for the product - State saving
function recalculate_moqioq_flag(product_id)
{
	var selected_supplier =order_list[product_id].selected_supplier;
	//if no supplier is selected return 
	if (selected_supplier == -1) return;
	//get supplier moq, ioq
	var moq = order_list[product_id].pricing_list[selected_supplier].moq;
	var ioq = order_list[product_id].pricing_list[selected_supplier].ioq;
	var product_qty = order_list[product_id].quantity;
	
	if ((product_qty<moq)||((product_qty-moq)%ioq!=0))
		order_list[product_id].moqioqflag = false;		
	else 
		order_list[product_id].moqioqflag = true;	

	//See if off invoice applies - TBI
	var supplier_id = order_list[product_id].selected_supplier;
	if (supplier_id!=-1) 
	{
		var minimum_quantity = order_list[product_id].pricing_list[supplier_id].minimum_quantity;
		var offinvoice = order_list[product_id].pricing_list[supplier_id].offinvoice;
		var pecentinvoice = order_list[product_id].pricing_list[supplier_id].percentinvoice;
		var valueinvoice = order_list[product_id].pricing_list[supplier_id].valueinvoice;
		if (product_qty>=minimum_quantity)
		{
			if (offinvoice==1)
			{
				if (valueinvoice!=0)
				{
					order_list[product_id].selected_price = parseFloat(order_list[product_id].pricing_list[supplier_id].price)  - valueinvoice;
					order_list[product_id].selected_discount  = valueinvoice;
				}
				else if (percentinvoice!=0)
				{
					order_list[product_id].selected_price = parseFloat(order_list[product_id].pricing_list[supplier_id].price)  * (1- (parseFloat(percentinvoice)/100));
					order_list[product_id].selected_discount  = parseFloat(order_list[product_id].pricing_list[supplier_id].price)  * (parseFloat(percentinvoice)/100);
				}
			}
			order_list[product_id].selected_rebate = order_list[product_id].pricing_list[supplier_id].rebate; //TBI
		}
		else
		{
			order_list[product_id].selected_price =parseFloat(order_list[product_id].pricing_list[supplier_id].price).toFixed(2);
			
			//order_list[product_id].selected_price = parseFloat(order_list[product_id].pricing_list[supplier_id].price)
		}
	}
	
	
	/*if ((product_qty<moq)||((product_qty-moq)%ioq!=0)
		order_list[product_id].moqioqflag = false;		
	else 
		order_list[product_id].moqioqflag = true;		*/
	//redraw - TBD
}

//Find all the suppliers which are being used in the present order list - State saving
function recalculate_selected_suppliers()
{
	//Empty present selected_suppliers_list 
	if (typeof(selected_suppliers_list)!='undefined') while (selected_suppliers_list.length>0) {selected_suppliers_list.pop();}
	//Iterate all products in order_list 
	$.each(order_list, function(product_id, individual_product)
	{
		//Find the supplier id for this product 
		if(typeof(individual_product)!='undefined')
		{
			supplier_id = order_list[product_id].selected_supplier;
			//If supplier is selected 
			if (supplier_id!=-1)
			{
				//If selected_supplier_list contains then sum else initialize 
				if (supplier_id in selected_suppliers_list) 
					selected_suppliers_list[supplier_id].total = selected_suppliers_list[supplier_id].total + (individual_product.quantity * individual_product.selected_price);
				else
				{
					selected_suppliers_list[supplier_id]= {};	
					selected_suppliers_list[supplier_id].total = parseInt(individual_product.quantity) * parseFloat(individual_product.selected_price);
				}
			}
		}
	});
	$.each(selected_suppliers_list, function(supplier_id, supplier_details)
	{
		if (typeof(supplier_details)!='undefined')
		{
			//Based on total and MOV and Tolerance set the colors 
			var mov = suppliers_list[supplier_id].mov;
			var tolerance = suppliers_list[supplier_id].tolerance;
			var total =  selected_suppliers_list[supplier_id].total;
			if (total>=mov) 
				selected_suppliers_list[supplier_id].color = 2; //GREEN
			else if (total>=(mov*(1-(tolerance/100))))
				selected_suppliers_list[supplier_id].color = 1; //YELLOW 
			else
				selected_suppliers_list[supplier_id].color = 0; //RED
		}
	});
}

//Add a product from products_list into order_list 
function add_product(product_id)
{
	//find the product id in the products_list 
	if (product_id in products_list)
	{
		//find the product id in the order_list 
		if (!(product_id in order_list))
		{
			//if not found insert into order_list from products_list 
			var temp_product = {};
			temp_product = $.extend({}, products_list[product_id]);
			temp_product.moqioqflag = false;
			temp_product.substitutes = new Array;
			//Copy global supplier settings 
			temp_product.supplier_settings = new Array();
			temp_product.selected_supplier = -1;
			temp_product.selected_price = 0;
			temp_product.selected_discount = 0; //TBI
			temp_product.selected_rebate = 0; //TBI
			temp_product.quantity = 0;
			temp_product.available_suppliers = [];
			//Copy whatever is in the temp 
			order_list[product_id] = $.extend({},temp_product);
			//Copy global supplier settings
			order_list[product_id].supplier_settings = $.extend({},global_supplier_settings);			
			//Find recommended supplier
			find_recommended_supplier(product_id);
			//Recalculate the selected suppliers list
			recalculate_selected_suppliers();
			
		}
	}	
}

var str="";
/* //Function init_add_product 
function init_add_product()
{
	$.each(products_list, function (product_id, product_details)
	{
		if(typeof(product_details)!='undefined')
		{
			var productlabel = product_details.product_data.title;
			var productdescription = product_details.product_data.description;
			
			var img_str=product_details.product_data.image;
			
			if (product_id in order_list) checked = " checked "; else checked = "";
			//Write the product box html 
			str = str + "<div class='pp-product pickpc'><div class='pp-product-selector'><input class='product_picker_check' id='product_picker_check_"+product_id+"' type='checkbox' "+checked+" onclick=toggle_product('"+product_id+"') /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_str+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"+productlabel+"</div><div class='pp-product-description'>"+productdescription+"</div></div></div>";
		}
	})
	
	$("#product_view1").html(str);
}
 */
//Add or remove depending on whats present status
function toggle_product(product_id)
{
	if (product_id in order_list)
		remove_product(product_id);
	else
		add_product(product_id);
}

//Function to show the add product modal box
function show_add_product()
{
	$("#create_profile_div").hide();
	backArr.push('create_profile_div');	
	TBH = "product_picker";	
	//Unselect all products 
	$(".product_picker_check").prop('checked', false);
	//Update the products in the product picker 
	$.each(order_list, function (product_id, product_details)
	{
		$("#product_picker_check_"+product_id).prop('checked', true);
	});
	$('.overlay').fadeIn(100); 
	$('#product_picker').fadeIn(100); 	
}
//Function to hide add product modal box
function hide_add_product()
{
	//hide the modal box 
	$('.overlay').hide(); 
	$('#product_picker').hide(); 
	onBackKeyDown();	
	//Redraw the screen 
	redraw_order_list();
}

//Open global supplier panel
function show_product_supplier_settings(product_id)
{
	
	var str='';	
	//Draw the items on the page as per global settings values 
	$.each(suppliers_list, function (supplier_id, supplier_details)
	{
		if(typeof(supplier_details)!='undefined')
		{
			var supplier_name = supplier_details.name;
			var checked = "";
			var premium = 0;
			//Check if this is set
			if (supplier_id in order_list[product_id].supplier_settings) 
			{
				checked = " checked ";
				premium = order_list[product_id].supplier_settings[supplier_id].premium;
			}
			//Write the HTML
			str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' id='supsettings_"+supplier_id+"_"+product_id+"' "+checked+" /></div><div class='ss-supplier-label'>"+supplier_name+"</div><div class='ss-supplier-percentage' ><input type='number' value='"+premium+"' id='supsetting_premium_"+supplier_id+"_"+product_id+"' /> %</div></div>";
		}
	});
	
	
	str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' id='supsettings' /></div><div class='ss-supplier-label'></div><div class='ss-supplier-percentage' ><input type='number' value='' id='supsetting_premium /> %</div></div>";
	
	var header='<div class="ss-btncancel ss-headerbtn" onclick=$(".overlay").hide();$("#setng_supplier").hide();hide_product_supplier_settings()></div><div class="ss-btnselect ss-headerbtn" onclick=change_product_supplier_settings('+product_id+');$(".overlay").hide();$("#setng_supplier").hide();></div>';
	
	//Include the HTML into basic frame
	$("#sup_list_view").html(str);	
	$("#sup_setting_header").html(header);
	//make things visible
	$('.overlay').fadeIn(100); 
	$('#setng_supplier').fadeIn(100);
	//TBH
	$("#create_profile_div").hide();
	backArr.push('create_profile_div');	
	TBH = "setng_supplier";	
	//
	
}

//Hides the global supplier settings panel
function hide_product_supplier_settings()
{
	//Empty the html 
	$("#sup_list_view_global").html("");
	//Hide the modal box 
	$('.overlay').hide(); 
	$('#setng_supplier_global').hide();
	//Nothing else to be done 
	onBackKeyDown();
}

//Function to show a dialog with product substitutes
function show_product_substitutes(product_id)
{
	var substitute_html = "";
	//For each product go throuhg and create the HTML
	$.each(products_list, function(sub_product_id, product_details)
	{
		if(typeof(product_details)!='undefined')
		{
			var img_str = product_details.product_data.image;
			var productlabel = product_details.product_data.title;
			var checked = "";
			var padding = "000000" ;
			var padded_product_id = "DBAP" + padding.substring(0, 6 - sub_product_id.length) + sub_product_id;
			var productdescription = product_details.product_data.description;
			
			if (sub_product_id in order_list[product_id].substitutes) checked = " checked ";
			//Add the HTML of this product 
			var cat_insert = "category ='"+product_details.product_data.category_id+"' subcategory = '"+product_details.product_data.subcategory_id+"'"; //TBI
			substitute_html = substitute_html + "<div class='pp-product' "+cat_insert+"><div class='pp-product-selector'><input id='"+product_id+"' type='checkbox' "+checked+" /></div><div class='pp-product-image'><img class='pp-productimage' src='"+img_str
					+"'/></div><div class='pp-product-description'><div class='pp-product-label'>"
					+productlabel+"</div><div class='pp-product-description'>Product ID-"
					+padded_product_id+" - "+productdescription+"</div></div></div>"; //TBI
			//Select only those products which are in the substitutes list of the product in order list 
		}
	});
	
	var header_sub_product='<div class="pp-btncancel pp-headerbtn" onclick=$(".overlay").hide() 			$("#product_picker2").hide();hide_product_substitutes()></div><div class="pp-btnselect pp-headerbtn" onclick=$(".overlay").hide();$("#product_picker2").hide();change_product_substitutes('+product_id+')></div>';
			
	//copy html into the modal
	$("#product_view2").html(substitute_html);
	
	//copy html into the modal
	$("#sub_product_div").html(header_sub_product);
	//Show the modal box 
	$('.overlay').fadeIn(100); 
	$('#product_picker2').fadeIn(100);
	//Back array
	$("#create_profile_div").hide();
	backArr.push('create_profile_div');	
	TBH = "product_picker2";	
}

//Function to hide a dialog with product substitutes
function hide_product_substitutes()
{
	//Hide the substitute modal 
	$("#product_view2").html("");
	$('.overlay').hide(); 
	$('#product_picker2').hide();
}

//Change the product substitutes
//This function is called on the top tick of substitutes modal box 
function change_product_substitutes(product_id)
{
	//Empty the products substitutes for this product 
	while (order_list[product_id].substitutes.length>0) {order_list[product_id].substitutes.pop();}
	//iterate through HTML and find products which are checked 
	$("#product_view2 input[type=checkbox]").each(function() {
    	if ($(this).prop('checked'))
    	{
    		var substitute_product = $(this).prop('id');
    		order_list[product_id].substitutes[substitute_product] = true;
    	}
	});
	//hide the products substitutes modal 
	hide_product_substitutes();

}

//Apply product supplier settings
function change_product_supplier_settings(product_id)
{
	while(order_list[product_id].supplier_settings.length>0){order_list[product_id].supplier_settings.pop()};
	order_list[product_id].supplier_settings = {};
	//get information from checkmark and supplier id and premium values from HTML
	$.each(suppliers_list, function (supplier_id, supplier_details)
	{
		if(typeof(supplier_details)!='undefined')
		{
			var supplier_checkbox = "supsettings_"+supplier_id+"_"+product_id;
			var premium_input_name = "supsetting_premium_"+supplier_id+"_"+product_id;
			if ($("#"+supplier_checkbox).prop("checked"))
			{
				order_list[product_id].supplier_settings[supplier_id]={};
				order_list[product_id].supplier_settings[supplier_id].name = suppliers_list[supplier_id].name;
				order_list[product_id].supplier_settings[supplier_id].premium = $("#"+premium_input_name).val();
			}			
		}
	});
	//To find recommend supplier and then redraw complete order list
	find_recommended_supplier(product_id)
	//
	hide_product_supplier_settings();
	//redraw order list
	redraw_order_list();
}

function hide_product_supplier_settings()
{
	//Empty the html 
	$("#sup_list_view_global").html("");
	//Hide the modal box 
	$('.overlay').hide(); 
	$('#setng_supplier_global').hide();
	//Nothing else to be done 
	onBackKeyDown();
}


//Function to hide a dialog with product substitutes
function hide_product_substitutes()
{
	//Hide the substitute modal 
	$("#product_view2").html("");
	$('.overlay').hide(); 
	$('#product_picker2').hide();
	onBackKeyDown();
}

//Change the product substitutes
//This function is called on the top tick of substitutes modal box 
function change_product_substitutes(product_id)
{
	//Empty the products substitutes for this product 
	while (order_list[product_id].substitutes.length>0) {order_list[product_id].substitutes.pop();}
	//iterate through HTML and find products which are checked 
	$("#product_view2 input[type=checkbox]").each(function() {
    	if ($(this).prop('checked'))
    	{
    		var substitute_product = $(this).prop('id');
    		order_list[product_id].substitutes[substitute_product] = true;
    	}
	});
	//hide the products substitutes modal 
	hide_product_substitutes();
	
}

//Function to show supplier selector - TBD
function show_supplier_selector(product_id)
{
	$("#supplier_selector_dropdown_"+product_id).toggle();

}
//Function to hide supplier selector - TBD
function hide_supplier_selector(product_id)
{
	$("#supplier_selector_dropdown_"+product_id).hide();
}

//Creates review order
/* function create_review_order()
{
	$("#create_profile_div").hide();
	backArr.push('create_profile_div');
	TBH = "next_profile_div";
	$("#next_profile_div").show();
	var zeroquantitytoggle = false; 
	//If MOQ and IOQ of any products is not matching alert and return 
	$.each(order_list, function (product_id, individual_product)
	{
		if(typeof(individual_product)!='undefined')
		{
			if (individual_product.quantity==0) zeroquantitytoggle = true;
			if (individual_product.moqioqflag)
			{
				notification ("MOQ and IOQ values for product " + individual_product.product_data.title + " is not matching");
				return;
			}
		}
	});
	if (zeroquantitytoggle!=0) notification("Products with zero quantity will be dropped");
	//Empty the supplier_orders_list
	while(supplier_orders_list.length>0) { supplier_orders_list.pop(); }
	//Iterate through order_list and push into supplier order list page 
	$.each(order_list, function (product_id, individual_product)
	{
		if (typeof(individual_product)!='undefined')
		{
			supplier_id = individual_product.selected_supplier;
			if (supplier_id!=-1)
			{
				if (!(supplier_id in supplier_orders_list)) 
				{
					supplier_orders_list[supplier_id] = {};
					supplier_orders_list[supplier_id].products_list[product_id] = {};
				}

				//Copy the value into the products list of the supplier order list 
				supplier_orders_list[supplier_id].products_list[product_id].product_data = $.extend({}, individual_product.product_data);
				supplier_orders_list[supplier_id].products_list[product_id].price = individual_product.selected_price;
				supplier_orders_list[supplier_id].products_list[product_id].quantity = individual_product.quantity;
				supplier_orders_list[supplier_id].products_list[product_id].moqioqflag = true;
				//Add the total for the supplier
				supplier_orders_list[supplier_id].totalvalue = supplier_orders_list[supplier_id].totalvalue + (parseFloat(individual_product.price) * parseInt(individual_product.quantity));
				supplier_orders_list[supplier_id].ordered = false;
				supplier_orders_list[supplier_id].order_no = -1;
			}
			else
			{
				notification("There is no supplier for "+individual_product.product_data.name);
			}
		}
	});
	//Calculate the mov flags
	or_recalculate_mov_flag();
	//update the back array - TBD
	//Draw the order review screen 
	redraw_order_review();	
}
 */
//Creates review order
function create_review_order()
{
	$("#create_profile_div").hide();
	backArr.push('create_profile_div');
	TBH = "next_profile_div";
	$("#next_profile_div").show();
	var zeroquantitytoggle = false; 
	
	//If MOQ and IOQ of any products is not matching alert and return 
	$.each(order_list, function (product_id, individual_product)
	{
		if (individual_product.quantity==0) zeroquantitytoggle = true;
		if (individual_product.moqioqflag)
		{
			//alert ("MOQ and IOQ values for product " + individual_product.product_data.title + " is not matching");
			return;
		}
	});
	if (zeroquantitytoggle!=0) alert("Products with zero quantity will be dropped");
	//Empty the supplier_orders_list
	while(supplier_orders_list.length>0) { supplier_orders_list.pop(); }
	//Iterate through order_list and push into supplier order list page
	
	$.each(order_list, function (product_id, individual_product)
	{
		if (typeof(individual_product)!='undefined')
		{
			supplier_id = individual_product.selected_supplier;
			if (supplier_id!=-1)
			{
				if (parseInt(individual_product.quantity)!=0) //TBI
				{
				if(!(supplier_id in supplier_orders_list))
				{
					supplier_orders_list[supplier_id]={};
					supplier_orders_list[supplier_id].products_list={};
					supplier_orders_list[supplier_id].totalvalue = 0;
				}
				supplier_orders_list[supplier_id].products_list[product_id]={};
				//Copy the value into the products list of the supplier order list 
				individual_product.product_data.quantity=order_list.quantity;
				supplier_orders_list[supplier_id].products_list[product_id].product_data = $.extend({}, individual_product.product_data);	
				supplier_orders_list[supplier_id].products_list[product_id].price = individual_product.selected_price;				
				supplier_orders_list[supplier_id].products_list[product_id].quantity = individual_product.quantity;
				supplier_orders_list[supplier_id].products_list[product_id].discount = individual_product.selected_discount; //TBI
				supplier_orders_list[supplier_id].products_list[product_id].rebate = individual_product.selected_rebate; //TBI
				supplier_orders_list[supplier_id].products_list[product_id].moqioqflag = true;
				supplier_orders_list[supplier_id].products_list[product_id].substitutes = $.extend({},individual_product.substitutes); //TBI
				//Add the total for the supplier
				supplier_orders_list[supplier_id].totalvalue =supplier_orders_list[supplier_id].totalvalue + (parseFloat(individual_product.selected_price) * parseInt(individual_product.quantity));
				
				supplier_orders_list[supplier_id].ordered = false;
				supplier_orders_list[supplier_id].order_no = -1;
				}
				else
				{
					//alert(individual_product.product_data.name + " has zero quantity selected");//TBI
				}
			
			}
			else
			{
				var r = confirm("There is no supplier for "+individual_product.product_data.title+". Are you sure you want to remove this product?");
				if (r == true) 
				{
					//x = "You pressed OK!";
				} 
				else 
				{
					//x = "You pressed Cancel!";
					$("#"+TBH).show();
					onBackKeyDown();
					return false;
				}
			}
		}
	});
	//Calculate the mov flags
	or_recalculate_mov_flag();
	//update the back array - TBD
	//Draw the order review screen 
	redraw_order_review();	
}


/*  //Creates review order
function create_review_order()
{
	$("#create_profile_div").hide();
	backArr.push('create_profile_div');
	TBH = "next_profile_div";
	$("#next_profile_div").show();
	
	var zeroquantitytoggle = false; 
	//If MOQ and IOQ of any products is not matching alert and return 
	$.each(order_list, function (product_id, individual_product)
	{
		if (individual_product.quantity==0) zeroquantitytoggle = true;
		if (individual_product.moqioqflag)
		{
			notification ("MOQ and IOQ values for product " + individual_product.product_data.title + " is not matching");
			return;
		}
	});
	if (zeroquantitytoggle!=0) notification("Products with zero quantity will be dropped");
	//Empty the supplier_orders_list
	while(supplier_orders_list.length>0) { supplier_orders_list.pop(); }
	//Iterate through order_list and push into supplier order list page 
	$.each(order_list, function (product_id, individual_product)
	{
		if (typeof(individual_product)!='undefined')
		{
			supplier_id = individual_product.selected_supplier;
			if (!(supplier_id in supplier_orders_list))
			{
				supplier_orders_list[supplier_id] = {};
				supplier_orders_list[supplier_id].products_list = {};
			}
			if (supplier_id!=-1)
			{
				if (parseInt(individual_product.quantity)!=0) //TBI
				{
					supplier_orders_list[supplier_id].products_list[product_id] = {};
					//Copy the value into the products list of the supplier order list 
					supplier_orders_list[supplier_id].products_list[product_id].product_data = $.extend({}, individual_product.product_data);
					supplier_orders_list[supplier_id].products_list[product_id].price = individual_product.selected_price;
					supplier_orders_list[supplier_id].products_list[product_id].quantity = individual_product.quantity;
					supplier_orders_list[supplier_id].products_list[product_id].discount = individual_product.selected_discount; 
					supplier_orders_list[supplier_id].products_list[product_id].rebate = individual_product.selected_rebate;
					supplier_orders_list[supplier_id].products_list[product_id].moqioqflag = true;
					supplier_orders_list[supplier_id].products_list[product_id].substitutes = $.extend({},individual_product.substitutes); 
					//Add the total for the supplier
					supplier_orders_list[supplier_id].totalvalue = supplier_orders_list[supplier_id].totalvalue + (parseFloat(individual_product.price) * parseInt(individual_product.quantity));
					supplier_orders_list[supplier_id].ordered = false;
					supplier_orders_list[supplier_id].order_no = -1;
				}
				else //TBI
				{
					notification(individual_product.product_data.name + " has zero quantity selected");//TBI
				}
			}
			else
			{
				notification("There is no supplier for "+individual_product.product_data.name);
			}
		}
	});
	//Calculate the mov flags
	or_recalculate_mov_flag();
	//update the back array - TBD
	//Draw the order review screen 
	redraw_order_review();	
}

  */
//Draw the Order review screen
function redraw_order_review()
{
	var html_str="";
	//clear the html 
	$("#supplier_by_order").html("");
	var ctr = 0;
	var weekdays = ['Su', 'Mo','Tu','We','Th','Fr','Sa'];
	//for each supplier prepare an HTML listing 
	$.each(supplier_orders_list, function (supplier_id, supplier_order_detail)
	{
		if (typeof(supplier_order_detail)!='undefined')
		{
			var supplier_ordered = supplier_order_detail.ordered;
			if (!supplier_ordered)
			{
				var suppliername = suppliers_list[supplier_id].name;
				var supplier_total = parseFloat(supplier_order_detail.totalvalue).toFixed(2);
				var supplier_mov = suppliers_list[supplier_id].mov;
				var requested_delivery_date = new Date();
				requested_delivery_date.setDate(requested_delivery_date.getDate() + 2);
				var requested_day = weekdays[requested_delivery_date.getDay()];
				requested_delivery_date2 = ""+requested_delivery_date.getFullYear()+"-"+(requested_delivery_date.getMonth()+1)+"-"+requested_delivery_date.getDate();
				requested_delivery_date = requested_delivery_date2;
				//This for making border color
				//supplier_orders_list[supplier_id].requested_delivery_date = requested_delivery_date;
				var style_css='';
				//border-left: 3px solid rgb(105, 172, 53);
				if(supplier_orders_list[supplier_id].color==0)	style_css='style="border-left: 3px solid rgb(206, 0, 0)"';//Red color
				else if(supplier_orders_list[supplier_id].color==1)	style_css='style="border-left: 3px solid rgb(238, 252, 32)"';//Green color
				else style_css='style="border-left: 3px solid rgb(105, 172, 53)"'; //Yellow color
				//Chnage to currency format
				supplier_mov=tocurrency(supplier_mov)
				supplier_total=tocurrency(supplier_total);
				//for each product under the supplier make a HTML listing
				html_str = html_str + '<li id="li_single_order'+ctr+'"><input checked="" type="checkbox" id="supplier_'+supplier_id+'" onclick="or_remove_supplier('+supplier_id+')"><label onclick="table_show('+ctr+')" '+style_css+'>'+suppliername+'</label><p class="price" onclick="table_show('+ctr+')">$'+supplier_mov+'</p><big id="total_sup_value'+ctr+'">$'+supplier_total+'</big><i style="margin: 9px 10px;" id="dayd'+ctr+'">'+requested_day+'</i><input class="date_pic" type="date"  style="padding: 4px 0px;float: left;width: 20%;border: 1px solid silver;" onchange="or_set_date('+supplier_id+')" value="'+supplier_orders_list[supplier_id].requested_delivery_date+'" id="rdate_'+supplier_id+'" ><span><img src="images/select.png" onclick="or_place_order('+supplier_id+')"></span></li>';
 
				//All products 
				var tctr = 0;
				html_str = html_str + '<table class="dba-profile" id="tableor'+ctr+'" style="display:none;"><tbody>';
		
				$.each(supplier_order_detail.products_list, function(product_id, product_details)
				{
					if (typeof(product_details)!='undefined')
					{
						var productname = product_details.product_data.title;
						var productunitofmeasure = product_details.product_data.unitofmeasure;
						var productquantity = product_details.quantity;
						var prodqtyplus = parseInt(productquantity)+1;
						var prodqtyminus = productquantity-1;
						
						//Add each product for this supplier 
						html_str = html_str + '<tr id="all_product_tr'+ctr+''+tctr+'"><td class="one"><p>'+productname+'<b>'+productunitofmeasure+'</b></p><div class="drop-1"><div class="open-info-main1"></div></div></td><td class="large-width">'+'<span onclick="or_change_quantity('+supplier_id+','+product_id+','+prodqtyplus+')">+</span>'+'<input  id="all_qty'+ctr+''+tctr+'" type="number" onchange="or_change_quantity('+supplier_id+','+product_id+',this.value)" value="'+productquantity+'" onclick="this.select();">'+'<span onclick="or_change_quantity('+supplier_id+','+product_id+','+prodqtyminus+')">-</span></td>'+'<td class="small-width"><u><img src="images/delete.png" onclick="or_remove_product('+supplier_id+','+product_id+')"></u></td></tr>';
						tctr++;
					}
				});
				html_str = html_str + '</tbody></table>';
			}
			else
			{
				//Ordered order HTML comes here 	
				var order_id = supplier_order_detail.order_no;
				//alert(order_id);
				var padding = "000000" ;
				//var padded_order_id = "DBAO" + padding.substring(0, 6 - order_id.length) + order_id;
				var pad = "000000";
				var padded_order_id="DBAO"+pad.substring(0, pad.length - order_id.length) + order_id;		
				//alert(padded_order_id);
				html_str = html_str + '<li id="li_single_order'+ctr+'">Order No. '+padded_order_id+' has been placed</li>';
			}
			ctr++;
			
			
		}
	});

	//Insert html into page 
	$("#supplier_by_order").html(html_str);
	//Display the basic frame ofr Order Review screen 
	$("#next_profile_div").fadeIn(100);
	//This is to keep open the 
	for(var ik=0;ik<open_table_array.length;ik++)
	{
		if(typeof(open_table_array[ik])!='undefined')
		{
			table_show_test(open_table_array[ik]);
		}
	}
	
}

function or_recalculate_mov_flag()
{
	//Check MOV validation and figure out colors 
	$.each(supplier_orders_list, function (supplier_id, order_details)
	{
		if(typeof(order_details)!='undefined')
		{
		//Check if the total of the supplier wrt MOV and Tolerance 
		var mov = suppliers_list[supplier_id].mov;
		var tolerance = suppliers_list[supplier_id].tolerance;
		//alert(order_details.totalvalue+"---------------"+mov)
		if (order_details.totalvalue>=mov) 
			supplier_orders_list[supplier_id].color = 2; //GREEN
		else if (order_details.totalvalue>=(mov*(1-(tolerance/100))))
			supplier_orders_list[supplier_id].color = 1; //YELLOW 
		else
			supplier_orders_list[supplier_id].color = 0; //RED
		}
	});
}

//Change quantity function on order review page
function or_change_quantity(supplier_id, product_id, qty)
{
	var delete_id_flag=false;
	//Update qty
	if(qty==0)
	{
		or_remove_product(supplier_id, product_id);
		delete_id_flag=true;
		return;
	}
	
	if(!delete_id_flag)
	{
		supplier_orders_list[supplier_id].products_list[product_id].quantity = qty;
		var moq = order_list[product_id].pricing_list[supplier_id].moq;
		var ioq = order_list[product_id].pricing_list[supplier_id].ioq;
		supplier_orders_list[supplier_id].totalvalue=0;
		
		if ((qty<moq)||((qty-moq)%ioq!=0)) 
		{
			supplier_orders_list[supplier_id].products_list[product_id].moqioqflag = false;
		}
		
		//See if off invoice applies - TBI
		var product_qty = qty;
		var minimum_quantity = order_list[product_id].pricing_list[supplier_id].minimum_quantity;
		var offinvoice = order_list[product_id].pricing_list[supplier_id].offinvoice;
		var pecentinvoice = order_list[product_id].pricing_list[supplier_id].percentinvoice;
		var valueinvoice = order_list[product_id].pricing_list[supplier_id].valueinvoice;
		if (product_qty>=minimum_quantity)
		{
			if (offinvoice==1)
			{
				if (valueinvoice!=0)
				{
					supplier_orders_list[supplier_id].products_list[product_id].price = parseFloat(order_list[product_id].pricing_list[supplier_id].price)  - valueinvoice;
					supplier_orders_list[supplier_id].products_list[product_id].offinvoice  = valueinvoice;
				}
				else if (percentinvoice!=0)
				{
					supplier_orders_list[supplier_id].products_list[product_id].price = parseFloat(order_list[product_id].pricing_list[supplier_id].price)  * (1- (parseFloat(percentinvoice)/100));
					supplier_orders_list[supplier_id].products_list[product_id].offinvoice  = parseFloat(order_list[product_id].pricing_list[supplier_id].price)  * (parseFloat(percentinvoice)/100);
				}
			}		
			supplier_orders_list[supplier_id].products_list[product_id].rebate = order_list[product_id].pricing_list[supplier_id].rebate; //TBI
		}
		else
		{
			supplier_orders_list[supplier_id].products_list[product_id].price=parseFloat(order_list[product_id].pricing_list[supplier_id].price);
			supplier_orders_list[supplier_id].products_list[product_id].offinvoice=0;
			supplier_orders_list[supplier_id].products_list[product_id].rebate=0;
		}
		
		//Change quantity in order list also 
		change_product_quantity(product_id,qty);
		//
		//for updating total value 
		$.each(order_list, function (product_ids, individual_product)
		{
			if (typeof(individual_product)!='undefined')
			{
				supplier_ids = individual_product.selected_supplier;
				//alert(individual_product.quantity);
				if(supplier_ids==supplier_id) supplier_orders_list[supplier_id].totalvalue = supplier_orders_list[supplier_id].totalvalue + (parseFloat(individual_product.selected_price) * parseInt(individual_product.quantity));
			}
			or_recalculate_mov_flag();
		});
		//Recalculate MOv flag 
		
		//Redraw the order review screeen
		redraw_order_review();
		//
	}
}
//Delete product function on order review page 
function or_remove_product(supplier_id, product_id)
{
	//Reduce the product total from the supplier total 
	var total_to_be_deducted = supplier_orders_list[supplier_id].products_list[product_id].price * supplier_orders_list[supplier_id].products_list[product_id].quantity;
	
	supplier_orders_list[supplier_id].totalvalue = parseFloat(supplier_orders_list[supplier_id].totalvalue - total_to_be_deducted).toFixed(2);
	
	//Remove the product from the list 
	// var index = $.inArray(product_id, supplier_orders_list[supplier_id].products_list);
	// if (index!=-1) supplier_orders_list[supplier_id].products_list.splice(index,1);
	delete supplier_orders_list[supplier_id].products_list[product_id];
	
	//Recalculate the Mov flags 
	or_recalculate_mov_flag();
	//Remove product from order list also 
	remove_product(product_id);
	//Redraw the order review screen
	redraw_order_review();
}

//function to set date for supplier 
function or_set_date(supplier_id)
{
	var date_del=$("#rdate_"+supplier_id).val();
	//Set the date 
	supplier_orders_list[supplier_id].requested_delivery_date = date_del;
}

//Reshuffles products into other suppliers
function or_remove_supplier(supplier_id)
{
	var no_of_supplier_in_order_list=0;
	// for checking if in order screen one supplier is left
	$.each (supplier_orders_list, function(supplier_id, supplier_details)
	{
		if(typeof(supplier_details)!='undefined')
		{
			no_of_supplier_in_order_list++;
		}
	});
	
	if(no_of_supplier_in_order_list!=1 && no_of_supplier_in_order_list!=0)
	{
		//this list contains the supplier ids of those suppliers who have already ordered 
		ordered_suppliers_list = {};
		//Find all supplier ids for which order can be placed 
		$.each(supplier_orders_list, function(ordered_supplier_id,ordered_supplier_order_detail)
		{
			if (typeof(ordered_supplier_order_detail)!='undefined')
			{
				if (!(ordered_supplier_order_detail.ordered))
					ordered_suppliers_list[ordered_supplier_id] = true;
			}
		});
		//Find all products from this supplier and build a temp order_list 
		//do a dry run with products to check if some of them now dont have any eligible suppliers 
		var temp_order_list = new Array();
		$.each(supplier_orders_list[supplier_id].products_list, function(product_id, product_details)
		{
			if (typeof(product_details)!='undefined')
			{
				//copy from order list into a temp order list 
				temp_order_list[product_id] = $.extend({},order_list[product_id]);
				//temp_order_list[product_id].available_suppliers = {};
				//temp_order_list[product_id].available_suppliers= $.extend({},ordered_suppliers_list);			
				//remove this supplier from orderable suppliers list 
				delete ordered_suppliers_list[supplier_id];
				//match orderable list with available suppliers of this product
				//remove also the suppliers for which the order has been already placed
				$.each(temp_order_list[product_id].available_suppliers, function (available_supplier_id, available_supplier_detail)
				{
					var found_match = false;
					if (typeof(available_supplier_detail)!='undefined')
					{
						$.each(ordered_suppliers_list, function(ordered_supplier_id, ordered_supplier_detail)
						{
							if (typeof(ordered_supplier_detail)!='undefined')
							{
								if (available_supplier_id == ordered_supplier_id) found_match=true;							
							}
						});
					}
					if (!found_match) delete temp_order_list[product_id].available_suppliers[available_supplier_id];
				});
				
				
				//if available supplier list is empty now prompt
				if ((typeof(temp_order_list[product_id].available_suppliers)=='undefined'))
				{
					temp_order_list[product_id].selected_supplier = -1;
					temp_order_list[product_id].selected_price = 0;
					if (!ask_notification("Product "+productname+" will be dropped as no other suppliers are available. Continue?")) return;
				}
				if (temp_order_list[product_id].available_suppliers.length==0)
				{
					temp_order_list[product_id].selected_supplier = -1;
					temp_order_list[product_id].selected_price = 0;
					if (!ask_notification("Product "+productname+" will be dropped as no other suppliers are available. Continue?")) return;
				}
			}
		});
		//if user allows then go ahead and find new suppliers
		$.each(supplier_orders_list[supplier_id].products_list, function(product_id, product_details)
		{
			if (typeof(product_details)!='undefined')
			{
				var productname = product_details.product_data.name;
				//recalculate recommended supplier for this product
				var temp_supplier_pricing = new Array();
				var minimum_price = 10000000;
				var temp_recommended_supplier_id=-1;
				//find the minimum price given the available suppliers
				$.each(temp_order_list[product_id].available_suppliers, function (temp_supplier_id, temp_supplier_details)
				{
					if (typeof(temp_supplier_details)!='undefined')
					{					
						//Create a temp list of supplier ids and prices (with premium adjustment) of available suppliers
						temp_supplier_pricing[temp_supplier_id] = temp_order_list[product_id].pricing_list[temp_supplier_id].price * (1-(temp_order_list[product_id].supplier_settings[temp_supplier_id].premium/100));
						
						if (temp_supplier_pricing[temp_supplier_id]<minimum_price) minimum_price = temp_supplier_pricing[temp_supplier_id];	
					}

				});
				temp_recommended_supplier_id = temp_supplier_pricing.indexOf(minimum_price);
				
				//if product doesnt have a recommended supplier drop products 
				if (temp_recommended_supplier_id!=-1) 
				{
					//copy the product into the new recommended supplier order list
					//supplier_orders_list[temp_recommended_supplier_id].pricing_list[product_id].product_data = $.extend({},supplier_orders_list[supplier_id].products_data[product_id]);
									
					supplier_orders_list[temp_recommended_supplier_id].products_list[product_id]= $.extend({},supplier_orders_list[supplier_id].products_list[product_id]);
					
					
					//recalculate the sum total for the supplier
					supplier_orders_list[temp_recommended_supplier_id].totalvalue = supplier_orders_list[temp_recommended_supplier_id].totalvalue+(parseFloat(supplier_orders_list[temp_recommended_supplier_id].products_list[product_id].price) * parseInt(supplier_orders_list[temp_recommended_supplier_id].products_list[product_id].quantity));
					//See if off invoice applies - TBI
					var minimum_quantity = order_list[product_id].pricing_list[temp_recommended_supplier_id].minimum_quantity;
					var offinvoice = order_list[product_id].pricing_list[temp_recommended_supplier_id].offinvoice;
					var pecentinvoice = order_list[product_id].pricing_list[temp_recommended_supplier_id].percentinvoice;
					var valueinvoice = order_list[product_id].pricing_list[temp_recommended_supplier_id].valueinvoice;
					var product_qty = order_list[product_id].quantity;
					
					if (product_qty>=minimum_quantity)
					{
						if (offinvoice==1)
						{
							if (valueinvoice!=0)
							{
								supplier_orders_list[temp_recommended_supplier_id].products_list[product_id].price = parseFloat(order_list[product_id].pricing_list[temp_recommended_supplier_id].price)  - valueinvoice;
								supplier_orders_list[temp_recommended_supplier_id].products_list[product_id].offinvoice  = valueinvoice;
							}
							else if (percentinvoice!=0)
							{
								supplier_orders_list[temp_recommended_supplier_id].products_list[product_id].price = parseFloat(order_list[product_id].pricing_list[temp_recommended_supplier_id].price)  * (1- (parseFloat(percentinvoice)/100));
								supplier_orders_list[temp_recommended_supplier_id].products_list[product_id].offinvoice  = parseFloat(order_list[product_id].pricing_list[temp_recommended_supplier_id].price)  * (parseFloat(percentinvoice)/100);
							}
						}
						
						supplier_orders_list[temp_recommended_supplier_id].products_list[product_id].rebate = order_list[product_id].pricing_list[temp_recommended_supplier_id].rebate; //TBI
					}
					
					
					//change supplier in order list 
					change_supplier(product_id, temp_recommended_supplier_id);
					
					
				}
			}
		});
		//remove the supplier from the supplier_orders_list
		delete supplier_orders_list[supplier_id];
		//do mov calculations again
		or_recalculate_mov_flag();
		//redraw order review screen
		redraw_order_review();
	}
	else
	{
		alert("You can't deselect the last supplier");
		$("#supplier_"+supplier_id).prop('checked', true);
	}
}

//Bring back changes from Order Review
function return_from_review_order()
{
	//Hide the order review screen
	$("#next_profile_div").hide();
	recalculate_selected_suppliers(); //TBI
	//update back array - TBD
}

//Submits the order for all the suppliers
function or_place_all_orders()
{
	
	//loop for each supplier and place order for only those suppliers which are not placed yet 
	$.each (supplier_orders_list, function (supplier_id, supplier_order_detail)
	{
		if(typeof(supplier_order_detail)!='undefined')
		{
			if (!supplier_order_detail.ordered)
			{
				//Place order for the supplier
				//alert(supplier_id);
				//alert(supplier_orders_list[supplier_id].products_list);
				or_place_order(supplier_id);
			}
		}
	});
}


//Submits the order for the supplier - TBD
function or_place_order(supplier_id)
{
	
	var ik=0;
	var should_place_order=true;
	start_loading();
	//Check if any supplier has MOV flag as Red then return with a notification 
	$.each(supplier_orders_list, function (supplier_ids, supplier_order_detail)
	{
		if (typeof(supplier_order_detail)!='undefined')
		{
			
			if (supplier_order_detail.color==0 && supplier_id==supplier_ids)
			{
				var supplier_name = suppliers_list[supplier_id].name;
				alert("Minimum order value for "+supplier_name+" is not met");
				should_place_order=false;
				end_loading();
				return;
			}
		}
	});
	
	//If date is not set then notify and return 
	if (supplier_orders_list[supplier_id].requested_delivery_date=="" || typeof(supplier_orders_list[supplier_id].requested_delivery_date)=='undefined') 
	{
		alert("Please specify the requested delivery date");
		should_place_order=false;
		end_loading();
		return;		
	}
	
	var final_order_list= [];
	final_order_list[ik]={};
	var final_total_discount = 0;
	var final_saving = 0;
	final_order_list[ik].customer = customerid; //Global value 
	final_order_list[ik].supplier = supplier_id; 
	final_order_list[ik].rqdlt = supplier_orders_list[supplier_id].requested_delivery_date;
	final_order_list[ik].price = supplier_orders_list[supplier_id].totalvalue;
	final_order_list[ik].mov = suppliers_list[supplier_id].mov;
	
	final_order_list[ik].pid = [];
	final_order_list[ik].qty = [];
	final_order_list[ik].idisc = [];
	final_order_list[ik].pris = [];
	final_order_list[ik].rpid = [];
	final_order_list[ik].rebate = [];
	//Loop through each product and prepare JSON to be sent 
	$.each(supplier_orders_list[supplier_id].products_list, function(product_id, product_details) 
	{
		if (typeof(product_details)!='undefined')
		{
			//Find substitutes
			var substitute_products = "";
			$.each(product_details.substitutes, function(substitute_id, substitute_detail) 
			{
				if (typeof(substitute_detail)!='undefined')
					substitute_products = substitute_products + substitute_id + ",";
			});
			substitute_products = substitute_products.substring(0, substitute_products.length-1);
			//Find average price of this procuct 
			var sum_of_product_price = 0;
			var number_prices = 0;
			$.each(products_list[product_id].pricing_list, function (supplier_id, pricing_detail)
			{
				if (typeof(pricing_detail)!='undefined')
				{
					sum_of_product_price = sum_of_product_price + parseFloat(pricing_detail.price);
					number_prices++;
				}
			});
			if (number_prices!=0) 
				var average_product_price = sum_of_product_price / number_prices;
			else 
				var average_product_price = 0;
			var product_qty = supplier_orders_list[supplier_id].products_list[product_id].quantity;
			var product_price = supplier_orders_list[supplier_id].products_list[product_id].price;
			var product_discount = supplier_orders_list[supplier_id].products_list[product_id].discount;
			var product_rebate = supplier_orders_list[supplier_id].products_list[product_id].rebate;
			if (average_product_price>=parseFloat(product_price))
				var product_saving = average_product_price - parseFloat(product_price); 
			else 
				var product_saving = 0;

			final_order_list[ik].pid.push(product_id);
			final_order_list[ik].qty.push(product_qty);
			final_order_list[ik].idisc.push(product_discount);
			final_order_list[ik].pris.push(product_price);
			final_order_list[ik].rpid.push(substitute_products);
			final_order_list[ik].rebate.push(product_rebate);

			final_saving = final_saving + product_saving;
			final_total_discount = final_total_discount + product_discount;
		}
		final_order_list[ik].discount = final_total_discount;
		final_order_list[ik].saving = final_saving;
	});
	
	var json_order = JSON.stringify(final_order_list);
	//alert(json_order);
	
	//show loading - TBD
	if(should_place_order)
	{
		$.ajax({
			type: "POST",
			url: base_url+"place_order_test.php",
			data: {customer:customerid, pro_data:json_order}
		})
		.done(function( msg ){
			//hide loading - end_loading(); - TBD
			//Find order numnber
			//alert(msg);
			end_loading();
			var order_no_json = JSON.parse(msg);
			var order_no = order_no_json[0];
			
			supplier_orders_list[supplier_id].order_no = order_no;
			//Set the ordered flag and order no for the supplier
			supplier_orders_list[supplier_id].ordered = true;
			//Remove ordered products from order_list 
			$.each(supplier_orders_list[supplier_id].products_list, function(product_id, product_details) 
			{
				if (typeof(product_details)!='undefined')
				{
					delete order_list[product_id];
				}
			});	
			redraw_order_review();
			//If all orders are placed now then redirect to Order list
			var unordered_suppliers_count = false;
			$.each(supplier_orders_list, function(supplier_id, supplier_order_details)
			{
				if (typeof(supplier_order_details)!='undefined')
				{
					if (!supplier_order_details.ordered)
						unordered_suppliers_count = true;
				}
			});
			if (!unordered_suppliers_count) 
			{
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
		});
	}
	
	//Ask for redraw
}

function show_global_supplier_settings(){
		if (order_list.length>0)
		{		
			navigator.notification.confirm(
				'This will effect the supplier setting for individual product. Are you sure you want to change this?',  // message
				show_global_supplier_settings_confirm,              // callback to invoke with index of button pressed
				'DBA',            // title
				'No, Yes'          // buttonLabels
			);
		}
		else
		{
			show_global_supplier_settings_confirm(2)
		}
	}

//Open global supplier panel
function show_global_supplier_settings_confirm(button)
{
	var str='';
	//Check if order list is empty 
	if(button==2)
	{
		
		$("#sup_list_view_global").html("");
		//Draw the global supplier settings page 
		//Draw the items on the page as per global settings values 
		$.each(suppliers_list, function (supplier_id, supplier_details)
		{
			if(typeof(supplier_details)!='undefined')
			{
				var supplier_name = supplier_details.name;
				var checked_str = "";
				var premium = 0;
				//Check if this global 
				if (supplier_id in global_supplier_settings) 
				{
					checked_str = " checked ";
					premium = global_supplier_settings[supplier_id].premium;
				}
				//Write the HTML
				str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' id='glob_"+supplier_id+"' "+checked_str+" /></div><div class='ss-supplier-label'>"+supplier_name+"</div><div class='ss-supplier-percentage' ><input type='number' value='"+premium+"' id='gprem"+supplier_id+"' /> %</div></div>";
			}
		});
		str = str + "<div class='ss-supplier'><div class='ss-supplier-selector'><input type='checkbox' id='glob'/></div><div class='ss-supplier-label'></div><div class='ss-supplier-percentage' ><input type='number'  id='gprem' /> %</div></div>";
		
		//Include the HTML into basic frame
		$("#sup_list_view_global").html(str);	
		//TBH
		$("#create_profile_div").hide();
		backArr.push('create_profile_div');	
		TBH = "setng_supplier_global";	
	
		//make things visible
		$('.overlay').fadeIn(100); 
		$('#setng_supplier_global').fadeIn(100);
		//update back array - TBD
	}
}

//Hides the global supplier settings panel
function hide_global_supplier_settings()
{
	//Empty the html 
	$("#sup_list_view_global").html("");
	
	//Hide the modal box 
	$('.overlay').hide(); 
	$('#setng_supplier_global').hide();
	
	//update back array
	onBackKeyDown();
}


//Apply a new global supplier settings
function change_global_supplier_settings()
{
	//Empty the global supplier settings array 
	while (global_supplier_settings.length>0){global_supplier_settings.pop();}
	global_supplier_settings = {};
	//For each supplier - get the check mark, supplierid and premium values
	$.each(suppliers_list, function (supplier_id, supplier_details)
	{
		if(typeof(supplier_details)!='undefined')
		{
			var divname = "glob_"+supplier_id;
			if ($("#"+divname).prop("checked"))
			{
				global_supplier_settings[supplier_id]={};
				global_supplier_settings[supplier_id].name = suppliers_list[supplier_id].name;
				global_supplier_settings[supplier_id].premium = $("#gprem"+supplier_id).val();
			}
		}
	});
	//For each product 
	$.each(order_list, function (product_id, product_details)
	{
		if(typeof(product_details)!='undefined')
		{
			//Empty the supplier settings of the product 
			while (order_list[product_id].supplier_settings.length>0){order_list[product_id].supplier_settings.pop();}
			//copy the global supplier settings into order_list product supplier settings
			order_list[product_id].supplier_settings = $.extend({}, global_supplier_settings);
			//reevaluate the recommeded supplier 
			find_recommended_supplier(product_id);
		}		
	});
	
	
	//Recalculate selected suppliers
	recalculate_selected_suppliers();
	//Hide the global supplier settings modal
	hide_global_supplier_settings();
	//Redraw the order list 
	redraw_order_list();	

}

//Save the order list into order profile on server - TBI
function save_order_profile(profile_id)
{
	//Save flag to check global and personal
	var save_profile_allowed=true;
	
	if (profile_id == -1)
	{
		//Save a new profile
		//Ask for a name 
		var profile_name;
		do 
		{
			profile_name = input_notification("Enter a name for this Order profile");
			if (profile_name==null) return;
		}
		while (profile_name == "");
		//Make a final order profile list 
		var final_order_profile = {};
		var ctr = 0;
		
		$.each(order_list, function (product_id, product_details)
		{
			if (typeof(product_details)!='undefined')
			{
				final_order_profile[ctr]={};
				//Iterate through each product and enter into the datastructure
				final_order_profile[ctr].id = product_id;
				final_order_profile[ctr].qty = product_details.quantity;
				final_order_profile[ctr].moq = "";
				final_order_profile[ctr].ioq = "";
				//Create a string for substitute products 
				var substitute_products = "";
				$.each(product_details.substitutes, function(substitute_id, substitute_detail) 
				{
					if (typeof(substitute_detail)!='undefined')
						substitute_products = substitute_products + substitute_id + ",";
				});
				substitute_products = substitute_products.substring(0, substitute_products.length-1);
				final_order_profile[ctr].subs = substitute_products;
				final_order_profile[ctr].supplier = "";
				final_order_profile[ctr].rebate = "";
				final_order_profile[ctr].price = "";
				final_order_profile[ctr].valoff = "";
				//Create arrays for supplier settings 
				var supplier_ids = [];
				var supplier_premiums = [];
				$.each(product_details.supplier_settings, function(supplier_id, supplier_details)
				{
					if (typeof(supplier_details)!='undefined')
					{
						supplier_ids.push(supplier_id);
						supplier_premiums.push(supplier_details.premium);
					}
				});
				final_order_profile[ctr].prem = supplier_ids;
				final_order_profile[ctr].premv = supplier_premiums;
				ctr++;
			}
		});
		//Connvert to JSON 
		var json_order_profile = JSON.stringify(final_order_profile);
		start_loading();
		//Call JSON API 
		$.ajax({
			type: "POST",
			url: base_url+"profile.php",
			data: {pro_data:json_order_profile, customer:customerid, name:profile_name, id:0}
		})
		.done(function( msg ){
			
			end_loading();
			//alert(msg);
			alert("Profile saved");
			/*var str = "<li onclick='load_order_profile("+msg+")'>"+profile_name+"</li>";
			$("#profile_list").append(str);*/
			//Fetch order profiles again 
			fetch_order_profiles_list_save_as(msg);
			
			//fetch_order_profiles_list();
			//Load the newly saved order profile
			
		});
	}
	else 
	{	
		if(order_profiles_list[profile_id].type=='global')
		{
			alert("Sorry, You can't update the global profile.You can create a new profile with 'SAVE AS ' option.");
			save_profile_allowed=false;
			return false;
		}
		
		//Allowed only if type is personal
		if(save_profile_allowed)
		{
			//Save into old profile_id
			//Make a final order profile list 
			var final_order_profile = {};
			var ctr = 0;
			
			$.each(order_list, function (product_id, product_details)
			{
				if (typeof(product_details)!='undefined')
				{
					final_order_profile[ctr]={};
					//Iterate through each product and enter into the datastructure
					final_order_profile[ctr].id = product_id;
					final_order_profile[ctr].qty = product_details.quantity;
					final_order_profile[ctr].moq = "";
					final_order_profile[ctr].ioq = "";
					//Create a string for substitute products 
					var substitute_products = "";
					$.each(product_details.substitutes, function(substitute_id, substitute_detail) 
					{
						if (typeof(substitute_detail)!='undefined')
							substitute_products = substitute_products + substitute_id + ",";
					});
					substitute_products = substitute_products.substring(0, substitute_products.length-1);
					final_order_profile[ctr].subs = substitute_products;
					final_order_profile[ctr].supplier = "";
					final_order_profile[ctr].rebate = "";
					final_order_profile[ctr].price = "";
					final_order_profile[ctr].valoff = "";
					//Create arrays for supplier settings 
					var supplier_ids = [];
					var supplier_premiums = [];
					$.each(product_details.supplier_settings, function(supplier_id, supplier_details)
					{
						if (typeof(supplier_details)!='undefined')
						{
							supplier_ids.push(supplier_id);
							supplier_premiums.push(supplier_details.premium);
						}
					});
					final_order_profile[ctr].prem = supplier_ids;
					final_order_profile[ctr].premv = supplier_premiums;
					ctr++;
				}
			});
			//Connvert to JSON 
			var json_order_profile = JSON.stringify(final_order_profile);
			start_loading();
			//Call JSON API 
			$.ajax({
				type: "POST",
				url: base_url+"profile.php",
				data: {pro_data:json_order_profile, customer:customerid, name:"", id:profile_id}
			})
			.done(function( msg ){
				end_loading();
				alert("Profile saved");
				/*var str = "<li onclick='load_order_profile("+msg+")'>"+profile_name+"</li>";
				$("#profile_list").append(str);*/
				//Fetch order profiles again 
				fetch_order_profiles_list();
				//Reload the  saved order profile
				load_order_profile(msg);
			});
			
		}
	}
	//Hide the save button
	$('.open-info').hide();
	$('.short li').hide(); 
	$("#profile_list").hide();
	$('.save-save-as span').hide(); 
}

function input_notification(msg)
{
	//var for_email = prompt("Enter profile name: ","");
	return prompt("Enter profile name: ",""); //TBI - TBD - add the navigator options here as well 
}

//Function to fetch all categories and subcategories - TBI
function fetch_categories() 
{
	category_list = {};
	$.ajax({
		type: "POST",
		url: base_url+"get_all_category.php"
	})
	.done(function( msg ){
		//hide loading
		var jsondata = JSON.parse(msg);
		//Loop for each category and create an entry 
		for (var ctr=0;ctr<jsondata.length;ctr++)
		{
			var cat_id = jsondata[ctr].id;
			var cat_name = jsondata[ctr].name;
			category_list[cat_id] = {};
			category_list[cat_id].name = cat_name;
			category_list[cat_id].sub_categories = {};
		}
		//now fetch all subcategories
		$.ajax({
			type: "POST",
			url: base_url+"get_all_subcategory.php"
		})
		.done(function( msg ){
			//hide loading
			var jsondata = JSON.parse(msg);
			for (var ctr=0;ctr<jsondata.length;ctr++)
			{
				var subcat_id = jsondata[ctr].id;
				var subcat_name = jsondata[ctr].name;
				var cat_id = jsondata[ctr].cat_id;
				category_list[cat_id].sub_categories[subcat_id]={};
				category_list[cat_id].sub_categories[subcat_id].name=subcat_name;
			}
			fetch_counter++;
			check_counter();			
		});
	});
}

//TBI
function init_product_filter()
{
	//make the header afresh
	var header_html = "";
	header_html = '<div class="pp-filter-inner"><div class="pp-category-filter">Category<br>'
	+'<select id="filter_category_id" onchange="update_subcategory_filter()"><option value="-1">All</option>';
	$.each(category_list, function (category_id, category_details)
	{
		if (typeof(category_details)!='undefined')
		{
			header_html = header_html +'<option value="'+category_id+'">'+category_details.name+'</option>';
		}

	});
	header_html = header_html +'</select></div>';
	header_html = header_html + '<div class="pp-subcategory-filter">SubCategory<br><select id="filter_subcategory_id">'
				+'<option value="-1">All</option></select></div>';
	header_html = header_html +'<div class="pp-search-filter">Search by<br><input id="pp_searchtxt" type="text" placeholder="keyword" onkeyup="search_filter()">'
	+'</div><div class="pp-buttons-filter"><div class="pp-button" id="pp-filter-button" onclick="apply_product_category_filter()"></div><div class="pp-button" id="pp-clear-button" onclick="reset_product_filter()"></div></div></div>';
	$('#substitute_product_pp').html(header_html);
	$('#add_product_pp').html(header_html);
}
//TBI
function reset_product_filter()
{
	//show all products 
	$(".pp-product").show();
	//reset the dropdowns 
	$('#filter_category_id option:eq(1)').prop('selected', true);
}
//TBI
function update_subcategory_filter()
{
	var category_id = $('#filter_category_id').val();
	//empty out the subcategory dropdown but just put All 
	$('#filter_subcategory_id option[value!="-1"]').remove();
	if (category_id!=-1)
	{
		//fill subcategory dropdown with only relevant subcategories
		$.each(category_list[category_id].sub_categories, function (subcategory_id, subcategory_details)
		{
			if (typeof(subcategory_details)!='undefined')
			{
				$('#filter_subcategory_id').append('<option value="'+subcategory_id+'">'+subcategory_details.name+'</option>');
			}
		});
	}
}
//TBI
function apply_product_category_filter()
{
	var category_id = $('#filter_category_id').val();
	var subcategory_id = $('#filter_subcategory_id').val();
	//hide all products - TBD
	$(".pp-product").hide();

	
	//show products of the category selected
	if (category_id==-1)
		$(".pp-product").show();
	else
	{
		if (subcategory_id==-1) 
			$( ".pp-product [category="+category_id+"]").show();
		else 
		{
			$(".pp-product").show();
			$( ".pp-product [subcategory!="+subcategory_id+"]").hide();
		}
	}
	$(".pp-product-selector").show();
	$(".product_picker_check").show();
	$(".pp-product-image").show();
	$(".pp-productimage").show();
	$(".pp-product-description").show();
	$(".pp-product-label").show();
	$(".pp-product-description").show();
}

//function to show a popup - TBI
function show_popup(title, message)
{
	var html_str = '<img src="images/cross.png" onclick="hide_tolip()"><h1>'+title+'</h1>'+message;
	$("#tooltip").html(html_str);
	$('.overlay').show();
	$("#tooltip").toggle();
}

//function to hide the popup - TBI
function hide_popup()
{
	$('.overlay').hide();
	$("#tooltip").toggle();
}

//Creates an onscreen notification 
function notification(msg)
{
	alert(msg); //TBD - add the navigator options here as well 
}
function tocurrency(n)
{
	n=parseFloat(n);
	if(isNaN(n)) return '0.00';
	return n.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}
function tocurrency_int(n)
{
	if(isNaN(n)) return '0.00';
	return n.toFixed(0).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}
//Creates an onscreen ask notification
function ask_notification(msg)
{
	return confirm(msg); //TBD - add the navigator options here as well 
}