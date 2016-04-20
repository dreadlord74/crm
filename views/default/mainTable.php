<table class="table" style="overflow:scroll; max-width:300%;">
    <thead>
    <tr style="background:#00BFFF">
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
    <?foreach ($date->get_all() as $item):?>
        <tr <?=($item[day] == "пн" ? "style='border-top:1px solid #000;": "")?>>
            <td><?=$item[moth]?></td>
            <td><?=change_date_view($item[date])?></td>
            <td><?=$item[day]?></td>

            <?foreach($dep->get_all() as $ids):?>
                <?foreach($worker->get_by_dep_id($ids[id]) as $key => $workers):?>
                    <?$mainT = $main->get_work_by_worker_id_date_id($workers[id], $item[id])?>
                    <?foreach ($mainT as $work):?>
                        <td style="background: <?=$client->get_color_by_id($work[client_id])?>" otdel='<?=$ids[id]?>' rab='<?=$workers[id]?>' work='<?=$work[client_id]?>'><?=$client->get_name_by_id($work[client_id])?></td>
                        <td style="background: <?=$client->get_color_by_id($work[client_id])?>"><?=$work[time]?></td>
                    <?endforeach?>
                    <?
                        if (count($mainT) < $workers[cols]/2){
                            //доделать
                            $it = (count($mainT) ? count($mainT) : ($key == 0 ? 0 : -4));
                            if ($key == 1) $it = -2;
                            for ($i = $it; $i <= ($workers[cols]/2); $i++)
                                echo "<td otdel='{$ids[id]}' rab='{$workers[id]}'></td>";
                        }
                    ?>
                <?endforeach?>
                <td><?=$item[day]?></td>
            <?endforeach?>
        </tr>
    <?endforeach?>
    </tbody>
</table>
