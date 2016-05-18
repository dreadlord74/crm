<script type="text/javascript" src="<?=VIEW?>/js/main.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".th > img").click(function(){

            $("#modal-q").modal("show");
            var data = "worker_id="+$(this).parent(".th").attr("rab");
            $("#modal .btn-primary").click(function(){
                $.ajax({
                    url: "./?view=worker&do=add_column",
                    type: "POST",
                    data: data,
                    success: function (data){
                        alert(data);
                        document.location.href = "<?=PATH.$_SERVER[REQUEST_URI]?>";
                    }
                });
            });
        });
    });
</script>
<? $dates?>
<table class="table" style="overflow:scroll; max-width:300%; width: 130%">
    <thead>
    <tr style="background:#00BFFF; color: #fff;">
        <th class="small"></th>
        <th style="width: 40px;"></th>
        <th class="small"></th>
        <?foreach ($dep->get_all() as $dKey => $value):?>
            <th colspan="<?=$value[cols]?>" otdel='<?=$value[id]?>' style="text-align:center"><?=$value[name]?></th>
        <?endforeach?>
        <th style="background: red; color: #fff">Срок сдачи проекта</th>
    </tr>
    <tr>
        <th>месяц</th>
        <th>дата</th>
        <th>день</th>
        <?foreach ($dep->get_all() as $value):?>
            <?foreach($worker->get_by_dep_id($value[id]) as $item):?>
                <th class="th" otdel='<?=$value[id]?>' rab='<?=$item[id]?>' colspan="<?=$item[cols]?>"><?=$item[name]." ".$item[fam]?><img src="<?=VIEW?>/img/add.png"></th>
            <?endforeach?>
            <th></th>
        <?endforeach?>
    </tr>
    </thead>
    <tbody>
    <?foreach ($date->limit_get(0) as $d_key => $item):?>
        <?$day = get_day_of_week($item[date])?>
        <tr <?=(date("Y-m-d") == $item[date] ? "today='1'" : "")?> day-key="<?=$d_key?>" work_day="<?=$item[is_work_day]?>" date-id="<?=$item[id]?>" <?=($day == "пн" ? "class='pn'": "")?>>
            <td><?=get_month($item[date])?></td>
            <td><?=change_date_view($item[date])?></td>
            <td><?=$day?></td>
			<?$dates .= "<div>".get_month($item[date])."</div><div>".change_date_view($item[date])."</div><div>".$day."</div>"?>
            <?foreach($dep->get_all() as $ids):?>
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
                            //вроде работает
                            //$it = (count($mainT) ? count($mainT) : ($key == 0 ? 0 : -4));
                           // if ($key == 1) $it = 2;
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
    <?endforeach?>
    <?if (FUTURE_DATES - (strtotime((date("d-m-Y")) - strtotime($last_date))/60/60/24) < FUTURE_DATES):?>
        <?foreach ($date->get_by_ids($main->add_date($item[date])) as $item):?>
            <?$day = get_day_of_week($item[date])?>
            <tr work_day="<?=$item[is_work_day]?>" date-id="<?=$item[id]?>" <?=($day == "пн" ? "style='border-top:1px solid #000;": "")?>>
                <td><?=get_month($item[date])?></td>
                <td><?=change_date_view($item[date])?></td>
                <td><?=$day?></td>
                <?foreach($dep->get_all() as $ids):?>
                    <?foreach($worker->get_by_dep_id($ids[id]) as $key => $workers):?>
                        <?$mainT = $main->get_work_by_worker_id_date_id($workers[id], $item[id])?>
                        <?foreach ($mainT as $work):?>
                            <td work-id="<?=$work[id]?>" class="td click" style="background: <?=$client->get_color_by_id($work[client_id])?>; color: <?=$client->get_text_color_by_id($work[client_id])?>" otdel='<?=$ids[id]?>' rab='<?=$workers[id]?>' work=''>
                                <input style="color: <?=$client->get_text_color_by_id($work[client_id])?>" type="text" name="work" value='' />
                                <textarea class="hidden-text" name="description"><?=$work[description]?></textarea>
                            </td>
                            <td style="background: <?=$client->get_color_by_id($work[client_id])?>; color: <?=$client->get_text_color_by_id($work[client_id])?>"><input class="time-input" work-id="<?=$work[id]?>" type="text" name="time" value=""/></td>
                        <?endforeach?>
                        <?
                        if (count($mainT) < $workers[cols]/2){
                            //вроде работает
                            //$it = (count($mainT) ? count($mainT) : ($key == 0 ? 0 : -4));
                            // if ($key == 1) $it = 2;
                            for ($i = count($mainT); $i < ($workers[cols]/2); $i++)
                                echo "<td class='td click' otdel='{$ids[id]}' rab='{$workers[id]}'></td><input type='text' name='work' value='' /><td><input class='time-input' type='text' name='time' value=''/></td>";
                        }
                        ?>
                    <?endforeach?>
                    <td><?=$day?></td>
                <?endforeach?>
            </tr>
        <?endforeach?>
    <?endif?>
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
