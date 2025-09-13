<?php
class Users extends Controller {
    public function __construct(){
        $this->userModel = $this->model('User');
        $this->courseModel = $this->model('Course');
        $this->registrationModel = $this->model('Registration');
    }

    public function login(){
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data =[
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => '',      
            ];

            // Check for username
            if(empty($data['username'])){
                $data['username_err'] = 'Vui lòng nhập tên đăng nhập';
            }

            // Check for password
            if(empty($data['password'])){
                $data['password_err'] = 'Vui lòng nhập mật khẩu';
            }

            // Check for user/username
            if($this->userModel->findUserByUsername($data['username'])){
                // User found
            } else {
                // User not found
                $data['username_err'] = 'Không tìm thấy người dùng';
            }

            // Make sure errors are empty
            if(empty($data['username_err']) && empty($data['password_err'])){
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                if($loggedInUser){
                    // Create Session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Mật khẩu không đúng';
                    $this->view('login', $data);
                }
            } else {
                // Load view with errors
                $this->view('login', $data);
            }

        } else {
            // Load form
            $data =[
                'username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => '',      
            ];
            $this->view('login', $data);
        }
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_username'] = $user->username;
        $_SESSION['user_gender'] = $user->gender;
        $_SESSION['user_role'] = $user->role;
        redirect('users/dashboard');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_username']);
        unset($_SESSION['user_gender']);
        unset($_SESSION['user_role']);
        session_destroy();
        redirect('users/login');
    }

    public function changePassword(){
        if(!isLoggedIn()){
            redirect('users/login');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'current_password' => trim($_POST['current_password']),
                'new_password' => trim($_POST['new_password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate Current Password
            if(empty($data['current_password'])){
                $data['current_password_err'] = 'Vui lòng nhập mật khẩu cũ.';
            } else {
                $currentPassword = $this->userModel->getPasswordByUserId($_SESSION['user_id']);
                if(!password_verify($data['current_password'], $currentPassword)){
                    $data['current_password_err'] = 'Mật khẩu cũ không đúng.';
                }
            }

            // Validate New Password
            if(empty($data['new_password'])){
                $data['new_password_err'] = 'Vui lòng nhập mật khẩu mới.';
            } elseif(strlen($data['new_password']) < 6){
                $data['new_password_err'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            }

            // Validate Confirm Password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Vui lòng xác nhận mật khẩu mới.';
            } else {
                if($data['new_password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Mật khẩu không khớp.';
                }
            }

            // Make sure errors are empty
            if(empty($data['current_password_err']) && empty($data['new_password_err']) && empty($data['confirm_password_err'])){
                // Hash new password
                $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);

                // Update password
                if($this->userModel->updatePassword($_SESSION['user_id'], $data['new_password'])){
                    flash('profile_message', 'Mật khẩu đã được thay đổi thành công.');
                    redirect('users/dashboard?view=profile');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('change_password', $data);
            }

        } else {
            // Init data
            $data = [
                'current_password' => '',
                'new_password' => '',
                'confirm_password' => '',
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];
            $this->view('change_password', $data);
        }
    }

    // ... login, createUserSession, logout methods remain the same ...

    public function dashboard(){
        // Handle course registration action
        if (isset($_GET['action']) && $_GET['action'] == 'register' && isset($_GET['id']) && ($_GET['view'] ?? '') === 'courses') {
            if (!isLoggedIn()) {
                redirect('users/login');
            }
            
            $course_id = $_GET['id'];
            $user_id = $_SESSION['user_id'];

            // Get course details to check credits and semester
            $courseToRegister = $this->courseModel->getCourseById($course_id);

            if(!$courseToRegister){
                flash('course_message', 'Khóa học không hợp lệ.', 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4');
                redirect('users/dashboard?view=courses');
                return;
            }

            // Check credit limit
            $currentCredits = $this->registrationModel->getTotalCreditsForSemester($user_id, $courseToRegister->semester, $courseToRegister->school_year);
            $newTotalCredits = $currentCredits + $courseToRegister->credits;

            if($newTotalCredits > 20){
                flash('course_message', 'Không thể đăng ký. Vượt quá 20 tín chỉ cho học kỳ này. (Hiện tại: ' . $currentCredits . ' tín chỉ)', 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4');
                redirect('users/dashboard?view=courses');
                return;
            }

            // Proceed with registration
            if ($this->registrationModel->registerCourse($user_id, $course_id)) {
                flash('course_message', 'Đăng ký khóa học thành công. Vui lòng chờ xác nhận.');
            } else {
                flash('course_message', 'Bạn đã đăng ký khóa học này hoặc có lỗi xảy ra.', 'bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4');
            }
            redirect('users/dashboard?view=courses');
            return;
        }

        // Handle registration management actions
        if (isset($_GET['action']) && isset($_GET['id']) && ($_GET['view'] ?? '') === 'registrations') {
            $action = $_GET['action'];
            $id = $_GET['id'];

            if (!isLoggedIn()) {
                redirect('users/login');
            }

            $success = false;
            $message = 'Có lỗi xảy ra.';
            
            if ($action == 'confirm' && $_SESSION['user_role'] === 'admin') {
                if ($this->registrationModel->confirmRegistration($id)) {
                    $success = true;
                    $message = 'Đăng ký đã được xác nhận.';
                }
            } elseif ($action == 'reject' && $_SESSION['user_role'] === 'admin') {
                if ($this->registrationModel->rejectRegistration($id)) {
                    $success = true;
                    $message = 'Đăng ký đã bị từ chối.';
                }
            } elseif ($action == 'cancel') {
                if ($this->registrationModel->cancelRegistration($id)) {
                    $success = true;
                    $message = 'Đăng ký đã được hủy thành công.';
                }
            }

            $message_class = $success 
                ? 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4'
                : 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4';

            flash('registration_message', $message, $message_class);
            redirect('users/dashboard?view=registrations');
            return;
        }

        // Prepare data for the view
        $data = [
            'courses' => [],
            'registrations' => [],
            'confirmed_courses_by_semester' => [],
            'users' => [], // Add users to data array
            'user' => null
        ];

        $view = $_GET['view'] ?? 'dashboard';

        if($view == 'courses'){
            $data['courses'] = $this->courseModel->getAllCourses();
            // Also fetch registrations to check which courses are already registered
            if(isLoggedIn()){
                $data['registrations'] = $this->registrationModel->getRegistrationsByUserId($_SESSION['user_id']);
            }
        } elseif ($view == 'registrations') {
            if(isLoggedIn() && $_SESSION['user_role'] === 'admin'){
                $data['registrations'] = $this->registrationModel->getAllRegistrations();
            } else {
                $data['registrations'] = $this->registrationModel->getRegistrationsByUserId($_SESSION['user_id']);
            }
        } elseif ($view == 'course_info') {
            if(isLoggedIn() && $_SESSION['user_role'] !== 'admin'){
                $confirmedRegistrations = $this->registrationModel->getConfirmedRegistrationsGroupedBySemester($_SESSION['user_id']);
                $groupedCourses = [];
                foreach ($confirmedRegistrations as $registration) {
                    $groupedCourses[$registration->semester][] = $registration;
                }
                $data['confirmed_courses_by_semester'] = $groupedCourses;
            }
        } elseif ($view == 'user_management') {
            if(isLoggedIn() && $_SESSION['user_role'] === 'admin'){
                $data['users'] = $this->userModel->getAllUsers();
            }
        } elseif ($view == 'profile') {
            if(isLoggedIn()){
                $data['user'] = $this->userModel->getUserById($_SESSION['user_id']);
            }
        }

        $this->view('dashboard', $data);
    }

    public function registrationSearch(){
        if(!isLoggedIn()){
            exit(); // Or redirect
        }

        $searchTerm = $_GET['term'] ?? '';
        
        $data = [];

        if($_SESSION['user_role'] === 'admin'){
            $data['registrations'] = $this->registrationModel->searchRegistrations($searchTerm);
        } else {
            $data['registrations'] = $this->registrationModel->searchRegistrations($searchTerm, $_SESSION['user_id']);
        }

        // Load the partial view with the search results
        $this->view('partials/registration_table_rows', $data);
    }

    public function courseSearch(){
        if(!isLoggedIn()){
            exit(); // Or redirect, but for AJAX, exit is usually better
        }

        $searchTerm = $_GET['term'] ?? '';
        
        $data = [];
        $data['courses'] = $this->courseModel->searchCourses($searchTerm);

        // Also fetch registrations to check which courses are already registered
        if(isLoggedIn()){
            $data['registrations'] = $this->registrationModel->getRegistrationsByUserId($_SESSION['user_id']);
        }

        // Load the partial view with the search results
        $this->view('partials/course_table_rows', $data);
    }

    public function addUser(){
        // Only admins can add users
        if(!isLoggedIn() || $_SESSION['user_role'] !== 'admin'){
            redirect('users/dashboard');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'gender' => trim($_POST['gender']),
                'role' => trim($_POST['role']),
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate username
            if(empty($data['username'])){
                $data['username_err'] = 'Vui lòng nhập tên đăng nhập.';
            }

            // Validate password
            if(empty($data['password'])){
                $data['password_err'] = 'Vui lòng nhập mật khẩu.';
            }

            // Validate confirm password
            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Vui lòng xác nhận mật khẩu.';
            } else {
                if($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Mật khẩu không khớp.';
                }
            }

            // Make sure errors are empty
            if(empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Add User
                if($this->userModel->addUser($data)){
                    flash('user_message', 'Người dùng đã được thêm.');
                    redirect('users/dashboard?view=user_management');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('add_user', $data);
            }

        } else {
            // Init data
            $data = [
                'username' => '',
                'password' => '',
                'confirm_password' => '',
                'gender' => 'male',
                'role' => 'student',
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            $this->view('add_user', $data);
        }
    }

    public function editUser($id){
        // Only admins can edit users
        if(!isLoggedIn() || $_SESSION['user_role'] !== 'admin'){
            redirect('users/dashboard');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'gender' => trim($_POST['gender']),
                'role' => trim($_POST['role']),
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate username
            if(empty($data['username'])){
                $data['username_err'] = 'Vui lòng nhập tên đăng nhập.';
            }

            // Validate password (only if it's being changed)
            if(!empty($data['password'])){
                if(strlen($data['password']) < 6){
                    $data['password_err'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
                }
                if($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Mật khẩu không khớp.';
                }
            }

            // Make sure errors are empty
            if(empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                // Hash password if it was changed
                if(!empty($data['password'])){
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                }

                // Update User
                if($this->userModel->updateUser($data)){
                    flash('user_message', 'Thông tin người dùng đã được cập nhật.');
                    redirect('users/dashboard?view=user_management');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('edit_user', $data);
            }

        } else {
            // Get existing user from model
            $user = $this->userModel->getUserById($id);

            // Check for owner
            if(!$user){
                redirect('users/dashboard?view=user_management');
            }

            $data = [
                'id' => $id,
                'username' => $user->username,
                'gender' => $user->gender,
                'role' => $user->role,
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            $this->view('edit_user', $data);
        }
    }

    public function deleteUser($id){
        if(!isLoggedIn() || $_SESSION['user_role'] !== 'admin'){
            redirect('users/dashboard');
        }

        $user = $this->userModel->getUserById($id);

        if(!$user || $user->role === 'admin'){
            flash('user_message', 'Không thể xóa người dùng này.', 'alert alert-danger');
            redirect('users/dashboard?view=user_management');
        }

        if($this->userModel->deleteUser($id)){
            flash('user_message', 'Người dùng đã được xóa.');
            redirect('users/dashboard?view=user_management');
        } else {
            die('Something went wrong');
        }
    }
}