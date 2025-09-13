<?php
class Course {
    private $db;

    public function __construct(){
        $this->db = new Database; // Assuming Database class is available globally or via dependency injection
    }

    public function getAllCourses(){
        $this->db->query('SELECT * FROM courses ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getCourseById($course_id){
        $this->db->query('SELECT * FROM courses WHERE id = :course_id');
        $this->db->bind(':course_id', $course_id);
        return $this->db->single();
    }

    public function findCourseByClassCode($class_code){
        $this->db->query('SELECT * FROM courses WHERE class_code = :class_code');
        $this->db->bind(':class_code', $class_code);

        $row = $this->db->single();

        // Check row
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function searchCourses($searchTerm){
        $this->db->query('SELECT * FROM courses WHERE course_name LIKE :searchTerm OR class_code LIKE :searchTerm ORDER BY created_at DESC');
        $this->db->bind(':searchTerm', '%' . $searchTerm . '%');
        return $this->db->resultSet();
    }

    public function addCourse($data){
        $this->db->query('INSERT INTO courses (class_code, course_name, credits, teacher, schedule_day, schedule_time, semester, school_year) VALUES (:class_code, :course_name, :credits, :teacher, :schedule_day, :schedule_time, :semester, :school_year)');
        // Bind values
        $this->db->bind(':class_code', $data['class_code']);
        $this->db->bind(':course_name', $data['course_name']);
        $this->db->bind(':credits', $data['credits']);
        $this->db->bind(':teacher', $data['teacher']);
        $this->db->bind(':schedule_day', $data['schedule_day']);
        $this->db->bind(':schedule_time', $data['schedule_time']);
        $this->db->bind(':semester', $data['semester']);
        $this->db->bind(':school_year', $data['school_year']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function deleteCourse($id){
        $this->db->query('DELETE FROM courses WHERE id = :id');
        // Bind value
        $this->db->bind(':id', $id);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}
