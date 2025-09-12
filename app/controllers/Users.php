<?php
class Users extends Controller {
    public function __construct(){
        $this->userModel = $this->model('User');
        $this->courseModel = $this->model('Course');
        $this->registrationModel = $this->model('Registration'); // Load the new model
    }

    public function login(){
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => '',
            ];

            // Validate username
            if(empty($data['username'])){
                $data['username_err'] = 'Please enter username';
            }

            // Validate password
            if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }

            // Check for user/email
            if($this->userModel->findUserByUsername($data['username'])){
                // User Found
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                if($loggedInUser){
                    // Create Session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('login', $data);
                }
            } else {
                // User not found
                $data['username_err'] = 'No user found';
                $this->view('login', $data);
            }

        } else {
            // Init data
            $data = [
                'username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => '',
            ];

            // Load view
            $this->view('login', $data);
        }
    }

    public function dashboard(){
        // Check for actions first (register/cancel)
        if(isset($_GET['action'])){
            if($_GET['action'] == 'register' && isset($_GET['id'])){
                $courseToRegister = $this->courseModel->getCourseById($_GET['id']);
                
                if($courseToRegister){
                    $currentCredits = $this->registrationModel->getTotalCreditsForSemester(
                        $_SESSION['user_id'], 
                        $courseToRegister->semester, 
                        $courseToRegister->school_year
                    );

                    if(($currentCredits + $courseToRegister->credits) > 20){
                        // Set flash message
                        $_SESSION['credit_error'] = 'Đăng ký thất bại: Vượt quá 20 tín chỉ cho học kỳ ' . $courseToRegister->semester . ' năm học ' . $courseToRegister->school_year . '.';
                        // Redirect back to courses list
                        header('location: ' . URLROOT . '/public/users/dashboard?view=courses');
                        exit();
                    }
                }

                // If check passes or course info not found (let registration fail gracefully), proceed
                $this->registrationModel->registerCourse($_SESSION['user_id'], $_GET['id']);
                // Redirect to the registrations view to see the result
                header('location: ' . URLROOT . '/public/users/dashboard?view=registrations');
                exit();
            }

            if($_GET['action'] == 'cancel' && isset($_GET['id'])){
                $this->registrationModel->cancelRegistration($_GET['id']);
                // Redirect to the registrations view
                header('location: ' . URLROOT . '/public/users/dashboard?view=registrations');
                exit();
            }
        }

        // Prepare data for the view
        $data = [
            'courses' => [],
            'registrations' => $this->registrationModel->getRegistrationsByUserId($_SESSION['user_id'])
        ];

        $view = $_GET['view'] ?? 'dashboard';

        // Only fetch all courses if on the courses view
        if($view == 'courses'){
            $data['courses'] = $this->courseModel->getAllCourses();
        }
        
        $this->view('dashboard', $data);
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_username'] = $user->username;
        header('location: ' . URLROOT . '/public/users/dashboard'); // Redirect to dashboard without courses
        exit();
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_username']);
        session_destroy();
        // Redirect to login
        header('location: ' . URLROOT . '/public/users/login');
        exit();
    }
}
