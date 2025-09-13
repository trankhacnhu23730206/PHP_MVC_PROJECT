<?php
$user = $data['user'];
flash('profile_message');
?>
<section class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Thông tin cá nhân</h2>
    <p><strong>Tên đăng nhập:</strong> <?php echo htmlspecialchars($user->username); ?></p>
    <p><strong>Giới tính:</strong> <?php echo htmlspecialchars($user->gender); ?></p>
    <p><strong>Vai trò:</strong> <?php echo htmlspecialchars($user->role); ?></p>
</section>
