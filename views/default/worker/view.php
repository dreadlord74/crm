<script type="text/javascript">
    $(document).ready(function(){
        var flag = 0;
        function write_click(e){
            $(e).click(function() {
                $(e).prev("input").prop("disabled", false).prev("input").prop("disabled", false);
                $(e).attr("src", "<?=VIEW?>/img/sign.png").attr("action", "write_ok");
                $(e).unbind(write_click(e));
                $(e).bind(write_ok(e));
            });
        }

        function write_ok(e){
            $(e).click(function(){
                $(e).attr("action", "write").attr("src", "<?=VIEW?>/img/tool.png");
                $(e).prev("input").prop("disabled", true).prev("input").prop("disabled", true);
                $(e).unbind(write_ok(e));
                $(e).bind(write_click(e));

                var data = "id="+$(e).prev("input[name=name]").attr("data-id")+"&name="+$(e).prev("input[name=name]").val()+"&prior="+$(e).prev("input[name=name]").prev("input").val();
                //alert(data);
                $.ajax({
                    url: "./?view=worker&do=write",
                    type: "POST",
                    data: data,
                    success: function() {
                        document.location.href = "<?=PATH.$_SERVER[REQUEST_URI]?>";
                    }
                });

            });
        }

        $("img[action=write]").click(function(){
            if (flag == 0){
                write_click(this);
                $(this).prev("input").prop("disabled", false).prev("input").prop("disabled", false);
                $(this).attr("src", "<?=VIEW?>/img/sign.png").attr("action", "write_ok");
                $(this).unbind(write_click(this));
                $(this).bind(write_ok(this));
                flag == 1;
            }

        });


        $("li input[type=button]").click(function(){
            $("#add").modal("show");
            $("#add h4").html("Добавление работника в отдел \""+$(this).attr("dep-name")+"\"");
            $("#add input[name=dep]").val($(this).attr("dep-id"));
        });

        $("img[action=del]").click(function(){
            var li = $(this).parent("li"), el = $(this);

            $("#delete").modal("show");
            $("#delete h4").html("Удаление работника из отдела "+$(this).parent("li").children("input[name=name]").attr("dep-name"));
            $("#delete .modal-body").html("Подтвердите удаление работника "+$(this).parent("li").children("input[name=name]").val()+" из отдела "+$(this).parent("li").children("input[name=name]").attr("dep-name")).css({display: "block"});
            $("#delete .btn-primary").css({display: "inline-block"});

            $("#delete .btn-primary").click(function(){
                var data = "id="+el.parent("li").children("input[name=name]").attr("data-id");
                $.ajax({
                    url: "./?view=worker&do=del",
                    type: "POST",
                    data: data,
                    success: function(data){
                        console.log(data);
                        if (data != 0) {
                            $("#delete .modal-body").html("Работник успешно удалён!");
                            li.css({display: "none"});
                        }else{
                            $("#delete .modal-body").html("Не удалось удалить работника");
                        }
                        $("#delete .btn-primary").css({display: "none"});
                    }
                });
            });
        });
    });
</script>
    <div style="margin: 0;" class="row">
        <div class="col-lg-10">
            <h1><?=$title?></h1>
            <div class="col-lg-4">
                <ul class="list-group list-inline">
                    <?foreach ($dep->get_all() as $dep_id):?>
                        <li>
                            <h3 class="h3"><?=$dep_id[name]?></h3>
                            <ol class="list-group list-inline">
                                <?foreach($worker->get_by_dep_id($dep_id[id]) as $workers):?>
                                    <li>
                                        <input style="width: 20px; text-align: center" name="priority" type="text" value="<?=$workers[priority]?>" disabled />
                                        <input data-id="<?=$workers[id]?>" dep-id="<?=$dep_id[id]?>" dep-name="<?=$dep_id[name]?>" type="text" name="name" value="<?=$workers[name]?>" disabled />
                                        <img action="write" class="img-thumbnail control" src="<?=VIEW?>/img/tool.png" />
                                        <img action="del" class="img-thumbnail control" src="<?=VIEW?>/img/delete.png" />
                                    </li>
                                <?endforeach?>
                            </ol>
                            <input style="width: 283px" dep-id="<?=$dep_id[id]?>" dep-name="<?=$dep_id[name]?>" type="button" class="btn-block" value="Добавить работника" />
                        </li>
                    <?endforeach?>
                </ul>
            </div>
        </div>
    </div>
<div id="add" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/?view=worker&do=add" method="post">
                <div class="modal-header">
                    <h4>Добавление работника в отдел </h4>
                </div>
                <div class="modal-body input-group">
                    <label for="name">Введите имя:</label>
                    <input autofocus required="required" type="text" name="mname" id="name" />
                    <input type="hidden" name="dep" value="0" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <input type="submit" name="submit" class="btn btn-primary" value="Сохранить" />
                </div>
            </form>
        </div>
    </div>
</div>
<div id="delete" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h4></h4>
                </div>
                <div class="modal-body input-group">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <input type="button" name="submit" class="btn btn-primary" value="Подтвердить" />
                </div>
        </div>
    </div>
</div>