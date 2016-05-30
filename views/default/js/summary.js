$(document).ready(function(e) {
	//высталение rowspan и установка высоты строки клиента в первой таблицы
    $(".content .clients tbody tr:nth-child(5n + 1)").each(function(index, element) {
        $(this).children("td:eq(0)").attr("rowspan", 5);
    });
	
	$(document).on("click", function(e){
		if ($(e.target).closest(".hidden-list").length) return;
		
		$(".hidden-list").hide(300);
		e.stopPropagation();
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
				calc();
			},
			error: function(){
				alert("Не удалось изменить часы");
			}
		});
	});
	
	$(".workers").on("click", "img:not([set]):not([del])", function(){
		var parent = $(this).parent("td").parent("tr");
		var c_id = parent.attr("data-id"), dep_id = parent.attr("dep-id"), worker_id = parent.attr("worker-id"), p_id = parent.index();
		
		parent.removeAttr("last").children("td:eq(0)").children("img:not([set]):not([del])").remove();
		
		parent.after("<tr last data-id='"+c_id+"'><td style='height: 21px'><img set src='views/default/img/settings.png' /><img set='' title='Назначить исполнителя' src='views/default/img/settings.png'><img src='views/default/img/add.png' /></td><td><input size='4' disabled='disabled' type='text' name='days_count' /></td><td></td><td><input disabled='disabled' type='text' size='4' name='plan_h' /></td><td></td><td></td></tr>");
		$(".months tbody tr:eq("+p_id+")").after($(".months tbody tr:eq("+p_id+")").clone()).removeAttr("last");
		$(".months tbody tr:eq("+(p_id+1)+") td > input").val("").parent("td").parent("tr").removeAttr("dep-id").removeAttr("worker-id");
		
		resize_content();
	});
	
	var focus_tr;
	
	$(".workers").on("click", "img[set]", function(){
		var tr = $(this).parent("td").parent("tr"), id = "", dat, obj = $(this);
		focus_tr = tr;
		console.log(tr.attr('sum-id'));
		$(".workers tbody tr[sum-id="+tr.attr('sum-id')+"]").each(function(index, element) {
            if ($(this).attr("worker-id")){
				id += $(this).attr("worker-id")+",";
			}
        });
		
		if (!id == "")
			id = id.substr(0, id.length-1);
			console.log(id);
		$.ajax({
			url: "./?do=get_workers&view=worker",
			type: "POST",
			data: "ids="+id,
			success: function(data){
				console.log(data);
				dat = $.parseJSON(data);
				$(".hidden-list").show(300);
				$(".hidden-list").css({left:   obj.offset().left-5-$(window).scrollLeft()+"px", top: obj.offset().top+18-$(window).scrollTop()+"px"});
				
				$(".hidden-list").html('');
				
				$.each(dat, function(i, e){
					var d;
					$.ajax({
						url: "./?view=dep&do=get_colors",
						type: "POST",
						data: "id="+e.departament,
						success: function(data){
							//console.log(data);
							d = $.parseJSON(data);
							$(".hidden-list").append("<li dep-id='"+e.departament+"' worker-id='"+e.id+"' style='color: "+d.text_color+"; background: "+d.color+"'>"+d.name+" ("+e.name+")</li>");
						}
					});
				});
			},
			error: function(){
				alert("Не удалось получить список асполнителей");
			}
		});
	});
	
	$(".hidden-list").on("click", "li", function(){
		var data = "summ_id="+focus_tr.attr("sum-id")+"&worker_id="+$(this).attr("worker-id"), obj =  $(this);
		
		$.ajax({
			url: "./?view=summary&do=add_info",
			type: "POST",
			data: data,
			success: function(data){
				console.log(data);
				focus_tr.children("td:eq(0)").attr("style", obj.attr("style")).html(obj.html()).parent("tr").attr("dep-id", obj.attr("dep-id")).attr("worker-id", obj.attr("worker-id"));
				$(".hidden-list").css({display: "none"});
				focus_tr.children("td").children("input").prop("disabled", false);
				resize_content();
			},
			error: function(){
				alert("Не удалось добавить исполнителя");
			}
		});
	});
	
	$
	
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
	
	$(".clients").on("click", "img[archive]", function(){
		var tr = $(this).parent("td").parent("tr");
		var data = "id="+tr.attr("data-id");
		console.log(data);
		$.ajax({
			url: "./?view=summary&do=go_to_archive",
			type: "POST",
			data: data,
			success: function(data){
				console.log(data);
				if (data == 1){
					$(".workers tr[sum-id="+tr.attr("sum-id")+"]").css({display: "none"});
					$(".months tr[sum-id="+tr.attr("sum-id")+"]").css({display: "none"});
				}
			},
			error: function(){
				alert("Не удалось переместить клиента в архив");
			}
		});
	});
	
	$(".workers").on("click", "img[del]", function(){
		var tr = $(this).parent("td").parent("tr"), obj = $(this);
		
		var data = "id="+tr.attr("sum-id")+"&worker_id="+tr.attr("worker-id");
		
		$("#modal").modal("show");
		$("#modal .btn-primary").click(function(){
			$.ajax({
				url: "./?view=summary&do=delete_info",
				type: "POST",
				data: data,
				success: function(data){
					console.log(data);
					if (data == 1){
						$("#modal").modal("hide");
						obj.after('<img set="" title="Назначить исполнителя" src="views/default/img/settings.png">').remove();
						tr.children("td:not(:eq(1)):not(:eq(2))").html("").removeAttr("style").removeClass("lost");
						obj.parent("td").removeAttr("style").css({height: "21px"}).html("");
						obj.children("td").children("input").prop("disabled", true).val("");
					}
				},
				error: function(){
					$("#modal").modal("hide");
					alert("Не удалось удалить исполнителя");
				}
			});
		});
	});
});

//Функция для синхронизации размеров таблиц
function resize_content(){
	$(".content .clients tbody tr:nth-child(5n + 1)").each(function(index, element) {
        $(this).children("td:eq(0)").css({height: ($(".content .workers tbody tr[data-id="+$(this).attr("data-id")+"]").height())*$(".content .workers tbody tr[data-id="+$(this).attr("data-id")+"]").length+"px"});
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