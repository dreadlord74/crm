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