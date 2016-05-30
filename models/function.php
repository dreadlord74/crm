<?php

/**
 * @param $date
 * @param string $descriptor
 * @return string
 * Преобразует дату в читаемый вид
 */
function change_date_view($date, $delimiter = "/"){

    $date = explode("-", $date);

    return $date[2].$delimiter.$date[1].$delimiter.$date[0];
}

function get_day_of_week($date){
    $days_of_week = array(
        1 => "пн",
        2 => "вт",
        3 => "ср",
        4 => "чт",
        5 => "пт",
        6 => "сб",
        0 => "вс"
    );

    $date = explode("-", $date);

    return $days_of_week[date("w", mktime(0, 0, 0, $date[1], $date[2], $date[0]))];
}

function get_month($date){
    $months = array(
        1 => "Январь",
        2 => "Февраль",
        3 => "Март",
        4 => "Апрель",
        5 => "Май",
        6 => "Июнь",
        7 => "Июль",
        8 => "Август",
        9 => "Сентябрь",
        10 => "Октябрь",
        11 => "Ноябрь",
        12 => "Декабрь"
    );

    $date = explode("-", $date);

    return $months[date("n", mktime(0, 0, 0, $date[1], $date[2], $date[0]))];
}

function work_type(&$id){
	$work_type = array(
		1 => "Сайт",
		2 => "СЕО",
		3 => "Реклама",
		4 => "Доработки"
	);
	
	return $work_type[$id];
}

/**
 * @param array $arr
 * Функция очищения вводимых данных
 */
function clear(array &$arr)
{
    $db = new data_base();
    foreach ($arr as $key => $item)
        if (is_array($item))
            clear($item);
        else
            $arr[$key] = strip_tags(mysqli_real_escape_string($db->get_id_db(), $item));
    unset($db);
}

function check_month(array &$dates, &$date)
{
    $db = new data_base();
    if (date)
        $res = $db->super_query("SELECT date FROM dates WHERE date='$date' AND id IN (".implode(", ", $dates).")");
    else
        $res = 0;

    return ($res ? 1: 0);
}