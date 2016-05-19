<script type="text/javascript" src="<?=VIEW?>/js/summary.js"></script>
<div class="content">
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
        <?foreach($summary->get_all() as $sum):?>
            <?$cl = $client->get_by_id($sum[client_id])?>
            <tr data-id="<?=$sum[client_id]?>">
                <td style="background: <?=$cl[color]?>; color: <?=$cl[text_color]?>" class="client">
                    <?=$cl[name]?>
                </td>
            </tr>
            <tr>
                <td><input type="text" name="hours" size="4" value="<?=$sum[hours]?>" /></td>
                <td>78,1</td>
            </tr>
            <tr>
                <td>превышено</td>
                <td>-</td>
            </tr>
            <tr>
                <td>нач. факт</td>
                <td>оконч. дог.</td>
            </tr>
            <tr>
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
            <th class="prognoz">
                Прогноз превыш.
            </th>
            <th class="ost">
                Остаток/потери
            </th>
        </tr>
        </thead>
        <tbody>
        <tr data-id="1">
            <td>СЕО (Алина)</td>
            <td>5</td>
            <td class="lost">21.05.12</td>
            <td>40</td>
            <td>41.0</td>
            <td have-more>1</td>
            <td class="lost">-1</td>
        </tr>
        <tr data-id="1">
            <td>Дизайнер (Артём)</td>
            <td>5</td>
            <td class="lost">21.05.12</td>
            <td>40</td>
            <td>40.0</td>
            <td></td>
            <td>0</td>
        </tr>
        <tr data-id="1">
            <td>Программист (Данил)</td>
            <td>5</td>
            <td>21.05.12</td>
            <td>40</td>
            <td>41.0</td>
            <td have-more>1</td>
            <td class="lost">-1</td>
        </tr>
        <tr data-id="1" last>
            <td>Программист (Василий)</td>
            <td>5</td>
            <td>21.05.12</td>
            <td>40</td>
            <td>40.0</td>
            <td></td>
            <td>0</td>
        </tr>
        <tr data-id="2">
            <td>СЕО (Алина)</td>
            <td>5</td>
            <td class="lost">21.05.12</td>
            <td>40</td>
            <td>41.0</td>
            <td have-more>1</td>
            <td class="lost">-1</td>
        </tr>
        <tr data-id="2">
            <td>Прототип (Алёна)</td>
            <td>5</td>
            <td class="lost">21.05.12</td>
            <td>40</td>
            <td>41.0</td>
            <td have-more>1</td>
            <td class="lost">-1</td>
        </tr>
        <tr data-id="2">
            <td>Дизайнер (Артём)</td>
            <td>5</td>
            <td class="lost">21.05.12</td>
            <td>40</td>
            <td>40.0</td>
            <td></td>
            <td>0</td>
        </tr>
        <tr data-id="2">
            <td>Программист (Данил)</td>
            <td>5</td>
            <td>21.05.12</td>
            <td>40</td>
            <td>41.0</td>
            <td have-more>1</td>
            <td class="lost">-1</td>
        </tr>
        <tr data-id="2" last>
            <td>Программист (Василий)</td>
            <td>5</td>
            <td>21.05.12</td>
            <td>40</td>
            <td>40.0</td>
            <td></td>
            <td>0</td>
        </tr>
        <tr data-id="3">
            <td>СЕО (Алина)</td>
            <td>5</td>
            <td class="lost">21.05.12</td>
            <td>40</td>
            <td>41.0</td>
            <td have-more>1</td>
            <td class="lost">-1</td>
        </tr>
        <tr data-id="3">
            <td>Прототип (Алёна)</td>
            <td>5</td>
            <td class="lost">21.05.12</td>
            <td>40</td>
            <td>41.0</td>
            <td have-more>1</td>
            <td class="lost">-1</td>
        </tr>
        <tr data-id="3">
            <td>Дизайнер (Артём)</td>
            <td>5</td>
            <td class="lost">21.05.12</td>
            <td>40</td>
            <td>40.0</td>
            <td></td>
            <td>0</td>
        </tr>
        <tr data-id="3">
            <td>Программист (Данил)</td>
            <td>5</td>
            <td>21.05.12</td>
            <td>40</td>
            <td>41.0</td>
            <td have-more>1</td>
            <td class="lost">-1</td>
        </tr>
        <tr data-id="3" last>
            <td>Программист (Василий)</td>
            <td>5</td>
            <td>21.05.12</td>
            <td>40</td>
            <td>40.0</td>
            <td></td>
            <td>0</td>
        </tr>
        </tbody>
    </table>
    <table class="months">
        <thead>
        <tr>
            <th class="month">
                Окт.-15
            </th>
            <th class="month">
                Окт.-15
            </th>
            <th class="month">
                Окт.-15
            </th>
            <th class="month">
                Окт.-15
            </th>
            <th class="month">
                Окт.-15
            </th>
            <th class="month">
                Окт.-15
            </th>
            <th class="month">
                Окт.-15
            </th>
            <th class="month">
                Окт.-15
            </th>
            <th class="month">
                Окт.-15
            </th>
            <th class="month">
                Окт.-15
            </th>
            <th class="month">
                Окт.-15
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr last>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr last>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        <tr last>
            <td><input type="text" placeholder="0,0" value="23" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
            <td><input type="text" placeholder="0,0" size="3" disabled="disabled" /></td>
        </tr>
        </tbody>
    </table>
</div>
