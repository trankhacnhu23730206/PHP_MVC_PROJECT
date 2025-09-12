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

    public function courseSearch(){
        // This method is for AJAX requests
        $searchTerm = $_GET['term'] ?? '';

        $data = [
            'courses' => $this->courseModel->searchCourses($searchTerm),
            'registrations' => $this->registrationModel->getRegistrationsByUserId($_SESSION['user_id'])
        ];

        // Load the partial view and output it
        $this->view('partials/course_table_rows', $data);
    }

    public function changePassword(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'current_password' => trim($_POST['current_password']),
                'new_password' => trim($_POST['new_password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => '',
                'success_message' => ''
            ];

            // Validate current password
            if(empty($data['current_password'])){
                $data['current_password_err'] = 'Vui lòng nhập mật khẩu hiện tại.';
            } else {
                $hashed_current_password_in_db = $this->userModel->getPasswordByUserId($_SESSION['user_id']);
                if(!password_verify($data['current_password'], $hashed_current_password_in_db)){
                    $data['current_password_err'] = 'Mật khẩu hiện tại không đúng.';
                }
            }

            // Validate new password
            if(empty($data['new_password'])){
                $data['new_password_err'] = 'Vui lòng nhập mật khẩu mới.';
            } elseif(strlen($data['new_password']) < 6){
                $data['new_password_err'] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
            }

            // Validate confirm password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Vui lòng xác nhận mật khẩu mới.';
            } else {
                if($data['new_password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Mật khẩu xác nhận không khớp.';
                }
            }

            // Make sure errors are empty
            if(empty($data['current_password_err']) && empty($data['new_password_err']) && empty($data['confirm_password_err'])){
                // Hash new password
                $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);

                // Update password in DB
                if($this->userModel->updatePassword($_SESSION['user_id'], $data['new_password'])){
                    $data['success_message'] = 'Mật khẩu đã được đổi thành công!';
                    // Clear password fields after successful update
                    $data['current_password'] = '';
                    $data['new_password'] = '';
                    $data['confirm_password'] = '';
                } else {
                    die('Có lỗi xảy ra khi cập nhật mật khẩu.');
                }
            }
            $this->view('change_password', $data);

        } else {
            // Init data
            $data = [
                'current_password' => '',
                'new_password' => '',
                'confirm_password' => '',
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => '',
                'success_message' => ''
            ];
            $this->view('change_password', $data);
        }
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
