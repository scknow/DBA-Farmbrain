function report1(values,id,add_class,remove_class)
{
	$("#"+remove_class).removeClass();
	$("#"+add_class).addClass("a-active");
	
	$("#"+id).val(values);
	var frm = $("#bar_from").val();
	var qta = $("#bar_customer").val();
	
start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"monthly_report.php",
		data: {customer:customerid, from:frm, aq:qta}
	})
	.done(function(msg){
		//alert(msg);
		end_loading();
		var jsn = JSON.parse(msg);
		
		var last_cat = new Array();
		var last_qty = new Array();
		
		var last_kty = jsn.last_month.product_qty;
		var last_kat = jsn.last_month.category_name;
		//alert()
		
		for(i=0;i<last_kat.length;i++){
			var index = last_cat.indexOf(last_kat[i]);
			if(index==-1){
				last_cat.push(last_kat[i]);
				last_qty.push(last_kty[i]);
			}else{
				last_qty[index] = parseInt(last_qty[index])+parseInt(last_kty[i]);
			}
		}
		
		var cur_cat = new Array();
		var cur_qty = new Array();
		
		var cur_kty = jsn.current_month.product_qty;
		var cur_kat  = jsn.current_month.category_name;
		
		for(i=0;i<cur_kat.length;i++){
			var index = cur_cat.indexOf(cur_kat[i]);
			if(index==-1){
				cur_cat.push(cur_kat[i]);
				cur_qty.push(cur_kty[i]);
			}else{
				cur_qty[index] = cur_qty[index]+cur_kty[i];
			}
		}
		
		for(i=0;i<cur_cat.length;i++){
			var index = last_cat.indexOf(cur_cat[i]);
			if(index==-1){
				last_cat.push(cur_cat[i]);
				last_qty.push(0);
			}
		}
		
		for(i=0;i<last_cat.length;i++){
			var index = cur_cat.indexOf(last_cat[i]);
			if(index==-1){
				cur_qty.splice(i, 0, 0);
			}
		}
		//drawChart();
		/*var barChartData = {
			labels : last_cat,
			datasets : [
				{
					fillColor : "rgba(151,187,205,1)",
					strokeColor : "rgba(151,187,205,1)",
					data : last_qty
				},
				{
					fillColor : "rgba(200,0,70,1)",
					strokeColor : "rgba(250,0,100,1)",
					data : cur_qty
				},
			]
		};

		var myLine = new Chart(document.getElementById("bar").getContext("2d")).Bar(barChartData);*/
		
		var fin = new Array();
		var temp =  ['Year', 'Last Month', 'Current Month'];
		fin.push(temp);
		
		for(i=0;i<last_cat.length;i++){
			var temp1 = new Array();
			temp1.push(last_cat[i]);
			temp1.push(parseInt(last_qty[i]));
			temp1.push(parseInt(cur_qty[i]));
			fin.push(temp1);
		}
		var vt = "Qty"
		if(qta==0){
			vt = "Qty";
		}else{
			vt = "Amount";
		}
		
		var options = {
			title: 'Performance',
			hAxis: {title: 'Category', titleTextStyle: {color: 'red'}},
			vAxis: {title: vt, titleTextStyle: {color: 'blue'}}
		};
		var data = google.visualization.arrayToDataTable(fin);

		var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

		chart.draw(data, options);
	});
}

function toggle_pie(values,remove_class,add_class)
{
	$("#"+remove_class).removeClass();
	$("#"+add_class).addClass("a-active");
	$("#pie_customer").val(values);
	report2();	
}

function report2()
{
var frm = $("#pie_from").val();
var bt = $("#pie_to").val();
var qta = $("#pie_customer").val();



start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"monthly_report.php",
		data: {customer:customerid, from:frm, to: bt, aq:qta}
	})
	.done(function(msg){
		//alert(msg);
		end_loading();
		var jsn = JSON.parse(msg);
		
		var last_cat = new Array();
		var last_qty = new Array();
		
		var last_kty = jsn.last_month.product_qty;
		var last_kat = jsn.last_month.category_name;
		//alert()
		
		for(i=0;i<last_kat.length;i++){
			var index = last_cat.indexOf(last_kat[i]);
			if(index==-1){
				last_cat.push(last_kat[i]);
				last_qty.push(last_kty[i]);
			}else{
				last_qty[index] = parseInt(last_qty[index])+parseInt(last_kty[i]);
			}
		}
		
		var cur_cat = new Array();
		var cur_qty = new Array();
		
		var cur_kty = jsn.current_month.product_qty;
		var cur_kat  = jsn.current_month.category_name;
		
		for(i=0;i<cur_kat.length;i++){
			var index = cur_cat.indexOf(cur_kat[i]);
			if(index==-1){
				cur_cat.push(cur_kat[i]);
				cur_qty.push(cur_kty[i]);
			}else{
				cur_qty[index] = cur_qty[index]+cur_kty[i];
			}
		}
		
		for(i=0;i<cur_cat.length;i++){
			var index = last_cat.indexOf(cur_cat[i]);
			if(index==-1){
				last_cat.push(cur_cat[i]);
				last_qty.push(0);
			}
		}
		
		for(i=0;i<last_cat.length;i++){
			var index = cur_cat.indexOf(last_cat[i]);
			if(index==-1){
				cur_qty.splice(i, 0, 0);
			}
		}
		
		/*var pieData2 = new Array();
		var pieData = new Array();
		var color = ["#F31040","#038630","#a38630","#135630","#738630","#c38630","#030630","#93a630"]
		for(i=0;i<last_cat.length;i++){
		//alert(last_cat[i]);
			var data = {
				value: last_qty[i],
				color:color[i],
				label : last_cat[i],
				labelColor : 'black',
				labelFontSize : '16'
			}
			pieData2.push(data);
			
			var data1 = {
				value: cur_qty[i],
				color:color[i],
				label : last_cat[i],
				labelColor : 'black',
				labelFontSize : '16'
			}
			pieData.push(data1);
		}
		
		console.log(pieData);

	var myPie = new Chart(document.getElementById("piec").getContext("2d")).Pie(pieData2);
	//var myPie2 = new Chart(document.getElementById("piec").getContext("2d")).Pie(pieData);*/
	
	var fin = new Array();
	var temp = ['Category', 'Quantity'];
	fin.push(temp);
	
	var fin2 = new Array();
	temp = ['Category', 'Quantity'];
	fin2.push(temp);
	
	for(i=0;i<last_cat.length;i++){
		var temp1 = new Array();
		var temp2 = new Array();
		temp1.push(last_cat[i]);
		temp1.push(parseInt(last_qty[i]));
		temp2.push(last_cat[i]);
		temp2.push(parseInt(cur_qty[i]));
		fin.push(temp1);
		fin2.push(temp2);
	}
	
	 var data = google.visualization.arrayToDataTable(fin);

        var options = {
          title: 'Last Month Report'
		};
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
		var options = 
		{
          title: 'This Month Report'
        };
	var data1 = google.visualization.arrayToDataTable(fin2);
		var chart1 = new google.visualization.PieChart(document.getElementById('piechart2'));

        chart1.draw(data1, options);
	
	});
}



function drawSeriesChart(values,id,add_class,remove_class) 
{
	$("#"+remove_class).removeClass();
	$("#"+add_class).addClass("a-active");	
	$("#"+id).val(values);
	
	var cust = $("#buble_customer").val();
	if(cust==0){
		cust = customerid;
	}else{
		cust = -1;
	}
	
	//alert(cust);
	var bf = $("#buble_from").val();
	start_loading();
	$.ajax({
		type: "POST",
		url: base_url+"supplier_performance.php",
		data: {customer:cust, from:bf}
	})
	.done(function(msg){
		//alert(msg);
		var fin = new Array();
		var temp = new Array();
		var temp1 = ['ID', 'Complete Delivery(in %)', 'On time delivery(in %)','Total order','total amount spend(in $)'];
		fin.push(temp1);
		var jsn = JSON.parse(msg);
		
		var supplier = jsn.supplier_id;
		var cd = jsn.complete_delievry;
		var otd = jsn.ontime_deleviry_percentage;
		var sts = jsn.supplier_total_spend;
		
		var sto = jsn.supplier_total;
		
		for(i=0;i<supplier.length;i++){
			var temp2 = new Array();
			var str = ""+supplier[i];
			var indx = s_index.indexOf(str);
			if(indx!=-1){
				temp2.push(sup_obj[indx].businessname);
			}else{
				tempnbs2.push("S");
			}
			str = "a"+i;
			temp2.push(cd[i]);						
			temp2.push(otd[i]);
			
			/* if(indx!=-1){
				temp2.push(sup_obj[indx].businessname);
			}else{
				temp2.push("S");
			} */
			temp2.push(sto[i]);
			temp2.push(sts[i]);
			fin.push(temp2);
		}
			
		  var data = google.visualization.arrayToDataTable(fin);

		  var options = {
			
			hAxis: {title: 'Complete Delivery(in %)'},
			vAxis: {title: 'On time delivery(in %)'},
			bubble: {textStyle:{fontSize: 11}}
		  };
		

		  var chart = new google.visualization.BubbleChart(document.getElementById('series_chart_div'));
		  chart.draw(data, options);
			end_loading();
	});
}