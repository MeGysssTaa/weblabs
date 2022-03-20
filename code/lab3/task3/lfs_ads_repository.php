<?php

require_once "ads.php";

class LocalFileSystemAdsRepository implements AdsRepository {

    private string $ext = ".txt";

    public function listCategories(): array {
        return $this->ls("/data/noticeboard/");
    }

    public function listAds(string $category): array {
        $emails = $this->ls("/data/noticeboard/$category");
        $ads = [];

        foreach ($emails as $email) {
            $adFiles = $this->ls("/data/noticeboard/$category/$email");

            foreach ($adFiles as $adFile) {
                $adDesc = file_get_contents("/data/noticeboard/$category/$email/$adFile");

                if ($adDesc !== false) {
                    $adTitle = substr($adFile, 0, strlen($adFile) - strlen($this->ext));
                    $ads[] = new Ad($category, $adTitle, $adDesc, $email);
                }
            }
        }

        return $ads;
    }

    public function saveAd(Ad $ad): bool {
        $adDir = "/data/noticeboard/{$ad->getCategory()}/{$ad->getContactEmail()}";
        $adFile = "$adDir/{$ad->getTitle()}$this->ext";

        return !file_exists($adFile)
            && mkdir($adDir, 0700, true)
            && file_put_contents($adFile, $ad->getDescription());
    }

    private function ls(string $dirPath): array {
        $children = scandir($dirPath);
        return $children === false ? [] : array_diff($children, array('.', '..'));
    }

    public function tearDown() {}

}
