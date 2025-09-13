<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ | CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> 
        body { font-family: 'Inter', sans-serif; } 
        .sidebar-link.active {
            background-color: #eff6ff; /* bg-blue-50 */
            color: #2563eb; /* text-blue-700 */
            font-weight: 600;
        }
        .table-container {
            overflow: visible;
        }
        /* Style để bảng không bị quá rộng và có thể cuộn ngang */
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">
    
    <aside class="w-64 bg-white shadow-lg flex flex-col border-r border-gray-200">
        <div class="p-6">
              <a href="?view=dashboard" class="flex items-center space-x-3">
                  <i class="fas fa-book-open text-3xl text-blue-600"></i>
                  <span class="text-2xl font-bold text-gray-800">Trang Chủ</span>
            </a>
        </div>
        
        <nav class="flex-1 px-4 py-2 space-y-2">
            <?php 
                $currentView = $_GET['view'] ?? 'dashboard'; 
            ?>
            <a href="?view=courses" class="sidebar-link flex items-center space-x-3 py-2 px-4 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition duration-200 <?php echo ($currentView === 'courses') ? 'active' : ''; ?>">
                <i class="fas fa-list-ul fa-fw"></i>
                <span>Danh sách Khóa học</span>
            </a>
            <a href="?view=registrations" class="sidebar-link flex items-center space-x-3 py-2 px-4 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition duration-200 <?php echo ($currentView === 'registrations') ? 'active' : ''; ?>">
                <i class="fas fa-clipboard-check fa-fw"></i>
                <span>Thông tin Đăng ký</span>
            </a>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') : ?>
                <a href="?view=user_management" class="sidebar-link flex items-center space-x-3 py-2 px-4 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition duration-200 <?php echo ($currentView === 'user_management') ? 'active' : ''; ?>">
                    <i class="fas fa-users fa-fw"></i>
                    <span>Thông tin Tài khoản</span>
                </a>
            <?php else : ?>
                <a href="?view=course_info" class="sidebar-link flex items-center space-x-3 py-2 px-4 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition duration-200 <?php echo ($currentView === 'course_info') ? 'active' : ''; ?>">
                    <i class="fas fa-graduation-cap fa-fw"></i>
                    <span>Thông tin Học phần</span>
                </a>
            <?php endif; ?>
        </nav>

        
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <?php
            $view = $_GET['view'] ?? 'dashboard';
            if ($_SESSION['user_role'] === 'admin') {
                $pageTitle = 'Quản Trị Viên Hệ Thống';
            }else {
                $pageTitle = 'Sinh Viên';
            }
            if ($view === 'courses') $pageTitle = 'Danh sách Khóa học';
            if ($view === 'registrations') $pageTitle = 'Thông tin Đăng ký';
            if ($view === 'course_info') $pageTitle = 'Thông tin Học Phần';
            if ($view === 'user_management') $pageTitle = 'Quản lý Tài khoản Người dùng';
        ?>
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800"><?php echo $pageTitle; ?></h1>
            <!-- Profile Dropdown -->
            <div class="relative">
                <button onclick="toggleDropdown('profile-dropdown')" class="flex items-center space-x-4 focus:outline-none">
                    <span class="text-gray-700"><?php echo htmlspecialchars($_SESSION['user_username']); ?></span>
                    <?php
                        $gender_icon = URLROOT . '/public/img/avatars/default.jpg'; // Default placeholder
                        if (isset($_SESSION['user_gender'])) {
                            if ($_SESSION['user_gender'] === 'male') {
                                $gender_icon = URLROOT . '/public/img/avatars/male.jpg';
                            } elseif ($_SESSION['user_gender'] === 'female') {
                                $gender_icon = URLROOT . '/public/img/avatars/female.jpg';
                            } else {
                                // Fallback for 'other' or undefined gender
                                $gender_icon = URLROOT . '/public/img/avatars/default.jpg';
                            }
                        }
                    ?>
                    <img class="w-10 h-10 rounded-full border-2 border-blue-500" src="<?php echo $gender_icon; ?>" alt="Profile Picture">
                </button>
                <!-- Dropdown Menu -->
                <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                    <a href="?view=profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Thông tin người dùng</a>
                    <a href="<?php echo URLROOT; ?>/public/users/changePassword" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Đổi mật khẩu</a>
                    <a href="<?php echo URLROOT; ?>/public/users/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Đăng xuất</a>
                </div>
            </div>
        </header>
        
        <?php
            switch ($view) {
                case 'courses':
                    flash('course_message');
                    // Check for credit limit error flash message
                    if(isset($_SESSION['credit_error'])){
                        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">';
                        echo '<strong class="font-bold">Lỗi!</strong>';
                        echo '<span class="block sm:inline"> ' . $_SESSION['credit_error'] . '</span>';
                        echo '</div>';
                        unset($_SESSION['credit_error']); // Unset the message so it doesn't show again
                    }
                    
                    echo '<section class="bg-white p-6 rounded-lg shadow-md mb-6">';
                    echo '<div class="flex justify-between items-center mb-4">';
                    if ($_SESSION['user_role'] === 'admin') {
                        echo '<h2 class="text-2xl font-semibold text-gray-800 mb-4">Quản lý Lớp học</h2>';
                    } else {
                        echo '<h2 class="text-2xl font-semibold text-gray-800 mb-4">Các Lớp học có thể Đăng ký</h2>';
                    }
                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                        echo '<a href="' . URLROOT . '/public/courses/addCourse" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition duration-150">';
                        echo '<i class="fas fa-plus-circle mr-2"></i> Thêm Khóa học';
                        echo '</a>';
                    }
                    echo '</div>';
                    echo '<div class="mb-4"><input type="text" id="course-search" placeholder="Tìm theo tên hoặc mã môn học..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></div>';

                    echo '<div class="table-responsive">';
                        echo '<table class="min-w-full bg-white border border-gray-200 text-sm whitespace-nowrap">';
                        echo '<thead>';
                        echo '<tr class="bg-gray-50">';
                        echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">STT</th>';
                        echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Mã lớp học</th>';
                        echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Tên môn học</th>';
                        echo '<th class="py-3 px-4 border-b text-center text-gray-600 font-semibold">Số TC</th>';
                        echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Giáo viên</th>';
                        echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Lịch học</th>';
                        echo '<th class="py-3 px-4 border-b text-center text-gray-600 font-semibold">Học kì</th>';
                        echo '<th class="py-3 px-4 border-b text-right text-gray-600 font-semibold">Hành động</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody id="course-table-body">';
                        
                        // Initial table content is rendered via the partial view
                        if (!empty($data['courses'])) {
                            include APPROOT . '/app/views/partials/course_table_rows.php';
                        } else {
                            echo '<tr><td colspan="8" class="text-center py-4 text-gray-600">Không có lớp học nào để hiển thị.</td></tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    echo '</section>';
                    break;
                
                       case 'registrations':
                    flash('registration_message');
                    echo '<section class="bg-white p-6 rounded-lg shadow-md mb-6">';
                    if ($_SESSION['user_role'] === 'admin') {
                        echo '<h2 class="text-2xl font-semibold text-gray-800 mb-4">Quản lý Đăng ký</h2>';
                    } else {
                        echo '<h2 class="text-2xl font-semibold text-gray-800 mb-4">Các Môn học đã Đăng ký</h2>';
                    }

                    $placeholder = ($_SESSION['user_role'] === 'admin') ? 'Tìm theo tên sinh viên, tên hoặc mã môn học...' : 'Tìm theo tên hoặc mã môn học...';
                    echo '<div class="mb-4"><input type="text" id="registration-search" placeholder="' . $placeholder . '" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></div>';

                    echo '<div class="table-responsive">';
                    echo '<table class="min-w-full bg-white border border-gray-200 text-sm whitespace-nowrap">';
                    echo '<thead>';
                    echo '<tr class="bg-gray-50">';
                    if ($_SESSION['user_role'] === 'admin') {
                        echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Sinh viên</th>';
                    }
                    echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Mã lớp học</th>';
                    echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Tên môn học</th>';
                    echo '<th class="py-3 px-4 border-b text-center text-gray-600 font-semibold">Số TC</th>';
                    echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Học kì</th>';
                    echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Trạng thái</th>';
                    echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Ngày Đăng Ký</th>';
                    echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Ngày Kết Quả</th>';
                    echo '<th class="py-3 px-4 border-b text-right text-gray-600 font-semibold">Hành động</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody id="registration-table-body">';
                    
                    if (!empty($data['registrations'])) {
                        include APPROOT . '/app/views/partials/registration_table_rows.php';
                    } else {
                        $message = ($_SESSION['user_role'] === 'admin') ? 'Không có đăng ký nào cần xử lý.' : 'Bạn chưa đăng ký môn học nào.';
                        $colspan = ($_SESSION['user_role'] === 'admin') ? 9 : 8;
                        echo '<tr><td colspan="' . $colspan . '" class="text-center py-4 text-gray-600">' . $message . '</td></tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</section>';
                    break;

                case 'course_info':
                    echo '<section class="bg-white p-6 rounded-lg shadow-md mb-6">';
                    echo '<h2 class="text-2xl font-semibold text-gray-800 mb-4">Thông tin Học phần đã Xác nhận</h2>';
                    if (!empty($data['confirmed_courses_by_semester'])) {
                        foreach ($data['confirmed_courses_by_semester'] as $semester_display => $courses) {
                            echo '<div class="mb-6">';
                            $total_credits = 0;
                            foreach ($courses as $course) {
                                $total_credits += $course->credits;
                            }
                            echo '<h3 class="text-xl font-semibold text-gray-700 mb-3">Học kì: ' . htmlspecialchars($semester_display) . ' - Năm Học: ' . htmlspecialchars($courses[0]->school_year) . ' - Tổng số tín chỉ: ' . $total_credits . '</h3>';
                            echo '<div class="table-responsive">';
                            echo '<table class="min-w-full bg-white border border-gray-200 text-sm whitespace-nowrap">';
                            echo '<thead>';
                            echo '<tr class="bg-gray-50">';
                            echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Mã lớp học</th>';
                            echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Tên môn học</th>';
                            echo '<th class="py-3 px-4 border-b text-center text-gray-600 font-semibold">Số TC</th>';
                            echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Giáo viên</th>';
                            echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Thứ</th>';
                            echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Giờ</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';
                            foreach ($courses as $course) {
                                echo '<tr class="hover:bg-gray-50">';
                                echo '<td class="py-3 px-4 border-b text-gray-700 font-mono">' . htmlspecialchars($course->class_code) . '</td>';
                                echo '<td class="py-3 px-4 border-b text-gray-700 font-semibold">' . htmlspecialchars($course->course_name) . '</td>';
                                echo '<td class="py-3 px-4 border-b text-gray-700 text-center">' . htmlspecialchars($course->credits) . '</td>';
                                echo '<td class="py-3 px-4 border-b text-gray-700">' . (isset($course->teacher) ? htmlspecialchars($course->teacher) : 'N/A') . '</td>';
                                echo '<td class="py-3 px-4 border-b text-gray-700">' . (isset($course->schedule_day) ? htmlspecialchars($course->schedule_day) : 'N/A') . '</td>';
                                echo '<td class="py-3 px-4 border-b text-gray-700">' . (isset($course->schedule_time) ? htmlspecialchars($course->schedule_time) : 'N/A') . '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '</table>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class="text-gray-600">Bạn chưa có học phần nào được xác nhận.</p>';
                    }
                    echo '</section>';
                    break;
                case 'user_management':
                    flash('user_message');
                    echo '<section class="bg-white p-6 rounded-lg shadow-md mb-6">';
                    echo '<div class="flex justify-between items-center mb-4">';
                    echo '<h2 class="text-2xl font-semibold text-gray-800">Quản lý Tài khoản Người dùng</h2>';
                    echo '<a href="' . URLROOT . '/public/users/addUser" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition duration-150">';
                    echo '<i class="fas fa-user-plus mr-2"></i> Thêm Người dùng';
                    echo '</a>';
                    echo '</div>';
                    echo '<div class="mb-4"><input type="text" id="user-search" placeholder="Tìm theo tên đăng nhập hoặc vai trò..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></div>';
                    echo '<div class="table-responsive">';
                    echo '<table class="min-w-full bg-white border border-gray-200 text-sm whitespace-nowrap">';
                    echo '<thead>';
                    echo '<tr class="bg-gray-50">';
                    echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">ID</th>';
                    echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Tên đăng nhập</th>';
                    echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Giới tính</th>';
                    echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Vai trò</th>';
                    echo '<th class="py-3 px-4 border-b text-right text-gray-600 font-semibold">Hành động</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody id="user-table-body">';
                    if (!empty($data['users'])) {
                        include APPROOT . '/app/views/partials/user_table_rows.php';
                    } else {
                        echo '<tr><td colspan="5" class="text-center py-4 text-gray-600">Không có người dùng nào để hiển thị.</td></tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</section>';
                    break;
                case 'profile':
                    include APPROOT . '/app/views/profile.php';
                    break;
                case 'dashboard':
                default:
                    echo '<section class="bg-white p-6 rounded-lg shadow-md mb-6">';
                    echo '<h2 class="text-2xl font-semibold text-gray-800 mb-4">Chào mừng đến với trang quản trị!</h2>';
                    echo '<p class="text-gray-600">Vui lòng chọn một mục từ thanh điều hướng bên trái để bắt đầu.</p>';
                    echo '</section>';
                    break;
            }
        ?>
        
    </main>

    <script>
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            document.querySelectorAll('[id^="dropdown-menu-"]').forEach(menu => {
                if (menu.id !== dropdownId) {
                    menu.classList.add('hidden');
                }
            });
            dropdown.classList.toggle('hidden');
        }

        window.onclick = function(event) {
            if (!event.target.matches('button, button *')) {
                document.querySelectorAll('[id^="dropdown-menu-"]').forEach(menu => {
                    if (!menu.classList.contains('hidden')) {
                        menu.classList.add('hidden');
                    }
                });
            }
        }
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Only run the search script if the search input exists on the page
        const searchInput = document.getElementById('course-search');
        if (searchInput) {
            const tableBody = document.getElementById('course-table-body');
            const urlRoot = '<?php echo URLROOT; ?>';
            let debounceTimer;

            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value;

                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    tableBody.innerHTML = '<tr><td colspan="8" class="text-center py-4">Đang tìm kiếm...</td></tr>';

                    fetch(`${urlRoot}/public/users/courseSearch?term=${searchTerm}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                        .then(html => {
                            tableBody.innerHTML = html;
                        })
                        .catch(error => {
                            console.error('Error fetching search results:', error);
                            tableBody.innerHTML = '<tr><td colspan="8" class="text-center py-4 text-red-500">Có lỗi xảy ra khi tìm kiếm.</td></tr>';
                        });
                }, 300); // 300ms debounce
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const registrationSearchInput = document.getElementById('registration-search');
        if (registrationSearchInput) {
            const tableBody = document.getElementById('registration-table-body');
            const urlRoot = '<?php echo URLROOT; ?>';
            let debounceTimer;

            registrationSearchInput.addEventListener('keyup', function() {
                const searchTerm = this.value;
                const colspan = '<?php echo ($_SESSION['user_role'] === 'admin') ? 9 : 8; ?>';

                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    tableBody.innerHTML = `<tr><td colspan="${colspan}" class="text-center py-4">Đang tìm kiếm...</td></tr>`;

                    fetch(`${urlRoot}/public/users/registrationSearch?term=${searchTerm}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                        .then(html => {
                            tableBody.innerHTML = html;
                        })
                        .catch(error => {
                            console.error('Error fetching search results:', error);
                            tableBody.innerHTML = `<tr><td colspan="${colspan}" class="text-center py-4 text-red-500">Có lỗi xảy ra khi tìm kiếm.</td></tr>`;
                        });
                }, 300); // 300ms debounce
            });
        }
    });
</script>
</body>
</html>