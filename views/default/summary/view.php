<script type="text/javascript" src="<?=VIEW?>/js/summary.js"></script>
<div class="content">
    <?
        $summ = $summary->get_all();

        $workers_counter = 4; //чтобы выводилось 4 записи о работниках/для добавления работников по-умолчанию

        $months = array(); $month_ids = array();

        foreach($date->first_get() as $item){
            $data = explode("-", $item[date]);
            $month_ids[substr(get_month($item[date]), 0, 6).".-".$data[0]][] = $item[id];
            if ($last == get_month($item[date]))
                continue;

            $months[] = substr(get_month($item[date]), 0, 6).".-".$data[0];

            $last = get_month($item[date]);
        }
    ?>
    <table class="clients">
        <thead>
        <tr>
            <th class="client">
                Клиент
            </th>
            <th class="saled">
                Продано часов
            </th>
            <th class="ostatok">
                Остаток/Перебор
            </th>
        </tr>
        </thead>
        <tbody>
        <?foreach($summ as $sum):?>
            <?$cl = $client->get_by_id($sum[client_id])?>
            <tr sum-id="<?=$sum[id]?>" data-id="<?=$sum[client_id]?>">
                <td style="background: <?=$cl[color]?>; color: <?=$cl[text_color]?>" class="client">
                    <?=$cl[name]."(".work_type($cl[work_type]).")"." ".$cl[way]." - ".$cl[contract_number]?>
                    <img archive title="Переместить клиента в архив" src="<?=VIEW?>/img/import.png" />
                </td>
            </tr>
            <tr sum-id="<?=$sum[id]?>">
                <td><input type="text" name="hours" size="4" value="<?=$sum[hours]?>" /></td>
                <td hours></td>
            </tr>
            <tr exceeded sum-id="<?=$sum[id]?>">
                <td>превышено</td>
                <td exceeded>-</td>
            </tr>
            <tr sum-id="<?=$sum[id]?>">
                <td>нач. факт</td>
                <td>оконч. дог.</td>
            </tr>
            <tr sum-id="<?=$sum[id]?>">
                <td><input type="date" size="12" date="begin" name="date_<?=$sum[client_id]?>" value="<?=$sum[begin_date]?>" /></td>
                <td><input type="date" size="12" date="end" name="date_<?=$sum[client_id]?>" value="<?=$sum[end_date]?>" /></td>
            </tr>
        <?endforeach?>
        </tbody>
    </table>
    <table class="workers">
        <thead>
        <tr>
            <th class="rol">
                Роль
            </th>
            <th class="plan">
                Длит. дней
            </th>
            <th class="date">
                Дата окончания
            </th>
            <th class="plan hours">
                План часов
            </th>
            <th class="plan fact">
                Факт часов
            </th>
            <th class="ost">
                Остаток/потери
            </th>
        </tr>
        </thead>
        <tbody>
            <?foreach($summ as $sum):?>
                <?$infos = $summary->get_info_by_id($sum[id]); $workers_counter = 4?>
                <?foreach($infos as $key => $info):?>
                    <?$dep_ = $dep->get_by_id($worker->get_dep_id_by_id($info[worker_id])); $workers_counter--;?>
                    <tr key="<?=$key?>" sum-id="<?=$sum[id]?>" months="<?=count($months)?>" <?=((count($infos)-1 == $key) && ($workers_counter <= 0) ? "last" : "")?> dep-id="<?=$dep_[id]?>" worker-id="<?=$info[worker_id]?>" data-id="<?=$sum[client_id]?>">
                        <td style="background: <?=$dep_[color]?>; color: <?=$dep_[text_color]?>"><?=$dep_[name]." (".$worker->get_name_by_id($info[worker_id]).")"?>
                           <?=((count($infos)-1 == $key) && ($workers_counter <= 0) ? "<img title='Добавить исполнителя' src='".VIEW."/img/add.png' />" : "")?>
                        </td>
                        <td><input type="text" size="4" name="days_count" value="<?=$info[days_count]?>" /></td>
                        <td <?=(strtotime(date("d-m-Y")) >= strtotime($info[date_end]) ? "class='lost'" : "")?>><?=change_date_view($info[date_end])?></td>
                        <td><input type="text" size="4" name="plan_h" value="<?=$info[plan_hours]?>" /></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?endforeach?>
                    <?for($i = 1; $i<=$workers_counter; $i++):?>
                        <tr sum-id="<?=$sum[id]?>" months="<?=count($months)?>" <?=($i == $workers_counter ? "last" : "")?> data-id="<?=$sum[client_id]?>">
                            <td> <?=($i == $workers_counter ? "<img title='Добавить исполнителя' src='".VIEW."/img/add.png' />" : "")?></td>
                            <td><input disabled="disabled" type="text" size="4" name="days_count" value="" /></td>
                            <td></td>
                            <td><input disabled="disabled" type="text" size="4" name="plan_h" value="" /></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?endfor?>
            <?endforeach?>
        </tbody>
    </table>
    <table class="months">
        <thead>
        <tr>
            <?foreach($months as $item):?>
                <th class="month">
                    <?=$item?>
                </th>
            <?endforeach?>
        </tr>
        </thead>
        <tbody>
            <?foreach ($summ as $sum):?>
                <?$infos = $summary->get_info_by_id($sum[id]); $workers_counter = 4;?>
                <?foreach($infos as $key => $info):?>
                    <?
                        $dep_ = $dep->get_by_id($worker->get_dep_id_by_id($info[worker_id]));
                        $workers_counter--;
                    ?>
                    <tr key="<?=$key?>" sum-id="<?=$sum[id]?>" months="<?=count($months)?>" <?=((count($infos)-1 == $key) && ($workers_counter <= 0) ? "last" : "")?> dep-id="<?=$dep_[id]?>" worker-id="<?=$info[worker_id]?>" data-id="<?=$sum[client_id]?>">
                        <?foreach($months as $item):?>
                            <td><input type="text" placeholder="0,0" value="<?=$summary->calc_work_by_dates_id($month_ids[$item], $sum[client_id], $info[worker_id])?>" size="5" disabled="disabled" /></td>
                        <?endforeach?>
                    </tr>
                <?endforeach?>
                <?for($i = 1; $i <= $workers_counter; $i++):?>
                    <tr sum-id="<?=$sum[id]?>" months="<?=count($months)?>" <?=($i == $workers_counter ? "last" : "")?> data-id="<?=$sum[client_id]?>">
                        <?foreach($months as $item):?>
                            <td><input type="text" placeholder="0,0" value="" size="5" disabled="disabled" /></td>
                        <?endforeach?>
                    </tr>
                <?endfor?>
            <?endforeach?>
        </tbody>
    </table>
</div>
