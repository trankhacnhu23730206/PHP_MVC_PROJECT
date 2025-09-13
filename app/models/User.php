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

    // Get all users
    public function getAllUsers(){
        $this->db->query('SELECT id, username, gender, role FROM users ORDER BY username ASC');
        return $this->db->resultSet();
    }

    // Get user by ID
    public function getUserById($id){
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Add a new user
    public function addUser($data){
        $this->db->query('INSERT INTO users (username, password, gender, role) VALUES (:username, :password, :gender, :role)');
        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':role', $data['role']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Update user information
    public function updateUser($data){
        // If password is not changed, the query is different
        if(empty($data['password'])){
            $this->db->query('UPDATE users SET username = :username, gender = :gender, role = :role WHERE id = :id');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':gender', $data['gender']);
            $this->db->bind(':role', $data['role']);
        } else {
            $this->db->query('UPDATE users SET username = :username, password = :password, gender = :gender, role = :role WHERE id = :id');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':gender', $data['gender']);
            $this->db->bind(':role', $data['role']);
        }

        // Execute
        if($this->db->execute()){
            return true;
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

    // Delete a user
    public function deleteUser($id){
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
}