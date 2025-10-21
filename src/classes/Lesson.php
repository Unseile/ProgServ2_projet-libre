<?php

//Implémentations de la logique de l'objet cours
namespace classes;

require_once __DIR__ . '../utils/autoloader.php';


class Lesson
{
    private int $id;
    private int $teacherId;
    private string $title;
    private string $subject;
    private string $startDatetime;
    private string $endDatetime;
    private string $descr;
    private string $location;
    private float $pricePerStudent;
    private int $maxStudents;

    public function __construct(/* args*/): void {}
    public function verify(): array
    {
        return [];
    }
    public function getId(bool $specialCharacters = false): ?int
    {
        if (isset($this->id) && is_int($this->id)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->id);
            } else {
                return $this->id;
            }
        }
        return '';
    }

    public function getTitle(bool $specialCharacters = false): ?string
    {
        if (isset($this->title) && is_string($this->title)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->title);
            } else {
                return $this->title;
            }
        }
        return '';
    }

    public function getSubject(bool $specialCharacters = false): ?string
    {
        if (isset($this->subject) && is_string($this->subject)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->subject);
            } else {
                return $this->subject;
            }
        }
        return '';
    }
}
