$(document).ready(function(e) {
	
	$("body:not(:animated)").animate({scrollTop: $("#today").offset().top-300}, 10);
	
	var headerW = $('thead').width(), headerH = $('thead').height(), thsW = [], thsH = [];
	
	$('thead tr').each(function(index, element) {
		thsW[index] = []; thsH[index] = [];
        $(this).children("th").each(function(i, el) {
            thsW[index][i] = $(this).width();
			thsH[index][i] = $(this).height();
        });
    });
	/*
	$(".table tr").each(function(i, e){
		$(".left-block").append("<tr>"+$(this).eq(0).clone()+$(this).eq(1).clone()+$(this).eq(2).clone()+"</tr>");
	});*/
	
	$('thead tr').each(function(index, element){
		$(this).children("th").each(function(i, el) {
            $(this).height(thsH[index][i]).width(thsW[index][i]);
        });
	});
	
	$("body").prepend($("thead").clone());
	
	$('body > thead').css({display: "block", position: "fixed", width: headerW, height: headerH, "z-index": 5});
	
	//скролл шапки
	$(window).on("scroll", function(){
		$("body > thead").css({left: "-"+$(this).scrollLeft()+"px"});		
		
		/*if ($(".table").height() - ($(this).scrollTop()+$(window).height()) <= 200){
			var last = $(".table tbody tr:last-child").attr("date-id"), count = $(".table tbody tr:last-child td").length, day_key = $(".table tbody tr:last-child").attr("day-key");
			
			$.ajax({
				url: "./?do=get_next_dates",
				type: "POST",
				data: "last_date="+last,
				success: function(data){
					var dat = $.parseJSON(data);
					console.log($.parseJSON(data));
					
					$.each(dat, function(i, el){
						$(".table").append("<tr day-key='"+day_key+1+i+"' data-id='"+el.id+"' work_day='"+el.is_work_day+"'></tr>");
					});
				},
				error: function(){
					alert("?? ??????? ???????? ????????? ?????? ???????");
				}
			});
		}*/
	});
	
	var lol = true, mX = 0, mY = 0, cX = 0, cY = 0, lo = false;
	
	$(window).on("keydown", function(e){
		if (lol == true)
			if (e.keyCode == 32){
				
				$("#fade").addClass("grab");

				
				return false;
			}
	});
	
	$(document).mousemove(function(e){
		mX = e.pageX; // ��������� �� ��� X
    	mY = e.pageY; // ��������� �� ��� Y
	});

	$("#fade").on("mousedown", function(){
		$(this).removeClass("grab").addClass("grabbing");
		lo = true;
		cX = mX;
		cY = mY;
	});
	
	$(document).mousemove(function(e){				
    			if (lo){
					
					$(window).scrollLeft($(window).scrollLeft()+(cX - mX));
					
					$(window).scrollTop($(window).scrollTop()+(cY - mY));
				}
	});
				
	$("#fade").on("mouseup", function(){
		$(this).removeClass("grabbing").addClass("grab");
		lo = false;
	});
	
	$("#fade").height($(window).height());
	
	$(window).on("keyup", function(e){
		if (e.keyCode == 32){
			lo = false;
			$("#fade").removeClass("grab").removeClass("grabbing");	
		}
	});
	
	$('.table').on('focusin', "input", function(){
		lol = false;
	});
	
	$('.table').on('focusout', "input", function(){
		lol = true;
	});
	
	$('.table').on('focusin', 'textarea', function(){
		lol = false;
	});
	
	$('.table').on('focusout', 'textarea', function(){
		lol = true;
	});
	
	var text, time;
	
	/*$(".td > textarea").hover(function(){
		$(this).parent("td").attr("delay", 1);
	}, function(){
		var obj = $(this).parent("td");
		
		obj.attr("delay", 0);
	});*/

	$(".table").on("change", "textarea", function(){
		var data = "description="+$(this).val()+"&id="+$(this).parent("td").attr("work-id");
				$.ajax({
					url: "./?view=mainTable&do=write_desc",
					type: "POST",
					data: data,
					success: function(data){
						if (data == 0)
							alert("Не удалось изменить текстовое поле.");
					}
				});
	});
	
	$(".table").on("focusout", "textarea", function(){
		var obj = $(this);
		setTimeout(function(){
			if (obj.attr("delay") == 0){
				obj.css({display: "none"});
			}
		}, 1000);
		
		$(this).attr("delay", 1).css({"display": "block"});
	});
	
	var timer;
	$(".table").on("focus", "textarea", function(){
		var obj = $(this);
		
		timer = setInterval(function(){
			$(this).attr("delay", 1);
		}, 10);
	});
	
	$(".table").on("mousemove", "textarea", function(){
		$(this).attr("delay", 1);		
	});
	
	$(".table").on("mouseleave", "textarea", function(){
		$(this).attr("delay", 1);
		
		var obj = $(this);
		setTimeout(function(){
			if (obj.attr("delay") == 0){
				obj.css({display: "none"});
			}
		}, 1000);
		
	});
	
	$(".table").on("mousemove", ".td", function(){
		$(this).children("textarea").css({"display": "block"}).attr("delay", 1);
	});
	
	$(".table").on("mouseleave", ".td", function(){
		var obj = $(this).children("textarea");
		
		obj.attr("delay", 0);
		
		setTimeout(function(){
			if (obj.attr("delay") == 0){
				obj.css({display: "none"});
			}
		}, 1000);
	});
	
	$(window).on("scroll", function(){
		
	});
	
	/*$(".table").on("change", ".td > input", function(){
		var data = "id="+$(this).parent(".td").attr("work-id")+"&text="+$(this).val()+"&worker_id="+$(this).parent(".td").attr("rab")+
			"&dep_id="+$(this).parent(".td").attr("otdel")+"&date_id="+$(this).parent(".td").parent("tr").attr("date-id"), obj = $(this).parent(".td");
		
		console.log(data);
		if ($(this).val() != ""){
			$.ajax({
				url: "./?do=change_text",
				type: "POST",
				data: data,
				success: function(data){
					if (data > 1){
						obj.attr("work-id", data);
					}
				}
			});
		}
	});*/
	
	$(".table").on('click', '.td img', function(){
		$("#modal-q2").modal("show"); 
		
		var data = "id="+$(this).parent(".td").attr("work-id"), obj = $(this).parent(".td");
		
		$("#modal-q2 .btn-primary").click(function(){
			$.ajax({
				url: "./?do=delete",
				type: "POST",
				data: data,
				success: function(data){
					if (data == 1){
						obj.removeAttr("style").removeAttr("work-id").removeAttr("work");
						
						obj.children("input").val("").removeAttr("style");
						
						obj.children("img").remove();
						
						obj.children("textarea").remove();
						
						obj.next("td").removeAttr("style").children("input").val("").removeAttr("style");
						
						$("#modal-q2").modal("hide");
					}
				}
			});
			
			$("#modal-q2 .btn-primary").off("click");
			
		});
	});
	
	$(".table").on("click", "img[work]", function(){
		var tr = $(this).parent("td").parent("tr").next("tr");
		var data = "id="+tr.attr("date-id")+"&value=1";
		$.ajax({
			url: "./?do=change_work_day",
			type: "POST",
			data: data,
			success: function(data){
				if (data == 1){
					tr.css({display: "table-row"});
				}
			},
			error: function(){
				alert("?? ??????? ??????? ????????? ???? ???????");
			}
		});
	});
	
	$(".table").on("click", "img[not-work]", function(){
		var tr = $(this).parent("td").parent("tr");
		var data = "id="+tr.attr("date-id")+"&value=0";
		$.ajax({
			url: "./?do=change_work_day",
			type: "POST",
			data: data,
			success: function(data){
				if (data == 1){
					tr.css({display: "none"});
				}
			},
			error: function(){
				alert("?? ??????? ??????? ???? ?????????");
			}
		});
	});
	
   /*$(".td").hover(function(){
			
			text = $(this).children("textarea").val();
			
			$(this).children("textarea").css({display: "block"});
			
		}, function(){
			var obj = $(this);
			setTimeout(function(){
				if (obj.attr("delay") == 0)
					obj.children("textarea").css({display: "none"});
			}, 1000);
			
			if (text != $(this).children("textarea").val()){
				
			}			
		}
	);*/
	
	var focusInput;
	
	/*$(".td").next("td > input").children("input").on("focusin", function(){
		time = $(this).val();
	});*/
	
	$(".table").on("change", ".time-input", function(){
			var data = "time="+$(this).val()+"&id="+$(this).parent("td").prev(".td").attr("work-id");
			$.ajax({
					url: "./?view=mainTable&do=write_time",
					type: "POST",
					data: data,
					success: function(data){
						if (data == 0)
							alert("Не удалось изменить время.");
					}
				});
	});
	
	$(".table").on("click", ".click", function(){
		$(this).children("input").prop("disabled", false);
		
		$(".hidden").css({top: $(this).offset().top - $(window).scrollTop() + 20+"px", left: $(this).offset().left - $(window).scrollLeft()+"px"});
		$(".enter").html("");
	});
	
	$(".table").on("focusin", ".click > input", function(){
		focusInput = $(this);
	});
	
	$(".table").on("keypress", ".click > input", function(){
		var obj = $(this), text = $(this).val();
		
		$(".hidden").addClass("show-list");
		
		if ($(".hidden").offset().left+$(".hidden").width() > $(".table").width()){
			//$(".hidden").css({left: (($(".table").height() - $(".hidden").offset().left) + $(".hidden").offset().left)+"px"});
		}
		
		$.ajax({
			url: "./?view=client&do=get_clients",
			type: "POST",
			data: "search="+text,
			success: function(data){
				
				data = $.parseJSON(data);
					
				$(".enter").html(" ");
					
				$.each(data, function(i, el){
					$(".enter").prepend(
					"<li style='background: "+el.color+"; color: "+el.text_color+"' client-id='"+el.id+"'>"+
						el.name+" ("+el.way+") "+el.work_type+" - "+el.contract_number+
					"</li>");
				});
			}
		});
	});
	
	$(".table").on("click", ".deadline > img", function(){
		var data = "id="+$(this).parent("td").attr("deadline-id"), obj = $(this);
		$.ajax({
			url: "./?do=delete_deadline",
			type: "POST",
			data: data,
			success: function(data){
				if (data != 0)
					obj.css({display: "none"}).parent("td").removeAttr("style").removeAttr("deadline-id").children("input").val(" ");
			}
		});
	});
	
	var wText = 0;
	
	$(".hidden").on("click", "li", function(){		
		var obj = $(this), data, url, sw = -3;
		//$(this).parent(".show-list").removeClass("show-list");
		
		if (focusInput.parent("td").hasClass("deadline")){
			data = "client_id="+obj.attr("client-id")+"&date_id="+focusInput.parent("td").parent("tr").attr("date-id");
			url = "./?do=add_deadline";
			
			sw = 1;
		}else if(focusInput.parent("td").hasClass("td") && +focusInput.parent(".td").attr("work") == -1){
			url = "./?do=write_work";
			var id = focusInput.parent(".td").attr("work");
			
			data = "id="+id+"&client_id="+focusInput.parent(".td").attr("work");
			
			sw = 2;
		}else if (focusInput.parent("td").hasClass("td") && !focusInput.parent(".td").attr("work")){
			url = "./?do=add_work";
			data = "date_id="+focusInput.parent(".td").parent("tr").attr("date-id")+"&dep_id="+focusInput.parent(".td").attr("otdel")+
					"&client_id="+$(this).attr("client-id")+"&worker_id="+focusInput.parent(".td").attr("rab");
			
			sw = 3;
		}
			$.ajax({
				url: url,
				type: "POST",
				data: data,
				success: function(data){
					wText = 1;
					var td = focusInput.parent("td"), inp = focusInput;
					switch(sw){
						case 1:
							e = $.parseJSON(data);
						
							td.attr("deadline-id", e.did).attr("work", e.cid).css({background: e.color, color: e.text_color});
							inp.css({background: e.color, color: e.text_color}).val(e.name+" ("+e.way+")");
								
							td.append("<img src='views/default/img/delete-button.png' />");
							
						break;
						
						case 2:						
						case 3:
							//focusInput.parent("td").attr("work-id", data);
							
							data = $.parseJSON(data);
							
							$.each(data, function(i, e){
								td.attr("work-id", e.wid).append("<img src='views/default/img/delete-button.png' />").append('<textarea class="hidden-text" name="description" delay="0"></textarea>').attr("work", e.cid).css({background: e.color, color: e.text_color}).next("td").css({background: e.color, color: e.text_color}).children("input").css({background: e.color, color: e.text_color}).attr("placeholder", 0).prop("disabled", false).attr("open", 1);
								inp.css({background: e.color, color: e.text_color}).val(e.name+" ("+e.way+") "+e.work_type+" - "+e.contract_number);
							});
							
							
							
						break;
					}
					
					//$(".show-list").removeClass("show-list");
					
				}
			});
	});
	
	$(".table").on("focusout", "input", function(){
		setTimeout(function(){
			$(".show-list").removeClass("show-list");
		}, 200);
	});
	
	$(".table").on("change", "input[name=work]", function(){
		var td = $(this).parent("td"), input = $(this);
		wText = 0;
		setTimeout(function(){
			if ((!td.attr("work-id") || +td.attr("work-id") == -1) && (wText == 0)){
				var data = "date_id="+td.parent("tr").attr("date-id")+"&id="+td.attr("work-id")+"&dep_id="+td.attr("otdel")+"&worker_id="+td.attr("rab")+"&text="+input.val();
				$.ajax({
					url: "./?do=change_text",
					type: "POST",
					data: data,
					success: function(data){
						if (data){
							td.attr("work-id", data);
							td.next("td").children("input").prop("disabled", false).attr("placeholder", 0);
							td.append('<textarea class="hidden-text" name="description"></textarea><img src="/views/default/img/delete-button.png" />');
						}
					},
					error: function(){
						alert("?? ??????? ???????? ?????");
					}
				});
			}
		}, 1500);
	});
	
	$(".table").on("click", ".td", function(){
		
		var parent = this;
		
		//$(this).children("textarea").css({display: "none"});
		
		$(this).children("input").prop("disabled", false);
		
		/*$(this).children("input").on("keypress", function(){
			var text = $(this).val(), obj = this;
			
			$(".hidden").addClass("show-list");
			
			$.ajax({
				url: "./?view=client&do=get_clients",
				type: "POST",
				data: "search="+text,
				success: function(data){
					console.log(data);
					data = $.parseJSON(data);
					
					$(".enter").html("");
					
					$.each(data, function(i, el){
						$(".enter").prepend(
						"<li style='background: "+el.color+"; color: "+el.text_color+"' client-id='"+el.id+"'>"+
							el.name+" ("+el.way+") "+el.work_type+" - "+el.contract_number+
						"</li>"
						);
						$(".enter li[client-id="+el.id+"]").click(function(){
							if ($(obj).parent(".td").attr("work-id")){
								$.ajax({
									url: "./?do=write_work",
									type: "POST",
									data: "id="+$(obj).parent(".td").attr("work-id")+"&client_id="+$(obj).parent(".td").attr("work"),
									success: function(data){
										$(obj).css({color: el.text_color}).val(el.name+" ("+el.way+") "+el.work_type+" - "+el.contract_number);
											$(obj).parent(".td").attr("work", el.id).attr("work-id", data).css({background: el.color}).next("td").css({color: el.text_color, background: el.color}).children("input").attr("placeholder","0").prop("disabled", false).attr("work-id", data);
										console.log(data);
									}
								});
							}else{
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
											
											/*$(obj).parent(".td").hover(function(){
				
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
							}
						});
					});
					
				}
			});
			
		});	*/	
	});
});