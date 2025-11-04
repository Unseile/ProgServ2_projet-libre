<?php

//Implémentations de la logique de l'objet cours
namespace Models;

require_once __DIR__ . '/../Config/autoloader.php';

use DateTime;

const SCHOOL_SUBJECT = [
    'Anglais',
    'AnalysMar',
    'MarkDig',
    'ComVisuel',
    'EcrireWeb',
    'ProdCondMé1',
    'BaseProg',
    'BaseMath',
    'DeDonAInf',
    'Droit1',
    'EvolMétMéd',
    'GesBudget',
    'IntroDura',
    'InfraDon1',
    'ProgServ1'
];
class Course
{
    private int $id;
    private int $teacherId;
    private string $title;
    private string $subject;
    private string $startDatetime;
    private int $duration;
    private string $descr;
    private string $location;
    private float $pricePerStudent;
    private int $maxStudents;
    private int $subStudents;

    public function __construct(
        int $teacherId,
        string $title,
        string $subject,
        string $startDatetime,
        string $duration,
        string $descr,
        string $location,
        float $pricePerStudent,
        int $maxStudents,
        int $subStudents = 0
    ) {
        $this->teacherId = $teacherId;
        $this->title = trim($title);
        $this->subject = trim($subject);
        $this->startDatetime = trim($startDatetime);
        $this->duration = $duration;
        $this->descr = trim($descr);
        $this->location = trim($location);
        $this->pricePerStudent = $pricePerStudent;
        $this->maxStudents = $maxStudents;
        $this->subStudents = $subStudents;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function verify(): array
    {
        $errors = [];
        if (empty($this->teacherId)) {
            array_push($errors, "Un enseignant doit exister");
        }
        if (empty($this->title) || strlen($this->title) < 2) {
            array_push($errors, "Le titre est obligatoire et doit avoir 5 caractèrs minimum");
        }
        if (!isset($this->subject) || !array_find(SCHOOL_SUBJECT, $this->subject)) {
            array_push($errors, "Le sujet de cours n'existe pas");
        }

        if (empty($this->startDatetime)) {
            array_push($errors, "La date et l'heure de début sont obligatoires");
        } else {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $this->startDatetime)) {
                array_push($errors, "Le format de la date doit être YYYY-MM-DDThh:mm");
            } else {
                $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $this->startDatetime);
                if (!$dateTime || $dateTime->format('Y-m-d\TH:i') !== $this->startDatetime) {
                    array_push($errors, "La date et l'heure spécifiées ne sont pas valides");
                }
                if ($dateTime < new DateTime()) {
                    array_push($errors, "La date de début ne peut pas être dans le passé");
                }
            }
        }
        if (empty($this->duration) || !is_int($this->duration) || $this->duration < 15) {
            array_push($errors, "La durée du cours est obligatoire et doit être supérieure à 15mn");
        }
        if (empty($this->descr)) {
            array_push($errors, "La description est obligatoire");
        }
        if (empty($this->location)) {
            array_push($errors, "La salle est obligatoire");
        }
        if (empty($this->pricePerStudent) || !is_float($this->pricePerStudent) || $this->pricePerStudent < 0) {
            array_push($errors, "Le prix est obligatoire et ne peut pas être négatif. 0 = gratuit");
        }
        if (empty($this->maxStudents) || !is_float($this->maxStudents) || $this->maxStudents < 1 || $this->maxStudents > 30) {
            array_push($errors, "Le nombre max d'élèves est de 30. Min 1");
        }

        return $errors;
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
