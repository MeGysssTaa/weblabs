<?php

require_once "mysql_ads_repository.php";
require_once "../lab3/task3/noticeboard_view.php";

$adsRepo = new MySqlAdsRepository();
handleNoticeboardRequest("/lab5/noticeboard_v3.php", $adsRepo);
$adsRepo->tearDown();
