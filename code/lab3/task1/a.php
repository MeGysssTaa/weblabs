<?php

$regex = "/a..b/";
echo preg_match($regex, "ahb acb aeb aeeb adcb axeb"); // 1
