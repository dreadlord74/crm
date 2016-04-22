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
	
	$(".td").click(function(){
		
		var parent = this;
		
		$(this).children("textarea").css({display: "none"});
		
		$(this).children("input").prop("disabled", false);
		
		$(this).children("input").on("keypress", function(){
			var text = $(this).val(), obj = this;
			
			$(".hidden").addClass("show-list").css({top: ($(this).offset().top+$(this).height()+4)+"px", left: $(this).offset().left+"px"});
			
			$.ajax({
				url: "./?view=client&do=get_clients",
				type: "POST",
				data: "search="+text,
				success: function(data){
					data = $.parseJSON(data);
					
					$(".enter").html("");
					
					$.each(data, function(i, el){
						$(".enter").prepend(
						"<li client-id='"+el.id+"'>"+
							"<input type='hidden' name='' value='"+el.name+"' />"+
							"<input type='hidden' name='' value='"+el.work_type+"' />"+
							"<input type='hidden' name='' value='"+el.way+"' />"+
							"<input type='hidden' name='' value='"+el.contract_number+"' />"+
							"<input type='hidden' name='' value='"+el.color+"' />"+
							"<input type='hidden' name='' value='"+el.text_color+"' />"+
							el.name+" ("+el.way+") "+el.work_type+" - "+el.contract_number+
						"</li>"
						);
						$(".enter li[client-id="+el.id+"]").click(function(){
	
							$.ajax({
								url: "./?do=add_work",
								type: "POST",
								data: "date_id="+$(obj).parent(".td").parent("tr").attr("date-id")+"&dep_id="+$(obj).parent(".td").attr("otdel")+
								"&client_id="+el.id+"&worker_id="+$(obj).parent(".td").attr("rab"),
								success: function(data){
									console.log(data);
									if (data != 0){
										$(obj).css({color: el.text_color}).val(el.name+" ("+el.way+") "+el.work_type+" - "+el.contract_number);
										$(obj).parent(".td").attr("work", el.id).attr("work-id", data).css({background: el.color}).next("td").css({color: el.text_color, background: el.color}).children("input").attr("placeholder","0").prop("disabled", false).attr("work-id", data);
										
										$(obj).parent(".td").append("<textarea class='hidden-text' name='description'></textarea>");
										
										$(obj).parent(".td").children("textarea").hover(function(){
											$(this).parent("td").attr("delay", 1);
										}, function(){
											var obj = $(this).parent("td");
											
											obj.attr("delay", 0);
										});
										
										$(obj).parent(".td").hover(function(){
			
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
										
										$(obj).parent(".td").next("td").children("input").on("focusin", function(){
											time = $(this).val();
											//console.log("навел");
										});
									
										$(obj).parent(".td").next("td").children("input").on("focusout", function(){
											//console.log("увел");
											if (time != $(this).val()){
												var data = "time="+$(this).val()+"&id="+$(this).attr("work-id");
												$.ajax({
														url: "./?do=write_time",
														type: "POST",
														data: data,
														success: function(data){
															console.log(data);
															if (data === 0)
																alert("Не удалось изменить время.");
														}
													});
											}
										});
										
										$(obj).prop("disabled", true);
										
										$(".hidden").removeClass("show-list");
									}else
										alert("Не добавлено");
								}
							});
						});
					});
					
				}
			});
			
		});
		
	});
});