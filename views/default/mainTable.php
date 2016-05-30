<script type="text/javascript" src="<?=VIEW?>/js/main.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".th > img").click(function(){

            $("#modal-q").modal("show");
            var data = "worker_id="+$(this).parent(".th").attr("rab");
            $("#modal-q .btn-primary").click(function(){
                $.ajax({
                    url: "./?view=worker&do=add_column",
                    type: "POST",
                    data: data,
                    success: function (data){
                        document.location.href = "<?=PATH.$_SERVER[REQUEST_URI]?>";
                    }
                });
            });
        });
    });
</script>
<?
    $dates;
    $deps = $dep->get_all();
?>
<table class="table" style="overflow:scroll; max-width:300%; width: 130%">
    <thead>
    <tr style="background:#00BFFF; color: #fff;">
        <th class="small"></th>
        <th style="width: 40px;"></th>
        <th class="small"></th>
        <?foreach ($deps as $dKey => $value):?>
            <th colspan="<?=$value[cols]?>" otdel='<?=$value[id]?>' style="text-align:center"><?=$value[name]?></th>
        <?endforeach?>
        <th style="background: red; color: #fff">Срок сдачи проекта</th>
    </tr>
    <tr>
        <th>месяц</th>
        <th>дата</th>
        <th>день</th>
        <?foreach ($deps as $value):?>
            <?foreach($worker->get_by_dep_id($value[id]) as $item):?>
                <th class="th" otdel='<?=$value[id]?>' rab='<?=$item[id]?>' colspan="<?=$item[cols]?>"><?=$item[name]." ".$item[fam]?><img src="<?=VIEW?>/img/add.png"></th>
            <?endforeach?>
            <th></th>
        <?endforeach?>
    </tr>
    </thead>
    <tbody>
    <?
        $dat = $date->first_get();
        $cur_date = date("Y-m-d");
        $flag = 0;
    foreach ($dat as $d_key => $item):?>
        <?$day = get_day_of_week($item[date])?>
        <tr <?=(date("Y-m-d") == $item[date] ? "today='1' id='today'" : "")?> day-key="<?=$d_key?>" work_day="<?=$item[is_work_day]?>" <?=(!$item[is_work_day] ? "style='display: none;'" : "")?> date-id="<?=$item[id]?>" <?=($day == "пн" ? "class='pn'": "")?>>
            <td><?=get_month($item[date])?></td>
            <td><?=change_date_view($item[date]).($flag ? (!$dat[$d_key+1][is_work_day] ? "<img work src='".VIEW."/img/work.png' title='Сделать следующий день робочим' />" : "") : "")?></td>
            <td><?=$day.($flag ? "<img not-work src='".VIEW."/img/relax.png' title='Сделать день неробочим' />" : "")?></td>
			<?$dates .= "<div>".get_month($item[date])."</div><div>".change_date_view($item[date])."</div><div>".$day."</div>"?>
            <?foreach($deps as $ids):?>
                <?foreach($worker->get_by_dep_id($ids[id]) as $workers):?>
                    <?$mainT = $main->get_work_by_worker_id_date_id($workers[id], $item[id])?>
                    <?foreach ($mainT as $work):?>
                        <td not-blur="1" work-id="<?=$work[id]?>" class="td click" style="background: <?=$client->get_color_by_id($work[client_id])?>; color: <?=$client->get_text_color_by_id($work[client_id])?>" otdel='<?=$ids[id]?>' rab='<?=$workers[id]?>' work='<?=$work[client_id]?>'>
                            <input style="color: <?=$client->get_text_color_by_id($work[client_id])?>" disabled="disabled" type="text" name="work"  value='<?=($work[client_id] != -1 ? $client->get_name_by_id($work[client_id])." (".$client->get_way_by_id($work[client_id]).") ".$client->get_work_type_by_id($work[client_id]) : $work[text])?>' />
                            <textarea class="hidden-text" name="description"><?=$work[description]?></textarea>
                            <img src="<?=VIEW?>/img/delete-button.png" />
                        </td>
                        <td not-blur="1" style="background: <?=$client->get_color_by_id($work[client_id])?>; color: <?=$client->get_text_color_by_id($work[client_id])?>"><input class="time-input" work-id="<?=$work[id]?>" type="text" name="time" value="<?=$work[time]?>"/></td>
                    <?endforeach?>
                    <?
                        if (count($mainT) < $workers[cols]/2){
                            for ($i = count($mainT); $i < ($workers[cols]/2); $i++)
                                echo "<td not-blur=\"1\" class='td click' otdel='{$ids[id]}' rab='{$workers[id]}'> <input type='text' name='work'  value='' /></td><td not-blur=\"1\"><input disabled='disabled' class='time-input' type='text' name='time' value=''/></td>";
                        }
                    ?>
                <?endforeach?>
                <td><?=$day?></td>
            <?endforeach?>
            <?
			
				$deadline = $date->get_deadline_by_date_id($item[id]);
				
				
			?>
            	<td not-blur="1" class="deadline click" style="background: <?=$deadline->color?>; color: <?=$deadline->text_color?>" deadline-id="<?=$deadline->deadline_id?>" work='<?=$deadline->id?>'>
                            <input style="color: <?=$deadline->text_color?>" disabled="disabled" type="text" name="work"  value='<?=(($deadline->id != -1 && $deadline) ? $deadline->name." (".$deadline->way.") ".$deadline->work_type : "")?>' />
                            <?if ($deadline):?>
                            	<img src="<?=VIEW?>/img/delete-button.png" />
                            <?endif?>
                        </td>
           
        </tr>
        <?if ($item[date] == $cur_date) $flag = 1?>
    <?endforeach?>
    </tbody>
</table>
<div class="hidden">
    <ul class="list-group enter">

    </ul>
</div>
<div class="modal fade" id="modal-q">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Добавление столбца</h4>
            </div>
            <div class="modal-body">
                Вы действительно хотите добавить столбец?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Нет</button>
                <input type="submit" name="submit" class="btn btn-primary" value="Да" />
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-q2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Удаление ячейки</h4>
            </div>
            <div class="modal-body">
                Вы действительно хотите удалить эту ячейку?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Нет</button>
                <input type="submit" name="submit" class="btn btn-primary" value="Да" />
            </div>
        </div>
    </div>
</div>

<div id='fade' style='width: 100%; height: 100%;'></div>

<table class="left-block">
	
</table>
