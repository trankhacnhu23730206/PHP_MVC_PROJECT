<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Quản Trị</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-100 min-h-screen flex">
    <aside class="w-64 bg-white shadow-lg p-6 flex flex-col items-center border-r border-gray-200">
        <div class="mt-auto w-full">
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
        
        </main>
</body>
</html>