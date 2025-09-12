<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Quản Trị</title>
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
                  <span class="text-2xl font-bold text-gray-800">E-Learning</span>
            </a>
        </div>
        
        <nav class="flex-1 px-4 py-2 space-y-2">
            <?php 
                $currentView = $_GET['view'] ?? 'dashboard'; 
            ?>
            <a href="?view=dashboard" class="sidebar-link flex items-center space-x-3 py-2 px-4 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition duration-200 <?php echo ($currentView === 'dashboard') ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt fa-fw"></i>
                <span>Dashboard</span>
            </a>
            <a href="?view=courses" class="sidebar-link flex items-center space-x-3 py-2 px-4 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition duration-200 <?php echo ($currentView === 'courses') ? 'active' : ''; ?>">
                <i class="fas fa-list-ul fa-fw"></i>
                <span>Danh sách Khóa học</span>
            </a>
            <a href="?view=registrations" class="sidebar-link flex items-center space-x-3 py-2 px-4 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition duration-200 <?php echo ($currentView === 'registrations') ? 'active' : ''; ?>">
                <i class="fas fa-clipboard-check fa-fw"></i>
                <span>Thông tin Đăng ký</span>
            </a>
        </nav>

        <div class="p-4 mt-auto">
            <a href="<?php echo URLROOT; ?>/public/users/logout" class="flex items-center justify-center space-x-2 text-red-500 hover:text-red-700 py-2 px-4 rounded-lg transition duration-200 hover:bg-gray-100">
                <i class="fas fa-sign-out-alt text-lg"></i>
                <span>Đăng xuất</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <?php
            $view = $_GET['view'] ?? 'dashboard';
            $pageTitle = 'Dashboard';
            if ($view === 'courses') $pageTitle = 'Danh sách Khóa học';
            if ($view === 'registrations') $pageTitle = 'Thông tin Đăng ký';
        ?>
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800"><?php echo $pageTitle; ?></h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">Chào mừng, <?php echo htmlspecialchars($_SESSION['user_username']); ?>!</span>
                <img class="w-10 h-10 rounded-full border-2 border-blue-500" src="https://via.placeholder.com/150" alt="Profile Picture">
            </div>
        </header>
        
        <?php
            switch ($view) {
                case 'courses':
                    // Check for credit limit error flash message
                    if(isset($_SESSION['credit_error'])){
                        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">';
                        echo '<strong class="font-bold">Lỗi!</strong>';
                        echo '<span class="block sm:inline"> ' . $_SESSION['credit_error'] . '</span>';
                        echo '</div>';
                        unset($_SESSION['credit_error']); // Unset the message so it doesn't show again
                    }
                    
                    echo '<section class="bg-white p-6 rounded-lg shadow-md mb-6">';
                    echo '<h2 class="text-2xl font-semibold text-gray-800 mb-4">Các Lớp học có thể Đăng ký</h2>';

                    // Prepare a list of already registered course IDs (with active status)
                    $registeredCourseIds = [];
                    if (!empty($data['registrations'])) {
                        foreach ($data['registrations'] as $reg) {
                            if ($reg->status === 'Chờ xác nhận' || $reg->status === 'Đã xác nhận') {
                                $registeredCourseIds[] = $reg->id; // course_id is aliased as id from c.*
                            }
                        }
                    }

                    if (!empty($data['courses'])) {
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
                        echo '<tbody>';
                        foreach ($data['courses'] as $course) {
                            echo '<tr class="hover:bg-gray-50">';
                            echo '<td class="py-3 px-4 border-b text-gray-700 text-center">' . htmlspecialchars($course->id) . '</td>';
                            echo '<td class="py-3 px-4 border-b text-gray-700 font-mono">' . htmlspecialchars($course->class_code) . '</td>';
                            echo '<td class="py-3 px-4 border-b text-gray-700 font-semibold">' . htmlspecialchars($course->course_name) . '</td>';
                            echo '<td class="py-3 px-4 border-b text-gray-700 text-center">' . htmlspecialchars($course->credits) . '</td>';
                            echo '<td class="py-3 px-4 border-b text-gray-700">' . htmlspecialchars($course->teacher) . '</td>';
                            echo '<td class="py-3 px-4 border-b text-gray-700">' . htmlspecialchars($course->schedule_day) . ' (' . htmlspecialchars($course->schedule_time) . ')</td>';
                            echo '<td class="py-3 px-4 border-b text-gray-700 text-center">' . htmlspecialchars($course->semester) . '</td>';

                            // ===== NÚT ĐĂNG KÝ (CÓ ĐIỀU KIỆN) =====
                            echo '<td class="py-3 px-4 border-b text-right">';
                            if (in_array($course->id, $registeredCourseIds)) {
                                echo '<span class="px-3 py-2 text-xs font-bold text-gray-500 bg-gray-100 rounded">Đã đăng ký</span>';
                            } else {
                                echo '<a href="?view=registrations&action=register&id=' . htmlspecialchars($course->id) . '" onclick="return confirm(\'Bạn có muốn đăng ký lớp học này không?\')" class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-2 px-3 rounded inline-flex items-center transition duration-150">';
                                echo '<i class="fas fa-plus mr-1"></i> Đăng ký';
                                echo '</a>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo '<p class="text-gray-600">Không có lớp học nào để hiển thị.</p>';
                    }
                    echo '</section>';
                    break;
                
                       case 'registrations':
                    echo '<section class="bg-white p-6 rounded-lg shadow-md mb-6">';
                    echo '<h2 class="text-2xl font-semibold text-gray-800 mb-4">Các Môn học đã Đăng ký</h2>';
                    
                    

                    if (!empty($data['registrations'])) {
                        echo '<div class="table-responsive">';
                        echo '<table class="min-w-full bg-white border border-gray-200 text-sm whitespace-nowrap">';
                        echo '<thead>';
                        echo '<tr class="bg-gray-50">';
                        echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">STT</th>';
                        echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Mã lớp học</th>';
                        echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Tên môn học</th>';
                        echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Trạng thái</th>';
                        echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Ngày ĐK</th>';
                        echo '<th class="py-3 px-4 border-b text-left text-gray-600 font-semibold">Ngày KQ</th>';
                        echo '<th class="py-3 px-4 border-b text-right text-gray-600 font-semibold">Hành động</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        foreach ($data['registrations'] as $reg) {
                            echo '<tr class="hover:bg-gray-50">';
                            echo '<td class="py-3 px-4 border-b text-gray-700 text-center">' . htmlspecialchars($reg->registration_id) . '</td>';
                            echo '<td class="py-3 px-4 border-b text-gray-700 font-mono">' . htmlspecialchars($reg->class_code) . '</td>';
                            echo '<td class="py-3 px-4 border-b text-gray-700 font-semibold">' . htmlspecialchars($reg->course_name) . '</td>';
                            
                            // Status cell
                            echo '<td class="py-3 px-4 border-b text-gray-700">';
                            $status_text = htmlspecialchars($reg->status);
                            $status_color = 'gray';
                            if ($status_text === 'Đã xác nhận') $status_color = 'green';
                            if ($status_text === 'Chờ xác nhận') $status_color = 'yellow';
                            if ($status_text === 'Đã hủy') $status_color = 'red';
                            echo "<span class='px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{$status_color}-100 text-{$status_color}-800'>{$status_text}</span>";
                            echo '</td>';

                            // Registration Date cell
                            echo '<td class="py-3 px-4 border-b text-gray-700">' . date('d/m/Y H:i', strtotime($reg->registration_date)) . '</td>';

                            // Result Date cell
                            echo '<td class="py-3 px-4 border-b text-gray-700">';
                            if (!empty($reg->result_date)) {
                                echo date('d/m/Y H:i', strtotime($reg->result_date));
                            } else {
                                echo '...';
                            }
                            echo '</td>';

                            // Action cell
                            echo '<td class="py-3 px-4 border-b text-right">';
                            if ($reg->status === 'Chờ xác nhận') {
                                echo '<a href="?view=registrations&action=cancel&id=' . htmlspecialchars($reg->registration_id) . '" onclick="return confirm(\'Bạn có chắc chắn muốn hủy đăng ký môn học này không?\')" class="bg-yellow-500 hover:bg-yellow-700 text-white text-xs font-bold py-2 px-3 rounded inline-flex items-center transition duration-150">';
                                echo '<i class="fas fa-times-circle mr-1"></i> Hủy';
                                echo '</a>';
                            }
                            echo '</td>';

                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo '<p class="text-gray-600">Bạn chưa đăng ký môn học nào.</p>';
                    }
                    echo '</section>';
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
</body>
</html>