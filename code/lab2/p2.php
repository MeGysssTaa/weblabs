<?php

$answer = 42;
echo nl2br("answer={$answer}\n");

$pi = 3.14;
echo nl2br("pi={$pi}\n");

echo nl2br("twelve=" . ($answer - 30) . "\n");

$last_month = 1187.23;
$this_month = 1089.98;
echo nl2br("Last month I spent " . ($last_month - $this_month) . " more than this month.\n");
