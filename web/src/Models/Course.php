<?php

//Implémentations de la logique de l'objet cours
namespace Models;

require_once __DIR__ . '../utils/autoloader.php';


class Course
{
    private int $id;
    private int $teacherId;
    private string $title;
    private string $subject;
    private string $startDatetime;
    private string $duration;
    private string $descr;
    private string $location;
    private float $pricePerStudent;
    private int $maxStudents;
    private int $subStudents;

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

    public function getTeacherId(bool $specialCharacters = false): ?int
    {
        if (isset($this->teacherId) && is_int($this->teacherId)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->teacherId);
            } else {
                return $this->teacherId;
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

    public function getStartDatetime(bool $specialCharacters = false): ?string
    {
        if (isset($this->startDatetime) && is_string($this->startDatetime)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->startDatetime);
            } else {
                return $this->startDatetime;
            }
        }
        return '';
    }

    public function getDuration(bool $specialCharacters = false): ?string
    {
        if (isset($this->duration) && is_string($this->duration)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->duration);
            } else {
                return $this->duration;
            }
        }
        return '';
    }

    public function getDescr(bool $specialCharacters = false): ?string
    {
        if (isset($this->descr) && is_string($this->descr)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->descr);
            } else {
                return $this->descr;
            }
        }
        return '';
    }

    public function getLocation(bool $specialCharacters = false): ?string
    {
        if (isset($this->location) && is_string($this->location)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->location);
            } else {
                return $this->location;
            }
        }
        return '';
    }

    public function getPricePerStudent(bool $specialCharacters = false): ?float
    {
        if (isset($this->pricePerStudent) && is_float($this->pricePerStudent)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->pricePerStudent);
            } else {
                return $this->pricePerStudent;
            }
        }
        return '';
    }

    public function getMaxStudents(bool $specialCharacters = false): ?int
    {
        if (isset($this->maxStudents) && is_int($this->maxStudents)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->maxStudents);
            } else {
                return $this->maxStudents;
            }
        }
        return '';
    }

    public function getSubStudents(bool $specialCharacters = false): ?int
    {
        if (isset($this->subStudents) && is_int($this->subStudents)) {
            if ($specialCharacters) {
                return htmlspecialchars($this->subStudents);
            } else {
                return $this->subStudents;
            }
        }
        return '';
    }
}
