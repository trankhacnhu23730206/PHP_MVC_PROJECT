<?php
// Calculate colspan dynamically
$colspan = (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') ? 9 : 8;

if (!empty($data['registrations'])) {
    foreach ($data['registrations'] as $reg) {
        echo '<tr class="hover:bg-gray-50">';
        if ($_SESSION['user_role'] === 'admin') {
            echo '<td class="py-3 px-4 border-b text-gray-700 font-semibold">' . (isset($reg->username) ? htmlspecialchars($reg->username) : 'N/A') . '</td>';
        }
        echo '<td class="py-3 px-4 border-b text-gray-700 font-mono">' . htmlspecialchars($reg->class_code) . '</td>';
        echo '<td class="py-3 px-4 border-b text-gray-700 font-semibold">' . htmlspecialchars($reg->course_name) . '</td>';
        echo '<td class="py-3 px-4 border-b text-gray-700 text-center">' . htmlspecialchars($reg->credits) . '</td>';
        echo '<td class="py-3 px-4 border-b text-gray-700">' . htmlspecialchars($reg->semester) . '</td>';
        
        // Status cell
        echo '<td class="py-3 px-4 border-b text-gray-700">';
        $status_text = htmlspecialchars($reg->status);
        $status_color = 'gray';
        if ($status_text === 'Đã xác nhận') $status_color = 'green';
        if ($status_text === 'Chờ xác nhận') $status_color = 'yellow';
        if ($status_text === 'Đã hủy' || $status_text === 'Từ chối') $status_color = 'red';
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
        if ($_SESSION['user_role'] === 'admin') {
            if ($reg->status === 'Chờ xác nhận') {
                echo '<a href="?view=registrations&action=confirm&id=' . htmlspecialchars($reg->registration_id) . '" onclick="return confirm(\'Bạn có chắc chắn muốn xác nhận đăng ký này không?\')" class="bg-green-500 hover:bg-green-700 text-white text-xs font-bold py-2 px-3 rounded inline-flex items-center transition duration-150 mr-2">';
                echo '<i class="fas fa-check-circle mr-1"></i>Xác nhận';
                echo '</a>';
                echo '<a href="?view=registrations&action=reject&id=' . htmlspecialchars($reg->registration_id) . '" onclick="return confirm(\'Bạn có chắc chắn muốn từ chối đăng ký này không?\')" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-2 px-3 rounded inline-flex items-center transition duration-150">';
                echo '<i class="fas fa-times-circle mr-1"></i> Từ chối';
                echo '</a>';
            }
        } else { // User view
            if ($reg->status === 'Chờ xác nhận') {
                echo '<a href="?view=registrations&action=cancel&id=' . htmlspecialchars($reg->registration_id) . '" onclick="return confirm(\'Bạn có chắc chắn muốn hủy đăng ký môn học này không?\')" class="bg-yellow-500 hover:bg-yellow-700 text-white text-xs font-bold py-2 px-3 rounded inline-flex items-center transition duration-150">';
                echo '<i class="fas fa-times-circle mr-1"></i> Hủy';
                echo '</a>';
            }
        }
        echo '</td>';

        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="' . $colspan . '" class="text-center py-4 text-gray-600">Không tìm thấy đăng kí nào.</td></tr>';
}
?>