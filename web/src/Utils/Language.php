<?php

//Implémentations des variables de langue
namespace Utils;

require_once __DIR__ . '/../Config/autoloader.php';

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

    public function setCookieLanguage(string $lang): void
    {
        setcookie('language', $lang, time() + (86400 * 30));
    }

    public function getCookieLanguage(): ?string
    {
        return $_COOKIE['language'] ?? 'fr';
    }

    public function getAvailableLanguages(): array
    {
        return array_keys($this->content);
    }
}
