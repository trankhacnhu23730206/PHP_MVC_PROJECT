<?php
    class Courses extends Controller {
        public function __construct(){
            // Load models if needed
            $this->courseModel = $this->model('Course');
        }

        public function addCourse(){
            // Check if logged in and is admin
            if(!isLoggedIn() || $_SESSION['user_role'] !== 'admin'){
                redirect('users/login');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'class_code' => trim($_POST['class_code']),
                    'course_name' => trim($_POST['course_name']),
                    'credits' => trim($_POST['credits']),
                    'teacher' => trim($_POST['teacher']),
                    'schedule_day' => trim($_POST['schedule_day']),
                    'schedule_time' => trim($_POST['schedule_time']),
                    'semester' => trim($_POST['semester']),
                    'school_year' => trim($_POST['school_year']),
                    'class_code_err' => '',
                    'course_name_err' => '',
                    'credits_err' => '',
                    'teacher_err' => '',
                    'schedule_day_err' => '',
                    'schedule_time_err' => '',
                    'semester_err' => '',
                    'school_year_err' => ''
                ];

                // Validate data
                if(empty($data['class_code'])){
                    $data['class_code_err'] = 'Vui lòng nhập mã lớp học';
                } else {
                    if($this->courseModel->findCourseByClassCode($data['class_code'])){
                        $data['class_code_err'] = 'Mã lớp học đã tồn tại.';
                    }
                }
                if(empty($data['course_name'])){
                    $data['course_name_err'] = 'Vui lòng nhập tên môn học';
                }
                if(empty($data['credits'])){
                    $data['credits_err'] = 'Vui lòng nhập số tín chỉ';
                }
                if(empty($data['teacher'])){
                    $data['teacher_err'] = 'Vui lòng nhập tên giáo viên';
                }
                if(empty($data['schedule_day'])){
                    $data['schedule_day_err'] = 'Vui lòng nhập lịch học (Thứ)';
                }
                if(empty($data['schedule_time'])){
                    $data['schedule_time_err'] = 'Vui lòng nhập lịch học (Giờ)';
                }
                if(empty($data['semester'])){
                    $data['semester_err'] = 'Vui lòng nhập học kì';
                }
                if(empty($data['school_year'])){
                    $data['school_year_err'] = 'Vui lòng nhập năm học';
                }

                // Make sure no errors
                if(empty($data['class_code_err']) && empty($data['course_name_err']) && empty($data['credits_err']) && empty($data['teacher_err']) && empty($data['schedule_day_err']) && empty($data['schedule_time_err']) && empty($data['semester_err']) && empty($data['school_year_err'])){
                    // Validated
                    if($this->courseModel->addCourse($data)){
                        flash('course_message', 'Khóa học đã được thêm');
                        redirect('users/dashboard?view=courses');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Load view with errors
                    $this->view('add_course', $data);
                }

            } else {
                // Init data
                $data = [
                    'class_code' => '',
                    'course_name' => '',
                    'credits' => '',
                    'teacher' => '',
                    'schedule_day' => '',
                    'schedule_time' => '',
                    'semester' => '',
                    'school_year' => ''
                ];
    
                $this->view('add_course', $data);
            }
        }

        public function deleteCourse($id){
            if(!isLoggedIn() || $_SESSION['user_role'] !== 'admin'){
                redirect('users/login');
            }

            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                if($this->courseModel->deleteCourse($id)){
                    flash('course_message', 'Khóa học đã được xóa');
                    redirect('users/dashboard?view=courses');
                } else {
                    die('Something went wrong');
                }
            }
        }
    }
?>