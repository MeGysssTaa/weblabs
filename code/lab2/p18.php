<?php /** @noinspection PhpConditionAlreadyCheckedInspection */


$test = 0;

// Daniel
if ($test == 0) {
    echo nl2br("correct\n");;
}

// The cooler Daniel
echo $test == 0 ? nl2br("correct\n") : "";

$age = 19;

if ($age < 10)
    echo nl2br("Too young!\n");
else if ($age > 99)
    echo nl2br("Too old!\n");
else {
    $digitsSum = 0;

    while ($age > 0) {
        $digitsSum += $age % 10;
        $age /= 10;
    }

    echo nl2br("Sum of digits in your age consists of "
        . ($age <= 9 ? "one digit" : "two digits")
        . "\n");
}

$arr = [1, 2, 3];

if (count($arr) === 3)
    echo array_sum($arr);


function isSumGt10(int $a, int $b): bool {
    return $a + $b > 10;
}

function equals(int $a, int $b): bool {
    return $a === $b;
}
