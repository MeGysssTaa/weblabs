<?php

require_once "gsheets_ads_repository.php";
require_once "../lab3/task3/noticeboard_view.php";
handleNoticeboardRequest("/lab4/noticeboard_v2.php", new GoogleSheetsAdsRepository());
