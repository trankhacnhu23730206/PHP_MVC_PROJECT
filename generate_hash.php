<?php
// Mật khẩu bạn muốn mã hóa
$password = '123';

// Mã hóa mật khẩu
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

echo 'Mật khẩu gốc: ' . htmlspecialchars($password) . '<br>';
echo 'Mật khẩu đã mã hóa: <pre>' . htmlspecialchars($hashedPassword) . '</pre><br>';
echo 'Sao chép chuỗi mã hóa ở trên và dùng nó trong câu lệnh INSERT SQL của bạn.';
?>
