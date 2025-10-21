<?php

class Database{
    const DATABASE_FILE = __DIR__ . '/../../progserv2.db';

    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("sqlite:" . self::DATABASE_FILE);

        $sql = "CREATE TABLE IF NOT EXISTS person (
            id SERIAL PRIMARY KEY AUTOINCREMENT,
            last_name VARCHAR(40) NOT NULL,
            first_name VARCHAR(40) NOT NULL,
            username VARCHAR(40) NOT NULL UNIQUE,
            mail VARCHAR(40) NOT NULL
        );
        
        CREATE TABLE IF NOT EXISTS course (
            id SERIAL PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(40) NOT NULL,
            matière ENUM('BaseProg1', 'BaseMath1','DeDonAInf1','FondMedias','ComHum','IntNeuro','OutMéth','MarkDig1','MarDévProd','RechAnPub','DocWeb','RésEnv','Ang1','MedSerGam') NOT NULL,
            start_date_hour DATETIME NOT NULL,
            duration INT NOT NULL,
            description TEXT,
            location VARCHAR(40) NOT NULL,
            price_per_student DECIMAL(5,2) NOT NULL,
            number_students_max INT NOT NULL
        )
        
        CREATE TABLE IF NOT EXISTS student_course (
            id SERIAL PRIMARY KEY AUTOINCREMENT,
            fk_course INT NOT NULL,
            fk_person INT NOT NULL,
            number_of_students INTEGER NOT NULL,
            FOREIGN KEY (course_id) REFERENCES course(id),
            FOREIGN KEY (person_id) REFERENCES person(id)
        );";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();
    }

    public function getPdo(): PDO {
        return $this->pdo;
    }
}
