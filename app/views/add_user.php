<?php flash('user_message'); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Người dùng mới</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Thêm Người dùng mới</h2>

        <form action="<?php echo URLROOT; ?>/public/users/addUser" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Tên đăng nhập:</label>
                <input type="text" name="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['username_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['username']; ?>">
                <span class="text-red-500 text-xs italic"><?php echo $data['username_err']; ?></span>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu:</label>
                <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['password_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['password']; ?>">
                <span class="text-red-500 text-xs italic"><?php echo $data['password_err']; ?></span>
            </div>
            <div class="mb-4">
                <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Xác nhận Mật khẩu:</label>
                <input type="password" name="confirm_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['confirm_password_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
                <span class="text-red-500 text-xs italic"><?php echo $data['confirm_password_err']; ?></span>
            </div>
            <div class="mb-4">
                <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Giới tính:</label>
                <select name="gender" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="male" <?php echo ($data['gender'] == 'male') ? 'selected' : ''; ?>>Nam</option>
                    <option value="female" <?php echo ($data['gender'] == 'female') ? 'selected' : ''; ?>>Nữ</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Vai trò:</label>
                <select name="role" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="student" <?php echo ($data['role'] == 'student') ? 'selected' : ''; ?>>Sinh viên</option>
                    <option value="admin" <?php echo ($data['role'] == 'admin') ? 'selected' : ''; ?>>Quản trị viên</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Thêm Người dùng
                </button>
                <a href="<?php echo URLROOT; ?>/public/users/dashboard?view=user_management" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</body>
</html>