$(document).ready(function(e) {
	//высталение rowspan и установка высоты строки клиента в первой таблицы
    $(".content .clients tbody tr:nth-child(5n + 1)").each(function(index, element) {
        $(this).children("td:eq(0)").attr("rowspan", 5);
    });
	
	resize_content();
	
	$(".content .clients").on("change", "input[type=date]", function(){
		var data = "id="+$(this).parent("td").parent("tr").attr("sum-id"), url = "view=summary";
		switch ($(this).attr("date")){
			case "begin":
				data += "&begin_date="+$(this).val();
				url += "&do=write_b_date";
			break;
			
			case "end":
				data += "&end_date="+$(this).val();
				url += "&do=write_e_date";
			break;
		}
		
		$.ajax({
			url: "./?"+url,
			type: "POST",
			data: data,
			success: function(data){
				console.log(data);
				if (data == 0){
					alert("Не удалось изменить дату");
				}
			},
			error:function(){
				alert("Не удалось изменить дату");
			}
		});
	});
	
	$(".content .clients").on("change", "input[name=hours]", function(){
		var data = "id="+$(this).parent("td").parent("tr").attr("sum-id")+"&hours="+$(this).val();
		console.log(data);
		$.ajax({
			url: "./?view=summary&do=write_hours",
			type: "POST",
			data: data,
			success: function(data){
				console.log(data);
				if (data == 0){
					alert("Не удалось изменить часы");
				}
			},
			error: function(){
				alert("Не удалось изменить часы");
			}
		});
	});
	
	$(".workers").on("click", "img", function(){
		var parent = $(this).parent("td").parent("tr");
		var c_id = parent.attr("data-id"), dep_id = parent.attr("dep-id"), worker_id = parent.attr("worker-id"), p_id = parent.index();
		
		parent.removeAttr("last").children("td:eq(0)").children("img").remove();
		
		parent.after("<tr last data-id='"+c_id+"'><td style='height: 21px'><img src='views/default/img/add.png' /></td><td><input size='4' disabled='disabled' type='text' name='days_count' /></td><td></td><td><input disabled='disabled' type='text' size='4' name='plan_h' /></td><td></td><td></td></tr>");
		$(".months tbody tr:eq("+p_id+")").after($(".months tbody tr:eq("+p_id+")").clone()).removeAttr("last");
		$(".months tbody tr:eq("+(p_id+1)+") td > input").val("").parent("td").parent("tr").removeAttr("dep-id").removeAttr("worker-id");
		
		resize_content();
	});
	
	calc();
	
	$(".workers").on("change", "input[name=plan_h]", function(){
		var tr = $(this).parent("td").parent("tr"), summ_h = 0, substract = 0;
		
		$(".workers tr[data-id="+tr.attr("data-id")+"]:not([key="+tr.attr("key")+"]) input[name=plan_h]").each(function(index, element) {
            summ_h += +$(this).val();
        });
		
		substract = +$(".clients tr[sum-id="+tr.attr("sum-id")+"]:eq(1) input[name=hours]").val() - summ_h;
		
		if (+$(this).val() > substract){
			$(this).val(substract);
		}
		
		var data = "sum_id="+tr.attr("sum-id")+"&worker_id="+tr.attr("worker-id")+"&value="+$(this).val();
		
		$.ajax({
			url: "./?view=summary&do=write_plan_h",
			type: "POST",
			data: data,
			success: function(data){
				console.log(data);
				if (data == 1)
					calc();
			},
			error: function(){
				alert("Не удалось изменить фактические часы");
			}
		});
	});
	
	$(".workers tbody tr").on("change", "input[name=days_count]", function(){
		var tr = $(this).parent("td").parent("tr"), value = +$(this).val(), offset = 0;
		console.log(123);
		$(".workers tbody tr[sum-id="+tr.attr("sum-id")+"]:not([key="+tr.attr("key")+"]) input[name=days_count]").each(function(index, element) {
			if (+$(this).parent("td").parent("tr").attr("key") < +tr.attr("key")){
				var x = parseInt($(this).val());
			if (x)
            	offset += x;
			}
        });
		
		console.log(value);
		
		var data = "sum_id="+tr.attr("sum-id")+"&worker_id="+tr.attr("worker-id")+"&offset="+offset+
		"&value="+value+"&date="+$(".clients tr[sum-id="+tr.attr("sum-id")+"]:eq(4) td:eq(0) > input").val();
		
		$.ajax({
			url: "./?view=summary&do=write_days",
			type: "POST",
			data: data,
			success: function(data){
				console.log(data);
				
				tr.children("td:eq(2)").html(data);
			},
			error: function(){
				alert("Не удалось изменить количество дней!");
			}
		});
		
	});
});

function resize_content(){
	$(".content .clients tbody tr:nth-child(5n + 1)").each(function(index, element) {
        $(this).children("td:eq(0)").css({height: -1+($(".content .workers tbody tr[data-id="+$(this).attr("data-id")+"]").height())*$(".content .workers tbody tr[data-id="+$(this).attr("data-id")+"]").length+"px"});
    });
	
	$(".content .months tbody tr").each(function(index, element) {
        $(this).children("td").css({height: $(".content .workers tbody tr:eq("+index+")").height()+"px"});
    });
}

function calc(){
	//производит расчеты
	$(".clients tbody tr[data-id]").each(function(i, e) {
        var summ = 0, parent = $(this), res = 0;
		
		$(".months tbody tr[data-id="+parent.attr("data-id")+"]").each(function(ind, ele) {
            var sum = 0, result = 0;
			
			$(this).children("td").each(function(inde, el) {
                sum += +$(this).children("input").val();
            });
			
			$(".workers tbody tr:eq("+$(this).index()+") td:eq(4)").html(sum);
			
			result = +$(".workers tbody tr:eq("+$(this).index()+") td:eq(3)").children("input").val()-sum;
			
			$(".workers tbody tr:eq("+$(this).index()+") td:eq(5)").html(result);
			
			if (result < 0)
				$(".workers tbody tr:eq("+$(this).index()+") td:eq(5)").addClass("lost");
			
			summ += sum;
        });
		
		res = +parent.next("tr").children("td:eq(0)").children("input").val()-summ;
		
	 	parent.next("tr").children("td:eq(1)").html(res);
		
		if (res < 0)
			parent.next("tr").next("tr").children("td:eq(1)").html(parseInt((-1*res)/+parent.next("tr").children("td:eq(0)").children("input").val()*100)+"%").addClass("lost");
    });
}