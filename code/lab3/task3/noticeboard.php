<?php


switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        get();
        break;

    case "POST":
        post();
        break;

    default:
        http_response_code(404);
        echo "Not Found";
}


function get() {
    $html = file_get_contents("/code/private/lab3/task3/noticeboard-skeleton.html");
    $categoriesListHtml = "";
    $adsTableHtml = "";

    foreach (listCategories() as $category) {
        $categoriesListHtml .= "<option value=\"$category\">$category</option>";
        $ads = listAds($category);

        foreach ($ads as $adsFromEmail) {
            foreach ($adsFromEmail as $ad) {
                $adsTableHtml .= "
                    <tr>
                        <td>$category</td>
                        <td>{$ad->getTitle()}</td>
                        <td>{$ad->getDescription()}</td>
                        <td>{$ad->getContactEmail()}</td>
                    </tr>
                ";
            }
        }
    }

    $html = str_replace("<!-- %%__CATEGORIES__%% -->", $categoriesListHtml, $html);
    $html = str_replace("<!-- %%__ADS__%% -->", $adsTableHtml, $html);

    echo $html;
}

function ls(string $dirPath): array {
    $children = scandir($dirPath);
    return $children === false ? [] : array_diff($children, array('.', '..'));
}

function listCategories(): array {
    return ls("/data/noticeboard/");
}

function listAds(string $category): array {
    $emails = ls("/data/noticeboard/$category");
    $ads = [];

    foreach ($emails as $email) {
        $adsFromEmail = [];
        $adFiles = ls("/data/noticeboard/$category/$email");

        foreach ($adFiles as $adFile) {
            $adDesc = file_get_contents("/data/noticeboard/$category/$email/$adFile");

            if ($adDesc !== false) {
                $adTitle = substr($adFile, 0, strlen($adFile) - strlen(".txt"));
                $adsFromEmail[] = new Ad($adTitle, nl2br($adDesc), $email);
            }
        }

        if (count($adsFromEmail) > 0)
            $ads[$email] = $adsFromEmail;
    }

    return $ads;
}

function post() {
    if (!isset($_POST["email"]) || !isValidPath($_POST["email"])
        || !isset($_POST["category"]) || !isValidPath($_POST["category"])
        || !isset($_POST["title"]) || !isValidPath($_POST["title"])
        || !isset($_POST["desc"]))
    {
        http_response_code(400);
        echo "Bad Request";
        return;
    }

    $adDir = "/data/noticeboard/{$_POST['category']}/{$_POST['email']}";
    $adFile = "$adDir/{$_POST['title']}.txt";

    if (file_exists($adFile)) {
        http_response_code(409);
        echo "Conflict";
        return;
    }

    $saveSuccess = mkdir($adDir, 0700, true) // 7 for "rwx" (all three are required)
        && file_put_contents($adFile, $_POST["desc"]);

    if (!$saveSuccess) {
        http_response_code(500);
        echo "Internal Server Error";
        return;
    }

    header("Refresh:0");
}

function isValidPath(string $path): bool {
    return strlen($path) > 0
        && strpos($path, "/") === false
        && strpos($path, "..") === false;
}


class Ad {
    private string $title, $description, $contactEmail;

    function __construct(string $title, string $description, string $contactEmail) {
        $this->title = $title;
        $this->description = $description;
        $this->contactEmail = $contactEmail;
    }

    /** @noinspection PhpUnused */
    public function getTitle(): string {
        return $this->title;
    }

    /** @noinspection PhpUnused */
    public function getDescription(): string {
        return $this->description;
    }

    /** @noinspection PhpUnused */
    public function getContactEmail(): string {
        return $this->contactEmail;
    }
}
