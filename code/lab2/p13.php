<?php

$my_num = 123;
$answer = $my_num;

$answer += 2;
$answer *= 2;
$answer -= 2;
$answer /= 2;
$answer -= $my_num;

echo $answer;

if ($answer === 1)
    echo " <<< AAayy mAGiC";
