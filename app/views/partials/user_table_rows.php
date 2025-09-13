<?php
if (!empty($data['users'])) {
    foreach ($data['users'] as $user) {
        echo '<tr class="hover:bg-gray-50">';
        echo '<td class="py-3 px-4 border-b text-gray-700 text-center">' . htmlspecialchars($user->id) . '</td>';
        echo '<td class="py-3 px-4 border-b text-gray-700 font-semibold">' . htmlspecialchars($user->username) . '</td>';
        echo '<td class="py-3 px-4 border-b text-gray-700">' . htmlspecialchars($user->gender) . '</td>';
        echo '<td class="py-3 px-4 border-b text-gray-700">' . htmlspecialchars($user->role) . '</td>';
        echo '<td class="py-3 px-4 border-b text-right">';
        echo '<a href="' . URLROOT . '/public/users/editUser/' . htmlspecialchars($user->id) . '" class="bg-yellow-500 hover:bg-yellow-700 text-white text-xs font-bold py-2 px-3 rounded inline-flex items-center transition duration-150 mr-2">';
        echo '<i class="fas fa-edit mr-1"></i> Sửa';
        echo '</a>';
        if ($user->role !== 'admin') { // Prevent deleting admin users
            echo '<a href="' . URLROOT . '/public/users/deleteUser/' . htmlspecialchars($user->id) . '" onclick="return confirm(\'Bạn có chắc chắn muốn xóa người dùng này không?\')" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-2 px-3 rounded inline-flex items-center transition duration-150">';
            echo '<i class="fas fa-trash mr-1"></i> Xóa';
            echo '</a>';
        }
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5" class="text-center py-4 text-gray-600">Không có người dùng nào để hiển thị.</td></tr>';
}
?>