<?php


$arr = [5, 5, 4, 4];
echo nl2br("mean=" . (array_sum($arr) / count($arr)) . "\n");

echo nl2br("sum(n=1..100)=" . array_sum(range(1, 100)) . "\n");

$arr = [4, 9, 25, 1024];
$sqrtsArr = array_map(fn($elem) => sqrt($elem), $arr);
printArray($arr);
printArray($sqrtsArr);

$alphabet = [];
$range = range(1, 26);

array_walk($range, function($i) use (&$alphabet) {
    $char = chr(ord('a') + $i - 1);
    $alphabet[$char] = $i;
});

foreach ($alphabet as $k => $v)
    echo $k . ":" . $v . "  ";
echo nl2br("\n");

$str = "1234567890";
$range = range(0, strlen($str), 2);
$digitPairsSum = 0;

array_walk($range, function($i) use ($str, &$digitPairsSum) {
    $digitPairsSum += intval(substr($str, $i, 2));
});

echo "digitPairsSum={$digitPairsSum}";


function printArray(array $arr) {
    foreach ($arr as $elem)
        echo $elem . " ";
    echo nl2br("\n");
}
