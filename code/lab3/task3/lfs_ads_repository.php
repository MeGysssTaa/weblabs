<?php

require_once "ads.php";

class LocalFileSystemAdsRepository implements AdsRepository {

    public function listCategories(): array {
        return $this->ls("/data/noticeboard/");
    }

    public function listAds(string $category): array {
        $emails = $this->ls("/data/noticeboard/$category");
        $ads = [];

        foreach ($emails as $email) {
            $adsFromEmail = [];
            $adFiles = $this->ls("/data/noticeboard/$category/$email");

            foreach ($adFiles as $adFile) {
                $adDesc = file_get_contents("/data/noticeboard/$category/$email/$adFile");

                if ($adDesc !== false) {
                    $adTitle = substr($adFile, 0, strlen($adFile) - strlen(".txt"));
                    $adsFromEmail[] = new Ad($category, $adTitle, $adDesc, $email);
                }
            }

            if (count($adsFromEmail) > 0)
                $ads[$email] = $adsFromEmail;
        }

        return $ads;
    }

    public function saveAd(Ad $ad): bool {
        $adDir = "/data/noticeboard/{$ad->getCategory()}/{$ad->getContactEmail()}";
        $adFile = "$adDir/{$ad->getTitle()}.txt";

        return !file_exists($adFile)
            && mkdir($adDir, 0700, true)
            && file_put_contents($adFile, $ad->getDescription());
    }

    private function ls(string $dirPath): array {
        $children = scandir($dirPath);
        return $children === false ? [] : array_diff($children, array('.', '..'));
    }

}
