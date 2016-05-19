$(document).ready(function(e) {
	//высталение rowspan и установка высоты строки клиента в первой таблицы
    $(".content .clients tbody tr:nth-child(5n + 1)").each(function(index, element) {
        $(this).children("td:eq(0)").attr("rowspan", 5);
    });
	
	$(".content .clients tbody tr:nth-child(5n + 1)").each(function(index, element) {
        $(this).children("td:eq(0)").css({height: $(".content .workers tbody tr[data-id="+$(this).attr("data-id")+"]").height()*$(".content .workers tbody tr[data-id="+$(this).attr("data-id")+"]").length+"px"});
    });
	
	$(".content .months tbody tr").each(function(index, element) {
        $(this).children("td").css({height: $(".content .workers tbody tr:eq("+index+")").height()+"px"});
    });
	
	$(".content .clients").on("change", "input[type=date]", function(){
		var data = "id="+$(this).parent("td").parent("tr").parent("tbody").children("tr:eq(0)").attr("data-id"), url = "view=summary";
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
			onerror:function(){
				alert("Не удалось изменить дату");
			}
		});
	});
	
	$(".content .clients").on("change", "input[name=hours]", function(){
		var data = "id="+$(this).parent("td").parent("tr").parent("tbody").children("tr:eq(0)").attr("data-id")+"&hours="+$(this).val();
		
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
});