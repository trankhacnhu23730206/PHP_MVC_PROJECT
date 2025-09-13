<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Khóa học mới</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> 
        body { font-family: 'Inter', sans-serif; } 
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Thêm Khóa học mới</h2>

        <form action="<?php echo URLROOT; ?>/public/courses/addCourse" method="post">
            <div class="mb-4">
                <label for="class_code" class="block text-gray-700 text-sm font-bold mb-2">Mã lớp học:</label>
                <input type="text" id="class_code" name="class_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['class_code_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['class_code']; ?>">
                <?php if (!empty($data['class_code_err'])) : ?>
                    <p class="text-red-500 text-xs italic"><?php echo $data['class_code_err']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="course_name" class="block text-gray-700 text-sm font-bold mb-2">Tên môn học:</label>
                <input type="text" id="course_name" name="course_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['course_name_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['course_name']; ?>">
                <?php if (!empty($data['course_name_err'])) : ?>
                    <p class="text-red-500 text-xs italic"><?php echo $data['course_name_err']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="credits" class="block text-gray-700 text-sm font-bold mb-2">Số tín chỉ:</label>
                <input type="number" id="credits" name="credits" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['credits_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['credits']; ?>">
                <?php if (!empty($data['credits_err'])) : ?>
                    <p class="text-red-500 text-xs italic"><?php echo $data['credits_err']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="teacher" class="block text-gray-700 text-sm font-bold mb-2">Giáo viên:</label>
                <input type="text" id="teacher" name="teacher" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['teacher_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['teacher']; ?>">
                <?php if (!empty($data['teacher_err'])) : ?>
                    <p class="text-red-500 text-xs italic"><?php echo $data['teacher_err']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="schedule_day" class="block text-gray-700 text-sm font-bold mb-2">Lịch học (Thứ):</label>
                <input type="text" id="schedule_day" name="schedule_day" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['schedule_day_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['schedule_day']; ?>">
                <?php if (!empty($data['schedule_day_err'])) : ?>
                    <p class="text-red-500 text-xs italic"><?php echo $data['schedule_day_err']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="schedule_time" class="block text-gray-700 text-sm font-bold mb-2">Lịch học (Giờ):</label>
                <input type="text" id="schedule_time" name="schedule_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['schedule_time_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['schedule_time']; ?>">
                <?php if (!empty($data['schedule_time_err'])) : ?>
                    <p class="text-red-500 text-xs italic"><?php echo $data['schedule_time_err']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="semester" class="block text-gray-700 text-sm font-bold mb-2">Học kỳ:</label>
                <input type="number" id="semester" name="semester" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['semester_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['semester']; ?>">
                <?php if (!empty($data['semester_err'])) : ?>
                    <p class="text-red-500 text-xs italic"><?php echo $data['semester_err']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="school_year" class="block text-gray-700 text-sm font-bold mb-2">Năm học:</label>
                <input type="text" id="school_year" name="school_year" placeholder="YYYY-YYYY" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline <?php echo (!empty($data['school_year_err'])) ? 'border-red-500' : ''; ?>" value="<?php echo $data['school_year']; ?>">
                <?php if (!empty($data['school_year_err'])) : ?>
                    <p class="text-red-500 text-xs italic"><?php echo $data['school_year_err']; ?></p>
                <?php endif; ?>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Thêm Khóa học
                </button>
                <a href="<?php echo URLROOT; ?>/public/users/dashboard?view=courses" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</body>
</html>