<?php

$my_num = printStringReturnNumber();
echo "my_num={$my_num}";

function printStringReturnNumber(): int {
    echo nl2br("Hiiii!!\n");
    return 123;
}
