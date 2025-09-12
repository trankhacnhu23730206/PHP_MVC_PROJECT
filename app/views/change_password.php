<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> 
        body { font-family: 'Inter', sans-serif; } 
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Đổi mật khẩu</h2>

        <?php if (!empty($data['success_message'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Thành công!</strong>
                <span class="block sm:inline"> <?php echo $data['success_message']; ?></span>
            </div>
        <?php endif; ?>

        <form action="<?php echo URLROOT; ?>/public/users/changePassword" method="post">
            <div class="mb-4">
                <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu hiện tại:</label>
                <input type="password" id="current_password" name="current_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['current_password_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['current_password']; ?>">
                <?php if (!empty($data['current_password_err'])): ?>
                    <p class="text-red-500 text-xs italic"><?php echo $data['current_password_err']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu mới:</label>
                <input type="password" id="new_password" name="new_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['new_password_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['new_password']; ?>">
                <?php if (!empty($data['new_password_err'])): ?>
                    <p class="text-red-500 text-xs italic"><?php echo $data['new_password_err']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-6">
                <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Xác nhận mật khẩu mới:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['confirm_password_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
                <?php if (!empty($data['confirm_password_err'])): ?>
                    <p class="text-red-500 text-xs italic"><?php echo $data['confirm_password_err']; ?></p>
                <?php endif; ?>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Đổi mật khẩu
                </button>
                <a href="<?php echo URLROOT; ?>/public/users/dashboard" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</body>
</html>