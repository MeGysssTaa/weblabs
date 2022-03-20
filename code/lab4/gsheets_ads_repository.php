<?php

require_once "/vendor/autoload.php";
require_once "../lab3/task3/ads.php";

class GoogleSheetsAdsRepository implements AdsRepository {

    private const CATEGORY_INDEX = 0;
    private const TITLE_INDEX    = 1;
    private const DESC_INDEX     = 2;
    private const EMAIL_INDEX    = 3;

    private Google\Service\Sheets $service;
    private string $spreadsheetId;

    /**
     * Required envs:
     *
     * GOOGLE_APPLICATION_CREDENTIALS
     * OVITO_SPREADSHEET_ID
     */
    public function __construct() {
        $client = new Google\Client();
        $client->setApplicationName("Ovito");
        $client->setScopes(Google\Service\Sheets::SPREADSHEETS);
        $client->useApplicationDefaultCredentials();

        $this->service = new Google\Service\Sheets($client);
        $this->spreadsheetId = getenv("OVITO_SPREADSHEET_ID");
    }

    public function listCategories(): array {
        $nonDistinctCats = $this->service->spreadsheets_values
            ->get($this->spreadsheetId, "ads!A2:A")
            ->getValues();

        return array_values(array_unique(array_merge([], ...$nonDistinctCats)));
    }

    public function listAds(string $category): array {
        $ads = [];
        $all = $this->service->spreadsheets_values
            ->get($this->spreadsheetId, "ads!A2:D")
            ->getValues();

        foreach ($all as $ad) {
            if ($ad[self::CATEGORY_INDEX] === $category) {
                $ads[] = new Ad(
                    $category,
                    $ad[self::TITLE_INDEX],
                    $ad[self::DESC_INDEX],
                    $ad[self::EMAIL_INDEX]
                );
            }
        }

        return $ads;
    }

    public function saveAd(Ad $ad): bool {
        try {
            $newRow = 1 + sizeof($this->service->spreadsheets_values
                    ->get($this->spreadsheetId, "ads!A1:A")
                    ->getValues());

            $newCells = [[
                self::CATEGORY_INDEX => $ad->getCategory(),
                self::TITLE_INDEX => $ad->getTitle(),
                self::DESC_INDEX => $ad->getDescription(),
                self::EMAIL_INDEX => $ad->getContactEmail()
            ]];

            $insertionRange = "A{$newRow}:D${newRow}";
            $requestBody = new Google_Service_Sheets_ValueRange(["values" => $newCells]);
            $requestParams = ["valueInputOption" => "RAW"];
            $result = $this->service->spreadsheets_values
                ->update($this->spreadsheetId, $insertionRange, $requestBody, $requestParams);

            return $result->getUpdatedCells() === 4;
        } catch (Exception $e) {
            return false;
        }
    }

    public function tearDown() {}

}
