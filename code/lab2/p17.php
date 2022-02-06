<?php


$size = 5;
$arr = ["x"];

for ($i = 1; $i < $size; $i++)
    $arr[$i] = $arr[$i - 1] . "x";

printArray($arr);

printArray(arrayFill("x", 5));

$arr = [[1, 2, 3], [4, 5], [6]];
$sum = 0;

foreach ($arr as $subArr)
    $sum += array_sum($subArr);

echo nl2br("sum={$sum}\n");

$arr = [];

for ($i = 0; $i < 3; $i++) {
    $subArr = [];

    for ($j = 0; $j < 3; $j++)
        $subArr[] = 3 * $i + $j + 1;

    $arr[] = $subArr;
    printArray($subArr);
}

$arr = [2, 5, 3, 9];
$result = $arr[0] * $arr[1] + $arr[2] * $arr[3];
echo nl2br("result={$result}\n");

$user = [
    "name" => "German",
    "surname" => "Vekhorev",
    "patronymic" => "Kakoytovich"
];

echo nl2br("{$user['surname']} {$user['name']} {$user['patronymic']}\n");

$date = getdate();
$date = [
    "year" => $date["year"],
    "month" => $date["mon"],
    "day" => $date["mday"]
];

echo nl2br("date={$date['year']}-{$date['month']}-{$date['day']}\n");

$arr = ['a','b','c','d','e'];
echo nl2br("size=" . count($arr) . "\n");
echo nl2br("last={$arr[count($arr) - 1]}\n");
echo nl2br("penultimate={$arr[count($arr) - 2]}\n");


function printArray(array $arr) {
    foreach ($arr as $elem)
        echo $elem . " ";
    echo nl2br("\n");
}

function arrayFill(string $value, int $size): array {
    $arr = [];

    for ($i = 0; $i < $size; $i++)
        $arr[] = $value;

    return $arr;
}
