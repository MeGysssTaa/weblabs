<?php


echo nl2br(increaseEnthusiasm("Almost finished the second lab") . "\n");
echo nl2br(repeatThreeTimes("hehe") . "\n");
echo nl2br(increaseEnthusiasm(repeatThreeTimes("SEGFAULT")) . "\n");
echo nl2br("cut(hello)=" . cut("hello") . "\n");
echo nl2br("cut(hello, 3)=" . cut("hello", 3) . "\n");

$arr = [1, 2, 3, 4, 5];
printRecursively($arr);

echo "something: " . burnCpu(56);


function increaseEnthusiasm(string $input): string {
    return $input . "!";
}

function repeatThreeTimes(string $input): string {
    return $input . $input . $input;
}

function cut(string $input, int $maxLen = 10): string {
    $end = min(strlen($input), $maxLen);
    $result = "";

    for ($i = 0; $i < $end; $i++)
        $result .= $input[$i];

    return $result;
}

function printRecursively(array $arr, int $off = 0) {
    if ($off == count($arr))
        return;

    echo $arr[$off] . " ";
    printRecursively($arr, $off + 1);

    if ($off == 0)
        echo nl2br("\n");
}

function burnCpu(int $num): int {
    $digitsSum = 0;

    while ($num > 0) {
        $digitsSum += $num % 10;
        $num /= 10;
    }

    return $digitsSum > 9 ? burnCpu($digitsSum) : $digitsSum;
}
