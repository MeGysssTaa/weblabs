<?php

class Ad {
    private string $category, $title, $description, $contactEmail;

    function __construct(string $category, string $title, string $description, string $contactEmail) {
        $this->category = $category;
        $this->title = $title;
        $this->description = $description;
        $this->contactEmail = $contactEmail;
    }

    public function getCategory(): string {
        return $this->category;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getContactEmail(): string {
        return $this->contactEmail;
    }
}

interface AdsRepository {
    public function listCategories(): array;
    public function listAds(string $category): array;
    public function saveAd(Ad $ad): bool;
    public function tearDown();
}
