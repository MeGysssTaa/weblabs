<?php

require_once "lfs_ads_repository.php";
require_once "noticeboard_view.php";
handleNoticeboardRequest(new LocalFileSystemAdsRepository());
