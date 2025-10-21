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
}
