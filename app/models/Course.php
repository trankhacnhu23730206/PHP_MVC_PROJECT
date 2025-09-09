<?php
class Course {
    private $db;

    public function __construct(){
        $this->db = new Database; // Assuming Database class is available globally or via dependency injection
    }

    public function getAllCourses(){
        $this->db->query('SELECT * FROM courses');
        return $this->db->resultSet();
    }
}
