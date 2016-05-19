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
});