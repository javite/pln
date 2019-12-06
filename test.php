<?php

// $array = array(111, 222, 444, 2);
// $array1 = ['nombre'=>'javi','hour_on'=> $array];
// $json = json_encode($array1);
// var_dump($json);
$test = '[20.1,0.0,12.3,23,53]';
$test = substr($test, 1, strlen($test)-2);
$array = explode(",", $test);
foreach ($array as $key => $value) {
    $array[$key] = floatval($value);
}
// $array = [];
// $i = 0;
// while (strpos($test, ',') > 0) {
//     $length = strpos($test, ',');
//     $data = substr($test, 1, $length-1);
//     $array[$i] = $data;
//     $test = str_replace($test, $data,'');
//     $i++;
//     echo($test);
// }
var_dump(json_encode($array));exit;

?>