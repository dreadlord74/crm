<script type="text/javascript" src="<?=VIEW?>/js/main.js"></script>
<table class="table" style="overflow:scroll; max-width:300%; width: 130%">
    <thead>
    <tr style="background:#00BFFF; color: #fff;">
        <th class="small"></th>
        <th style="width: 40px;"></th>
        <th class="small"></th>
        <?foreach ($dep->get_all() as $dKey => $value):?>
            <th colspan="<?=$value[cols]?>" otdel='<?=$value[id]?>' style="text-align:center"><?=$value[name]?></th>
        <?endforeach?>
    </tr>
    <tr>
        <th>месяц</th>
        <th>дата</th>
        <th>день</th>
        <?foreach ($dep->get_all() as $value):?>
            <?foreach($worker->get_by_dep_id($value[id]) as $item):?>
                <th otdel='<?=$value[id]?>' rab='<?=$item[id]?>' colspan="<?=$item[cols]?>"><?=$item[name]." ".$item[fam]?></th>
            <?endforeach?>
            <th></th>
        <?endforeach?>
    </tr>
    </thead>
    <tbody>
    <?foreach ($date->get_all() as $d_key => $item):?>
        <?$day = get_day_of_week($item[date])?>
        <tr work_day="<?=$item[is_work_day]?>" date-id="<?=$item[id]?>" <?=($day == "пн" ? "class='pn'": "")?>>
            <td><?=get_month($item[date])?></td>
            <td><?=change_date_view($item[date])?></td>
            <td><?=$day?></td>
            <?foreach($dep->get_all() as $ids):?>
                <?foreach($worker->get_by_dep_id($ids[id]) as $workers):?>
                    <?$mainT = $main->get_work_by_worker_id_date_id($workers[id], $item[id])?>
                    <?foreach ($mainT as $work):?>
                        <td work-id="<?=$work[id]?>" class="td" style="background: <?=$client->get_color_by_id($work[client_id])?>; color: <?=$client->get_text_color_by_id($work[client_id])?>" otdel='<?=$ids[id]?>' rab='<?=$workers[id]?>' work='<?=$work[client_id]?>'>
                            <?=$client->get_name_by_id($work[client_id])." (".$client->get_way_by_id($work[client_id]).") ".$work_type[$client->get_work_type_by_id($work[client_id])]?>
                            <textarea class="hidden-text" name="description"><?=$work[description]?></textarea>
                        </td>
                        <td style="background: <?=$client->get_color_by_id($work[client_id])?>; color: <?=$client->get_text_color_by_id($work[client_id])?>"><input class="time-input" work-id="<?=$work[id]?>" type="text" name="time" value="<?=$work[time]?>"/></td>
                    <?endforeach?>
                    <?
                        if (count($mainT) < $workers[cols]/2){
                            //вроде работает
                            //$it = (count($mainT) ? count($mainT) : ($key == 0 ? 0 : -4));
                           // if ($key == 1) $it = 2;
                            for ($i = count($mainT); $i < ($workers[cols]/2); $i++)
                                echo "<td otdel='{$ids[id]}' rab='{$workers[id]}'></td><td><input disabled='disabled' class='time-input' type='text' name='time' value=''/></td>";
                        }
                    ?>
                <?endforeach?>
                <td><?=$day?></td>
            <?endforeach?>
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
                            <td work-id="<?=$work[id]?>" class="td" style="background: <?=$client->get_color_by_id($work[client_id])?>; color: <?=$client->get_text_color_by_id($work[client_id])?>" otdel='<?=$ids[id]?>' rab='<?=$workers[id]?>' work='<?=$work[client_id]?>'>
                                <input disabled="disabled" type="text" name="123" value='<?=$client->get_name_by_id($work[client_id])." (".$client->get_way_by_id($work[client_id]).") ".$work_type[$client->get_work_type_by_id($work[client_id])]?>' />
                                <textarea class="hidden-text" name="description"><?=$work[description]?></textarea>
                            </td>
                            <td style="background: <?=$client->get_color_by_id($work[client_id])?>; color: <?=$client->get_text_color_by_id($work[client_id])?>"><input class="time-input" work-id="<?=$work[id]?>" type="text" name="time" value="<?=$work[time]?>"/></td>
                        <?endforeach?>
                        <?
                        if (count($mainT) < $workers[cols]/2){
                            //вроде работает
                            //$it = (count($mainT) ? count($mainT) : ($key == 0 ? 0 : -4));
                            // if ($key == 1) $it = 2;
                            for ($i = count($mainT); $i < ($workers[cols]/2); $i++)
                                echo "<td otdel='{$ids[id]}' rab='{$workers[id]}'></td><input type='text' name='123' value='' /><td><input class='time-input' type='text' name='time' value=''/></td>";
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
<?=get_day_of_week("2016-04-24")?>
