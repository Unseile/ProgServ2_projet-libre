<?php

//Implémentations des variables de langue
namespace Utils;

require_once __DIR__ . '/autoloader.php';

class Language
{
    private array $content = [
        "fr" => [
            "home" => [
                "first-content" => "Bienvenue sur speep.ch !"
            ]
        ],
        "en" => [
            "home" => [
                "first-content" => "Welcome on speep.ch !"
            ]
        ]
    ];

    public function getContent(string $lang, string $page): ?array
    {
        return $this->content[$lang][$page];
    }
}
