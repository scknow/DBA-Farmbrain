function catlog_loading(){
	
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"get_category.php",
		data: {}
	})
	.done(function(msg){
		end_loading();
		var cat_str = "";
		var str = "<option value=''>ALL</option>";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			var img_paht = "";
			if(row.productcategorypic=='a' || row.productcategorypic==""){
				img_paht = "images/a.png";
			}else{
				img_paht = base_url2+"upload/"+row.productcategorypic;
			}
			str = str + "<option value='"+row.productcategoryid+"'>"+row.productcategoryname+"</option>";
			
			//cat_str = cat_str + "<li onclick='li_cat("+row.productcategoryid+")' ><div class='category_dba_left'><img src='"+img_paht+"' /></div><div class='category_dba_right'><p>"+row.productcategoryname+"</p></div></li>";
			
		}
		
		get_sub_cat_get();
		$("#catlog_category").html(str);
		//$("#ul_cat_gory").html(cat_str);
	});
	$.ajax({
		type: "GET",
		url: base_url+"get_manufact.php",
		data: {}
	})
	.done(function(msg){
		var str = "<option value=''>ALL</option>";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			str = str + "<option value='"+row.manufid+"'>"+row.manufname+"</option>";
		}
		$("#catlog_manufact").html(str);
	});
	$.ajax({
		type: "GET",
		url: base_url+"get_subcat.php",
		data: {cid:""}
	})
	.done(function(msg){
		var str = "<option value=''>ALL</option>";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			str = str + "<option value='"+row.productsubcategoryid+"'>"+row.productsubcategoryname+"</option>";
		}
		$("#catlog_subcat").html(str);
	});
}
function get_sub_cat_get()
{
	$.ajax({
		type: "POST",
		url: base_url+"get_category_sub_images.php",
		data: {}
	}).done(function(msg)
	{		
		var jsn = JSON.parse(msg);
		var cat_str='';
		for(i=0;i<jsn.length;i++)
		{
			var row = jsn[i];
			var cat_id=row.productcategoryid;
			cat_str=cat_str+'<li><big onclick=toggle_sub("name'+i+'")>'+row.productcategoryname+'</big><div class="category_dba_left"><ul id="name'+i+'" style="display:none;">';
			
			for(var ik=0;ik<row.sub_id.length;ik++)
			{
				if(row.pic[ik]!='a')
				{
					var img_paht = base_url2+"upload/"+row.pic[ik];
				}
				else
				{
					var img_paht = 'images/a.png';
				}
				
				cat_str=cat_str+'<li onclick="li_cat('+cat_id+','+row.sub_id[ik]+')"><div class="category_dba_left_img" style="background:url('+img_paht+')"><img src="images/1.jpg" /></div><i>'+row.cat_name[ik]+'</i></li>';
			}
			cat_str=cat_str+'<li onclick="li_cat('+cat_id+',-1)"><div class="category_dba_left_img"><img src="images/1.jpg" /></div><i>All</i></li>';
			cat_str=cat_str+"</ul>";			
		}
		
		$("#ul_cat_gory").html(cat_str);
	});
}
function toggle_sub(id)
{
	$("#"+id).toggle();
}

function li_cat(cat_id,subcat_id)
{
	$("#catlog_category").val(cat_id);
	menu_item('catalog_div_next');
	$("#catlog_subcat").val(subcat_id);
	catlog_subcat(subcat_id);	
}

function catlog_subcat(subcat_id){
	var id = $("#catlog_category").val();
	start_loading();
	$.ajax({
		type: "GET",
		url: base_url+"get_subcat.php",
		data: {cid:id}
	})
	.done(function(msg){
		end_loading();
		var str = "<option value=''>ALL</option>";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			str = str + "<option value='"+row.productsubcategoryid+"'>"+row.productsubcategoryname+"</option>";
		}
		$("#catlog_subcat").html(str);
		if(subcat_id!=-1)
		{
			$("#catlog_subcat").val(subcat_id);
		}
		else
		{
			$("#catlog_subcat").val('');
		}
		catlog();
	});
}

function catlog_brand(){
	var id = $("#catlog_manufact").val();
	start_loading();
	$.ajax({
		type: "GET",
		url: base_url+"get_brand.php",
		data: {mid:id}
	})
	.done(function(msg){
		end_loading();
		var str = "<option value=''>ALL</option>";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			str = str + "<option value='"+row.brandid+"'>"+row.brandname+"</option>";
		}
		$("#catlog_brand").html(str);
		catlog();
	});
}

function catlog(){
	var cid = $("#catlog_category").val();
	var sid = $("#catlog_subcat").val();
	var mid = $("#catlog_manufact").val();
	var bid = $("#catlog_brand").val();
	
	start_loading();
	$.ajax({
		type: "GET",
		url: base_url+"get_product.php",
		data: {cat:cid, sub:sid, manu:mid, brand:bid}
	})
	.done(function(msg){
		end_loading();
		//alert(msg);
		var str = "";
		var jsn = JSON.parse(msg);
		for(i=0;i<jsn.length;i++){
			var row = jsn[i];
			var img_paht = "";
			if(row.picture1=='a' || row.picture1==""){
				img_paht = "images/a.png";
			}else{
				img_paht = base_url2+"upload/"+row.picture1;
			}
			str = str + "<li class='contain_tr_catlog' onclick='show_cat_des("+row.productid+")'><div class='img-catalog'><img src='"+img_paht+"' /></div><div class='desc-catalog'><b>"+row.productlabel+"</b><i><span>"+row.cat_name+"</span>/ <span>"+row.sub_cat_name+"</span>/<span>"+row.manuf_name+"</span>/ <span>"+row.brand_name+"</span></i></div><div class='info-catalog contain_tr_catlog_hide' id='cat_des"+row.productid+"' ><div class='catalog-desc'><p>"+row.productdescription+"</p><p>Case-Qty: "+row.casequantity+"</p><p>Case-wt: "+row.caseweight+"</p></div>";
			
			var att_obj = row.attribute;
			if(att_obj!=null){
				str = str+ "<div class='catalog-attr'><big><u><span>"+att_obj.type+"</span></u><a href='"+base_url2+"upload/"+att_obj.file_path+"'></a></big></div></div></li>";
			}else{
				str = str+ "</div></li>";
			}
		}
		$("#catalog_div").html(str);
	});
}

function show_cat_des(id){
	$("#cat_des"+id).toggle();
}

function share_app(){
	//alert();
	window.plugins.socialsharing.share('Join DBA. Click here to register.http://antloc.com/dba/admin/login.php ', 'Join the DBA ecosytem')
}