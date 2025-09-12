<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <div class="w-full max-w-md mx-auto">
            <div class="bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Đổi Mật Khẩu</h2>
                
                <?php if(isset($data['success_message'])): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline"><?php echo $data['success_message']; ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo URLROOT; ?>/public/users/changePassword">
                    <div class="mb-4">
                        <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu hiện tại:</label>
                        <input type="password" name="current_password" id="current_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo (!empty($data['current_password_err'])) ? 'border-red-500' : ''; ?>">
                        <span class="text-red-500 text-xs italic"><?php echo $data['current_password_err'] ?? ''; ?></span>
                    </div>
                    <div class="mb-4">
                        <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu mới:</label>
                        <input type="password" name="new_password" id="new_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo (!empty($data['new_password_err'])) ? 'border-red-500' : ''; ?>">
                        <span class="text-red-500 text-xs italic"><?php echo $data['new_password_err'] ?? ''; ?></span>
                    </div>
                    <div class="mb-6">
                        <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Xác nhận mật khẩu mới:</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 <?php echo (!empty($data['confirm_password_err'])) ? 'border-red-500' : ''; ?>">
                        <span class="text-red-500 text-xs italic"><?php echo $data['confirm_password_err'] ?? ''; ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-200">
                            Cập Nhật Mật Khẩu
                        </button>
                    </div>
                     <div class="text-center mt-4">
                        <a href="<?php echo URLROOT; ?>/public/users/dashboard" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Quay về Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>