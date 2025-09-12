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

    public function getCourseById($course_id){
        $this->db->query('SELECT * FROM courses WHERE id = :course_id');
        $this->db->bind(':course_id', $course_id);
        return $this->db->single();
    }

    public function searchCourses($searchTerm){
        $this->db->query('SELECT * FROM courses WHERE course_name LIKE :searchTerm OR class_code LIKE :searchTerm');
        $this->db->bind(':searchTerm', '%' . $searchTerm . '%');
        return $this->db->resultSet();
    }
}
