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
        /* Thêm style để làm nổi bật link đang active */
        .sidebar-link.active {
            background-color: #eff6ff; /* bg-blue-50 */
            color: #2563eb; /* text-blue-700 */
            font-weight: 600;
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
                // Xác định trang hiện tại để thêm class 'active'
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
            </nav>

        <div class="p-4 mt-auto">
            <a href="<?php echo URLROOT; ?>/public/users/logout" class="flex items-center justify-center space-x-2 text-red-500 hover:text-red-700 py-2 px-4 rounded-lg transition duration-200 hover:bg-gray-100">
                <i class="fas fa-sign-out-alt text-lg"></i>
                <span>Đăng xuất</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">Chào mừng, <?php echo htmlspecialchars($_SESSION['user_username']); ?>!</span>
                <img class="w-10 h-10 rounded-full border-2 border-blue-500" src="https://via.placeholder.com/150" alt="Profile Picture">
            </div>
        </header>
        
        <?php
            // Lấy giá trị 'view' từ URL, nếu không có thì mặc định là 'dashboard'
            $view = $_GET['view'] ?? 'dashboard';

            // Sử dụng switch case để quyết định hiển thị nội dung nào
            switch ($view) {
                case 'courses':
                    // --- Chỉ hiển thị phần này khi view=courses ---
                    echo '<section class="bg-white p-6 rounded-lg shadow-md mb-6">';
                    echo '<h2 class="text-2xl font-semibold text-gray-800 mb-4">Danh sách Môn học</h2>';
                    
                    if (!empty($data['courses'])) {
                        echo '<div class="overflow-x-auto">';
                        echo '<table class="min-w-full bg-white border border-gray-200">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th class="py-2 px-4 border-b text-left text-gray-600 font-medium">ID</th>';
                        echo '<th class="py-2 px-4 border-b text-left text-gray-600 font-medium">Tên Môn học</th>';
                        // Thêm các cột khác nếu cần
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        foreach ($data['courses'] as $course) {
                            echo '<tr>';
                            echo '<td class="py-2 px-4 border-b text-gray-700">' . htmlspecialchars($course->id) . '</td>';
                            echo '<td class="py-2 px-4 border-b text-gray-700">' . htmlspecialchars($course->name) . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo '<p class="text-gray-600">Không có môn học nào để hiển thị.</p>';
                    }
                    echo '</section>';
                    break;

                case 'dashboard':
                default:
                    // --- Hiển thị nội dung mặc định cho dashboard ---
                    echo '<section class="bg-white p-6 rounded-lg shadow-md mb-6">';
                    echo '<h2 class="text-2xl font-semibold text-gray-800 mb-4">Chào mừng đến với trang quản trị!</h2>';
                    echo '<p class="text-gray-600">Vui lòng chọn một mục từ thanh điều hướng bên trái để bắt đầu.</p>';
                    echo '</section>';
                    break;
            }
        ?>
        
    </main>
</body>
</html>