<?php
function get_decimal(string $str) {
    $parts_number = explode(',', $str);
    $int_part = (int) $parts_number[0];
    $float_part = (double) $parts_number[1]*10**-2;
    $result = $int_part + $float_part;
    return $result;
}