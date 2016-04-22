$(document).ready(function(e) {
	
	//скрывает нерабочие дни
	$("tr[work_day=0]").css({display: "none"});
	
	var text, time;
	
	$(".td > textarea").hover(function(){
		$(this).parent("td").attr("delay", 1);
	}, function(){
		var obj = $(this).parent("td");
		
		obj.attr("delay", 0);
	});
	
    $(".td").hover(function(){
			
			text = $(this).children("textarea").val();
			
			$(this).children("textarea").css({display: "block"});
			
		}, function(){
			var obj = $(this);
			setTimeout(function(){
				if (obj.attr("delay") == 0)
					obj.children("textarea").css({display: "none"});
			}, 1000);
			
			if (text != $(this).children("textarea").val()){
				var data = "description="+$(this).children("textarea").val()+"&id="+$(this).attr("work-id");
				$.ajax({
					url: "./?view=mainTable&do=write_desc",
					type: "POST",
					data: data,
					success: function(data){
						if (data == 0)
							alert("Не удалось изменить текстовое поле.");
					}
				});
			}			
		}
	);
	
	$(".td").next("td > input").children("input").on("focusin", function(){
		time = $(this).val();
	});
	
	$(".td").next("td").children("input").on("focusout", function(){
		if (time != $(this).val()){
			var data = "time="+$(this).val()+"&id="+$(this).attr("work-id");
			$.ajax({
					url: "./?view=mainTable&do=write_time",
					type: "POST",
					data: data,
					success: function(data){
						if (data == 0)
							alert("Не удалось изменить время.");
					}
				});
		}
	});
	
	
	
});