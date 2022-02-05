<?php

$num_languages = 4;
$months = 11;
$days = 16 * $months;
$days_per_language = $days / $num_languages;

echo "It takes Meg about {$days_per_language} days on average to learn a programming language.";
