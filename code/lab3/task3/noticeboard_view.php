<?php

require_once "ads.php";

function handleNoticeboardRequest(string $url, AdsRepository $adsRepo) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            get($url, $adsRepo);
            break;

        case "POST":
            post($url, $adsRepo);
            break;

        default:
            http_response_code(404);
            echo "Not Found";
    }

    $adsRepo->tearDown();
}

function get(string $url, AdsRepository $adsRepo) {
    $html = file_get_contents("/code/private/lab3/task3/noticeboard-skeleton.html");
    $categoriesListHtml = "";
    $adsTableHtml = "";

    foreach ($adsRepo->listCategories() as $category) {
        $categoriesListHtml .= "<option value=\"$category\">$category</option>";
        $ads = $adsRepo->listAds($category);

        foreach ($ads as $ad) {
            $desc = nl2br($ad->getDescription());
            $adsTableHtml .= "
                <tr>
                    <td>$category</td>
                    <td>{$ad->getTitle()}</td>
                    <td>$desc</td>
                    <td>{$ad->getContactEmail()}</td>
                </tr>
            ";
        }
    }

    $html = str_replace("<!-- %%__URL__%% -->", $url, $html);
    $html = str_replace("<!-- %%__CATEGORIES__%% -->", $categoriesListHtml, $html);
    $html = str_replace("<!-- %%__ADS__%% -->", $adsTableHtml, $html);

    echo $html;
}

function post(string $url, AdsRepository $adsRepo) {
    if (!isset($_POST["email"]) || !isValidPath($_POST["email"])
        || !isset($_POST["category"]) || !isValidPath($_POST["category"])
        || !isset($_POST["title"]) || !isValidPath($_POST["title"])
        || !isset($_POST["desc"]))
    {
        http_response_code(400);
        echo "Bad Request";
        return;
    }

    $ad = new Ad($_POST["category"], $_POST["title"], $_POST["desc"], $_POST["email"]);

    if ($adsRepo->saveAd($ad))
        header("Refresh:0");
    else {
        http_response_code(500);
        echo "Internal Server Error";
    }
}

function isValidPath(string $path): bool {
    return strlen($path) > 0
        && strpos($path, "/") === false
        && strpos($path, "..") === false;
}
