<?php
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
    foreach ($data['courses'] as $course) {
        echo '<tr class="hover:bg-gray-50">';
        echo '<td class="py-3 px-4 border-b text-gray-700 text-center">' . htmlspecialchars($course->id) . '</td>';
        echo '<td class="py-3 px-4 border-b text-gray-700 font-mono">' . htmlspecialchars($course->class_code) . '</td>';
        echo '<td class="py-3 px-4 border-b text-gray-700 font-semibold">' . htmlspecialchars($course->course_name) . '</td>';
        echo '<td class="py-3 px-4 border-b text-gray-700 text-center">' . htmlspecialchars($course->credits) . '</td>';
        echo '<td class="py-3 px-4 border-b text-gray-700">' . htmlspecialchars($course->teacher) . '</td>';
        echo '<td class="py-3 px-4 border-b text-gray-700">' . htmlspecialchars($course->schedule_day) . ' (' . htmlspecialchars($course->schedule_time) . ')</td>';
        echo '<td class="py-3 px-4 border-b text-gray-700 text-center">' . htmlspecialchars($course->semester) . '</td>';

        // Conditional "Register" button
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
} else {
    echo '<tr><td colspan="8" class="text-center py-4 text-gray-600">Không tìm thấy môn học nào.</td></tr>';
}
