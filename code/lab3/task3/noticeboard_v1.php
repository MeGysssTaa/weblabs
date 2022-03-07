<?php

require_once "lfs_ads_repository.php";
require_once "noticeboard_view.php";
handleNoticeboardRequest("/lab3/task3/noticeboard_v1.php", new LocalFileSystemAdsRepository());
