<?php

//Implémentations des variables de langue
namespace utils;

require_once __DIR__ . '/autoloader.php';

class Language
{
    private array $content = ["fr" => [], "en" => []];

    public function getContent(string $lang, string $page): ?array
    {
        return $this->content[$lang][$page];
    }
}
