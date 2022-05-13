<?php

require_once "ads.php";

$DEFAULT_HANDLER = fn($_, $__) => notFound();
$HANDLERS = [
    "GET" => fn($url, $adsRepo) => get($url, $adsRepo),
    "POST" => fn($url, $adsRepo) => post($url, $adsRepo),
];

function handleNoticeboardRequest(string $url, AdsRepository $adsRepo) {
    global $DEFAULT_HANDLER, $HANDLERS;
    $handle = $HANDLERS[$_SERVER['REQUEST_METHOD']] ?? $DEFAULT_HANDLER;
    $handle($url, $adsRepo);
}

function get(string $url, AdsRepository $adsRepo) {
    $html = file_get_contents("/code/private/lab3/task3/noticeboard-skeleton.html");
    $categoriesListHtml = "";
    $adsTableHtml = "";
    populateWithData($categoriesListHtml, $adsTableHtml, $adsRepo);
    $html = str_replace("<!-- %%__URL__%% -->", $url, $html);
    $html = str_replace("<!-- %%__CATEGORIES__%% -->", $categoriesListHtml, $html);
    $html = str_replace("<!-- %%__ADS__%% -->", $adsTableHtml, $html);
    echo $html;
}

function populateWithData(string& $categoriesListHtml, string& $adsTableHtml, AdsRepository $adsRepo) {
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

function notFound() {
    http_response_code(404);
    echo "Not Found";
}

function internalServerError() {
    http_response_code(500);
    echo "Internal Server Error";
}
