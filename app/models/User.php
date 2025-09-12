<?php
class User {
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    // Find user by username
    public function findUserByUsername($username){
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        // Check row
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    // Login user
    public function login($username, $password){
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        $hashed_password = $row->password;
        if(password_verify($password, $hashed_password)){
            return $row;
        } else {
            return false;
        }
    }

    // Get user's hashed password by ID
    public function getPasswordByUserId($user_id){
        $this->db->query('SELECT password FROM users WHERE id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->single();
        return $row->password ?? null;
    }

    // Update user's password
    public function updatePassword($user_id, $new_hashed_password){
        $this->db->query('UPDATE users SET password = :new_password WHERE id = :user_id');
        $this->db->bind(':new_password', $new_hashed_password);
        $this->db->bind(':user_id', $user_id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}