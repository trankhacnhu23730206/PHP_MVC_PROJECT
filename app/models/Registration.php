<?php
class Registration {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // Get all registrations for a specific user, sorted by latest activity
    public function getRegistrationsByUserId($user_id){
        $this->db->query('SELECT r.id as registration_id, c.*, r.status, r.registration_date, r.result_date 
                          FROM registrations r
                          JOIN courses c ON r.course_id = c.id
                          WHERE r.user_id = :user_id
                          ORDER BY COALESCE(r.result_date, r.registration_date) DESC');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    // Register a user for a course
    public function registerCourse($user_id, $course_id){
        // Check if already actively registered to prevent duplicates
        $this->db->query('SELECT * FROM registrations WHERE user_id = :user_id AND course_id = :course_id AND status != "Đã hủy"');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':course_id', $course_id);
        $row = $this->db->single();

        if($this->db->rowCount() > 0){
            return false; // Already registered and not cancelled
        }

        // Insert new registration with 'Chờ xác nhận' status
        $this->db->query('INSERT INTO registrations (user_id, course_id, status) VALUES (:user_id, :course_id, "Chờ xác nhận")');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':course_id', $course_id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Cancel a registration by updating its status
    public function cancelRegistration($registration_id){
        $this->db->query('UPDATE registrations SET status = "Đã hủy", result_date = NOW() WHERE id = :registration_id');
        $this->db->bind(':registration_id', $registration_id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Confirm a registration by updating its status
    public function confirmRegistration($registration_id){
        $this->db->query('UPDATE registrations SET status = "Đã xác nhận", result_date = NOW() WHERE id = :registration_id');
        $this->db->bind(':registration_id', $registration_id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Calculate total credits for a user in a specific semester
    public function getTotalCreditsForSemester($user_id, $semester, $school_year){
        $this->db->query('SELECT SUM(c.credits) as total_credits
                          FROM registrations r
                          JOIN courses c ON r.course_id = c.id
                          WHERE r.user_id = :user_id
                          AND c.semester = :semester
                          AND c.school_year = :school_year
                          AND r.status != "Đã hủy"');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':semester', $semester);
        $this->db->bind(':school_year', $school_year);
        
        $row = $this->db->single();
        
        return $row->total_credits ?? 0;
    }

    // Get confirmed registrations grouped by semester for a specific user
    public function getConfirmedRegistrationsGroupedBySemester($user_id){
        $this->db->query('SELECT r.id as registration_id, c.*, r.status, r.registration_date, r.result_date
                          FROM registrations r
                          JOIN courses c ON r.course_id = c.id
                          WHERE r.user_id = :user_id AND r.status = "Đã xác nhận"
                          ORDER BY c.school_year DESC, c.semester DESC');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }
}