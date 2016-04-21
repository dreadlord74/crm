<script type="text/javascript">
    $(document).ready(function(){
        var flag = 0;
        function write_click(e){
            $(e).click(function() {
                $(this).parent("li").children("input[name=all]").css({display: "none"});
                $(this).parent("li").children("#data")[0].removeAttribute("disabled");
                $(this).parent("li").children("select[name=work_type]").css({display: "inline-block"});
                $(this).parent("li").children("input[type=color]").css({display: "inline-block"});
                $(this).parent("li").children("input[type=text]:not([name=all])").css({width: "115px"}).css({display: "inline-block"});
                this.setAttribute("src", "<?=VIEW?>/img/sign.png");//
                this.setAttribute("action", "write_ok");
                $(e).unbind(write_click(e));
                $(e).bind(write_ok(e));
            });
        }

        function write_ok(e){
            $(e).click(function(){

                var parent = $(this).parent("li");

                $(e).attr("action", "write").attr("src", "<?=VIEW?>/img/tool.png");
                parent.children("#data")[0].setAttribute("disabled", "disabled");
                parent.children("input[name=all]").css({display: "inline-block"});
                parent.children("input[type=color]").css({display: "none"});
                parent.children("select[name=work_type]").css({display: "none"});
                parent.children("input[type=text]:not([name$=color]):not([name=all])").css({display: "none"});
                $(e).unbind(write_ok(e));
                $(e).bind(write_click(e));

                var data = "id="+parent.children("input[name=id]").val()+
                "&name="+parent.children("input[name=name]").val()+
                "&date="+parent.children("input[name=date]").val()+
                "&way="+parent.children("input[name=way]").val()+
                "&work_type="+parent.children("select[name=work_type]").val()+
                "&contract_number="+parent.children("input[name=contract_number]").val()+
                "&color="+parent.children("input[name=color]").val()+
                "&text_color="+parent.children("input[name=text_color]").val();
                //alert(data);
                $.ajax({
                    url: "./?view=client&do=write",
                    type: "POST",
                    data: data,
                    success: function(data) {
                        if (data==1)
                            document.location.href = "<?=PATH.$_SERVER[REQUEST_URI]?>";
                    }
                });

            });
        }

        $("img[action=write]").click(function(){
            if (flag == 0){
                write_click(this);
                $(this).parent("li").children("input[name=all]").css({display: "none"});
                $(this).parent("li").children("#data")[0].removeAttribute("disabled");
                $(this).parent("li").children("select[name=work_type]").css({display: "inline-block"});
                $(this).parent("li").children("input[type=color]").css({display: "inline-block"});
                $(this).parent("li").children("input[type=text]:not([name=all])").css({width: "140px"}).css({display: "inline-block"});
                this.setAttribute("src", "<?=VIEW?>/img/sign.png");//
                this.setAttribute("action", "write_ok");
                $(this).unbind(write_click(this));
                $(this).bind(write_ok(this));
                flag == 1;
            }

        });

        $("input[type=button]").click(function(){
            $("#modal").modal("show");
        });

    });
</script>
<div style="margin:0" class="row">
    <div class="col-lg-12">
        <h1><?=$title?></h1>
        <div class="col-lg-12">
            <ol class="list-group xd">
                <?foreach($client->get_all() as $value):?>
                    <li>
                        <input type="hidden" name="id" value="<?=$value[id]?>"/>
                        <input name="date" id="data" style="text-align: center; width: 125px" type="date" value="<?=$value[date]?>" disabled />
                        <input style="background: <?=$value[color]?>; color: <?=$value[text_color]?>" type="text" name="name" value="<?=$value[name]?>" />
                        <input style="background: <?=$value[color]?>; color: <?=$value[text_color]?>" type="text" name="way" value="<?=$value[way]?>" />
                        <select style="background: <?=$value[color]?>; color: <?=$value[text_color]?>; display: none"name="work_type">
                            <option value="<?=$value[work_type]?>"><?=$work_type[$value[work_type]]?></option>
                            <?foreach ($work_type as $key => $type):?>
                                <?if ($key != $value[work_type]):?>
                                    <option value="<?=$key?>"><?=$type?></option>
                                <?endif?>
                            <?endforeach?>
                        </select>
                        <input style="background: <?=$value[color]?>; color: <?=$value[text_color]?>" type="text" name="contract_number" value="<?=$value[contract_number]?>" />

                        <input style="width: 350px; background: <?=$value[color]?>; color: <?=$value[text_color]?>; display: inline-block" type="text" name="all" value="<?=$value[name]." (".$value[way].") ".$work_type[$value[work_type]]." - ".$value[contract_number]?>" disabled />
                        <input title="Цвет фона" type="color" id="bg-color" name="color" value="<?=$value[color]?>" />
                        <input title="Цвет текста" type="color" id="t-color" name="text_color" value="<?=$value[text_color]?>" />
                        <img action="write" class="img-thumbnail control" src="<?=VIEW?>/img/tool.png" />
                        <!--<img action="delete" class="img-thumbnail control" src="<?=VIEW?>/img/delete.png" />-->
                    </li>
                <?endforeach?>
            </ol>
            <input style="width: 520px" type="button" class="btn-block" value="Добавить клиента" />
        </div>
    </div>
</div>
<div id="modal" class="modal fade">
    <div style="width: 825px;" class="modal-dialog">
        <form action="/?view=client&do=add" method="post" class="modal-content">
            <div class="modal-header">
                <h4>Добавление клиента</h4>
            </div>
            <div class="modal-body input-group">
                <input required name="date" id="data" style="text-align: center; width: 125px" type="date" value="" placeholder="Дата"/>
                <input required type="text" name="name" value="" placeholder="Имя клиента"/>
                <input required type="text" name="way" value="" placeholder="Ниша"/>
                <select name="work_type" required>
                    <option value="">Вид работ</option>
                    <?foreach ($work_type as $key => $type):?>
                        <option value="<?=$key?>"><?=$type?></option>
                    <?endforeach?>
                </select>
                <input required type="text" name="contract_number" value="" placeholder="Номер договора"/>
                <input title="Цвет фона" required style="display: inline-block;margin-top: 20px;" type="color" id="bg-color" name="color" value="#fff" />
                <input title="Цвет текста" required style="display: inline-block;margin-top: 20px; float: right;" type="color" id="t-color" name="text_color" value="#000" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <input type="submit" name="submit" class="btn btn-primary" value="Сохранить" />
            </div>
        </form>
    </div>
</div>