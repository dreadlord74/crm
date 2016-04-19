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
        <th>день недели</th>
        <?foreach ($dep->get_all() as $value):?>
            <?foreach($worker->get_by_dep_id($value[id]) as $item):?>
                <th otdel='<?=$value[id]?>' rab='<?=$item[id]?>' colspan="<?=$item[cols]?>"><?=$item[fam]." ".$item[name]?></th>
            <?endforeach?>
            <th></th>
        <?endforeach?>
    </tr>
    </thead>
    <tbody>
    <?foreach ($main_table as $tKey => $table):?>
        <tr>
            <td>апрель</td>
            <td>15.04.16</td>
            <td>пт</td>
            <td otdel='1' rab='1' work='1'>какая-то работа</td>
            <td>8</td>
            <td>пт</td>
            <td otdel='1' rab='2' work='1'>какая-то работа</td>
            <td>8</td>
            <td>какая-то работа2</td>
            <td>8</td>
            <td>какая-то работа2</td>
            <td>8</td>
            <td>пт</td>
        </tr>
    <?endforeach?>
    </tbody>
</table>
