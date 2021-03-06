<script type="text/javascript">
    $(document).ready(function(){
        var flag = 0;
        function write_click(e){
            $(e).click(function() {
                $(e).prev("input").prev("input").prev("input").prop("disabled", false).prev("input").prop("disabled", false).parent("li").children("input[type=color]").css({display: "inline-block"});
                $(e).attr("src", "<?=VIEW?>/img/sign.png").attr("action", "write_ok");
                $(e).unbind(write_click(e));
                $(e).bind(write_ok(e));
            });
        }

        function write_ok(e){
            $(e).click(function(){
                $(e).prev("input").prev("input").attr("action", "write").attr("src", "<?=VIEW?>/img/tool.png");
                $(e).prev("input").prev("input").prev("input").prop("disabled", true).prev("input").prop("disabled", true).parent("li").children("input[type=color]").css({display: "none"});
                $(e).unbind(write_ok(e));
                $(e).bind(write_click(e));

                var data = "id="+$(e).parent("li").children("input[name=name]").attr("data-id")+"&name="+$(e).parent("li").children("input[name=name]").val()+"&prior="+$(e).parent("li").children("input[name=name]").prev("input").val()+"&color="+$(e).parent("li").children("input[name=color]").val()+"&text_color="+$(e).parent("li").children("input[name=text_color]").val();
                //alert(data);
                $.ajax({
                    url: "./?view=dep&do=write",
                    type: "POST",
                    data: data,
                    success: function(data) {
                        //alert(data);
                        document.location.href = "<?=PATH.$_SERVER[REQUEST_URI]?>";
                    }
                });

            });
        }

        $("img[action=write]").click(function(){
            if (flag == 0){
                write_click(this);
                $(this).prev("input").prev("input").prev("input").prop("disabled", false).prev("input").prop("disabled", false).parent("li").children("input[type=color]").css({display: "inline-block"});
                $(this).attr("src", "<?=VIEW?>/img/sign.png").attr("action", "write_ok");
                $(this).unbind(write_click(this));
                $(this).bind(write_ok(this));
                flag == 1;
            }

        });

        $("img[action=del]").click(function(){
            var act = confirm("Вы действительно хотите удалить отдел "+$(this).parent("li").children("input").val()+"?"), li = $(this).parent("li");

            if (act){
                var data = "id="+$(this).parent("li").children("input[name=name]").attr("data-id");
                $.ajax({
                    url: "./?view=dep&do=del",
                    type: "POST",
                    data: data,
                    success: function(data){
                        //alert(data);
                        if (data == 1) {
                            alert("Отдел удалён из базы данных!");
                            li.css({display: "none"});
                        }else{
                            alert("Сначала нужно удалить все записи, связанные с отделом.");
                        }
                    }
                });
            }
        });

        $("input[type=button]").click(function(){
            var name = prompt("Введите название отдела:");

            if (name){
                $.ajax({
                    url: "./?view=dep&do=add",
                    type: "POST",
                    data: "name="+name,
                    success: function (data){
                       // alert(data);
                        if (data != 0){
                           var el = $.parseJSON(data);
                            //alert(data);
                           // $.each(data, function(i, el) {
                                $(".input-group").append('' +
                                    '<li>' +
                                    '<input style="width: 20px; text-align: center" name="priority" type="text" value="'+el.priority+'" disabled />' +
                                    '<input data-id="' + el.id + '" type="text" name="name" value="' + el.name + '" disabled />' +
                                    '<input style="display: none" type="color" name="color" value="' + el.color+ '" />'+
                                    '<input style="display: none" type="color" name="text_color" value="'+ el.text_color +'" />'+
                                    '<img action="write" class="img-thumbnail control" src="<?=VIEW?>/img/tool.png" />' +
                                    '<img action="del" class="img-thumbnail control" src="<?=VIEW?>/img/delete.png" />' +
                                    '</li>');
                                $("input[data-id=" + el.id + "] + img[action=write]").click(function () {
                                    write_click(this);
                                });

                                $("input[data-id=" + el.id + "] + img[action=write]").next("img[action=del]").click(function () {
                                    var act = confirm("Вы действительно хотите удалить отдел " + $(this).parent("li").children("input").val() + "?");

                                    if (act) {
                                        var data = "id=" + $(this).parent("li").children("input").attr("data-id");
                                        $.ajax({
                                            url: "./?view=dep&do=del",
                                            type: "POST",
                                            data: data,
                                            success: function (data) {
                                                if (data == 1) {
                                                    alert("Отдел удалён из базы данных!");
                                                    $(this).parent("li").css({display: "none"});
                                                } else {
                                                    alert("Сначала нужно удалить все записи, связанные с отделом.");
                                                }
                                            }
                                        });
                                    }
                                });
                            //});

                        }else
                            alert("При добавлении отдела произошла ошибка!");
                    }
                });
            }
        });
    });
</script>
<div class="row center-block">
    <div class="col-lg-10">
        <h1><?=$title?></h1>
        <div class="col-lg-4">
            <ol class="list-inline input-group">
                <?foreach($dep->get_all() as $dep):?>
                    <li>
                        <input style="width: 20px; text-align: center; background: <?=$dep[color]?>; color: <?=$dep[text_color]?>" name="priority" type="text" value="<?=$dep[priority]?>" disabled />
                        <input data-id="<?=$dep[id]?>" style="background: <?=$dep[color]?>; color: <?=$dep[text_color]?>;" type="text" name="name" value="<?=$dep[name]?>" disabled />
                        <input style="display: none" type="color" name="color" value="<?=$dep[color]?>" />
                        <input style="display: none" type="color" name="text_color" value="<?=$dep[text_color]?>" />
                        <img action="write" class="img-thumbnail control" src="<?=VIEW?>/img/tool.png" />
                        <img action="del" class="img-thumbnail control" src="<?=VIEW?>/img/delete.png" />
                    </li>
                <?endforeach?>
            </ol>
            <input style="width: 283px" type="button" class="btn-block" value="Добавить отдел" />
        </div>
    </div>
</div>