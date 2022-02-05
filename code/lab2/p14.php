<?php

$a = 10;
$b = 3;

echo nl2br("{$a} mod {$b} is " . ($a % $b) . "\n");

if (($a % $b) === 0)
    echo nl2br("{$a} can be divided by {$b}. The result is " . ($a / $b) . "\n");
else
    echo nl2br("{$a} cannot be divided by {$b}. The remainder is " . ($a % $b) . "\n");

$st = 2**10;
$sqrt245 = sqrt(245.0);
$arr = [4, 2, 5, 19, 13, 0, 10];
$vecLen = 0.0;

foreach ($arr as $elem)
    $vecLen += $elem ** 2;

$vecLen = sqrt($vecLen);
echo nl2br("st={$st}, sqrt245={$sqrt245}, vecLen={$vecLen}\n");

$sqrt379 = sqrt(379.0);
echo nl2br("First three sqrt379 approximations: "
    . round($sqrt379) . ", "
    . round($sqrt379, 1) . ", "
    . round($sqrt379, 2)
    . "\n");

$sqrt587 = sqrt(587.0);
$rounded = [
    "floor" => floor($sqrt587),
    "ceil"  => ceil ($sqrt587)
];

echo nl2br("floor(sqrt587)={$rounded['floor']}, ceil(sqrt587)={$rounded['ceil']}\n");

$arr = [4, -2, 5, 19, -130, 0, 1];
echo nl2br("min=" . min($arr) . ", max=" . max($arr) . "\n");

echo nl2br("Random integer in range [1;100]: " . rand(1, 100) . "\n");

$arr = [];
echo "Array of some random integers:";

for ($i = 0; $i < 10; $i++) {
    $elem = $arr[$i] = rand();
    echo " " . $elem;
}

echo nl2br("\n");

echo nl2br("Testing abs diff or something\n");

for ($a = 1; $a < 3; $a++)
    for ($b = 3; $b < 5; $b++)
        echo nl2br("....abs({$a}-{$b})=" . abs($a - $b) . "\n");

$arr = [1, 2, -1, -2, 3, -3];

echo "Array of modules:";

foreach ($arr as $i => $elem) {
    $elem = $arr[$i] = abs($arr[$i]);
    echo " " . $elem;
}

echo nl2br("\n");

$num = 30;
$divisors = [];

echo nl2br("All divisors of number {$num}:\n");

for ($d = 1; $d ** 2 <= $num; $d++) {
    if (($num % $d) == 0) {
        $divisors[] = $d;
        $symmetric_d = $num / $d;

        echo nl2br("....{$d}\n");

        if ($symmetric_d !== $d) {
            $divisors[] = $symmetric_d;
            echo nl2br("....{$symmetric_d}\n");
        }
    }
}

$arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$sum = 0;

foreach ($arr as $i => $elem) {
    if (($sum += $elem) > 10) {
        echo nl2br("sum(arr, n=1.." . ($i + 1) . ") = {$sum}>10");
        break;
    }
}
