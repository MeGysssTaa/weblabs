<?php

require_once "/vendor/autoload.php";
require_once "../lab3/task3/ads.php";

class MySqlAdsRepository implements AdsRepository {

    private mysqli $db;

    public function __construct() {
        $this->db = new mysqli(
            "db", // mysql container name?
            getenv("PHP_MYSQL_USER"),
            getenv("PHP_MYSQL_PASS"),
            getenv("PHP_MYSQL_DB")
        );

        if (mysqli_connect_errno())
            throw new mysqli_sql_exception();
    }

    public function listCategories(): array {
        $query = "select distinct category from ad";
        $categories = [];

        if ($result = $this->db->query($query))
            while ($row = $result->fetch_assoc())
                $categories[] = $row["category"];

        return $categories;
    }

    public function listAds(string $category): array {
        $query = "select * from ad where category = '$category'";
        $ads = [];

        if ($result = $this->db->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $ads[] = new Ad(
                    $row["category"],
                    $row["title"],
                    $row["description"],
                    $row["email"]
                );
            }
        }

        return $ads;
    }

    public function saveAd(Ad $ad): bool {
        $stmt = $this->db->prepare("
            insert into ad 
            (email, title, description, category) 
            values (?, ?, ?, ?)
        ");

        $email = $ad->getContactEmail();
        $title = $ad->getTitle();
        $description = $ad->getDescription();
        $category = $ad->getCategory();

        return $stmt->bind_param("ssss", $email, $title, $description, $category)
            && $stmt->execute()
            && $stmt->close();
    }

    public function tearDown() {
        $this->db->close();
    }

}
