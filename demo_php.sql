-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 13, 2025 lúc 12:16 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `demo_php`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `class_code` varchar(50) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `credits` int(11) NOT NULL,
  `teacher` varchar(255) NOT NULL,
  `schedule_day` varchar(50) NOT NULL,
  `schedule_time` varchar(50) NOT NULL,
  `school_year` varchar(50) NOT NULL,
  `semester` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `courses`
--

INSERT INTO `courses` (`id`, `class_code`, `course_name`, `credits`, `teacher`, `schedule_day`, `schedule_time`, `school_year`, `semester`, `created_at`) VALUES
(102, 'MA202.N2', 'Toán cao cấp A2', 3, 'Trần Thị B', 'Thứ 4', '9:00 - 11:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(103, 'EN03.N5', 'Tiếng Anh chuyên ngành', 2, 'Lê Thị C', 'Thứ 6', '13:00 - 15:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(104, 'PHY101.N1', 'Vật lý đại cương', 3, 'Phạm Văn D', 'Thứ 3', '15:00 - 17:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(105, 'IT101.N1', 'Cấu trúc dữ liệu và giải thuật', 3, 'Nguyễn Hoàng Anh', 'Thứ 2', '7:00 - 9:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(106, 'IT102.N2', 'Lập trình hướng đối tượng', 3, 'Trần Minh Long', 'Thứ 3', '9:00 - 11:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(107, 'BS101.N1', 'Quản trị học đại cương', 2, 'Lê Thị Mai', 'Thứ 4', '13:00 - 15:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(108, 'EN101.N5', 'Tiếng Anh giao tiếp 1', 2, 'Michael Johnson', 'Thứ 5', '7:00 - 9:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(109, 'MA101.N3', 'Giải tích 1', 4, 'Vũ Đình Tuấn', 'Thứ 6', '9:00 - 11:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(110, 'IT201.N1', 'Cơ sở dữ liệu', 3, 'Đặng Bảo Trung', 'Thứ 2', '15:00 - 17:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(111, 'IT202.N4', 'Mạng máy tính', 3, 'Hồ Quang Vinh', 'Thứ 3', '7:00 - 9:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(112, 'BS201.N2', 'Marketing căn bản', 2, 'Phan Thị Thu Hà', 'Thứ 4', '9:00 - 11:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(113, 'GD101.N1', 'Thiết kế đồ họa 2D', 3, 'Võ Tấn Phát', 'Thứ 5', '13:00 - 15:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(114, 'PE101.N10', 'Giáo dục thể chất 1', 1, 'Nguyễn Văn Nam', 'Thứ 7', '7:00 - 9:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(115, 'IT301.N1', 'Hệ điều hành', 3, 'Lý Thanh Bình', 'Thứ 2', '9:00 - 11:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(116, 'BS301.N3', 'Quản trị tài chính', 3, 'Đỗ Mỹ Linh', 'Thứ 3', '13:00 - 15:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(117, 'MA203.N1', 'Xác suất thống kê', 3, 'Ngô Bảo Châu', 'Thứ 4', '7:00 - 9:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(118, 'IT401.N1', 'An toàn thông tin', 3, 'Phạm Công Minh', 'Thứ 6', '15:00 - 17:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(119, 'SS101.N2', 'Kỹ năng mềm', 2, 'Dương Thùy Trang', 'Thứ 5', '9:00 - 11:00', '2023-2024', 1, '2025-09-13 05:56:45'),
(120, 'IT103.N1', 'Kiến trúc máy tính', 3, 'Nguyễn Hoàng Anh', 'Thứ 2', '7:00 - 9:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(121, 'IT104.N2', 'Lập trình web', 3, 'Trần Minh Long', 'Thứ 3', '9:00 - 11:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(122, 'BS102.N1', 'Kinh tế học vĩ mô', 2, 'Lê Thị Mai', 'Thứ 4', '13:00 - 15:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(123, 'EN102.N5', 'Tiếng Anh giao tiếp 2', 2, 'Michael Johnson', 'Thứ 5', '7:00 - 9:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(124, 'MA102.N3', 'Đại số tuyến tính', 3, 'Vũ Đình Tuấn', 'Thứ 6', '9:00 - 11:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(125, 'IT203.N1', 'Phân tích thiết kế hệ thống', 3, 'Đặng Bảo Trung', 'Thứ 2', '15:00 - 17:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(126, 'IT204.N4', 'Quản trị mạng', 3, 'Hồ Quang Vinh', 'Thứ 3', '7:00 - 9:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(127, 'BS202.N2', 'Quản trị nhân sự', 2, 'Phan Thị Thu Hà', 'Thứ 4', '9:00 - 11:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(128, 'GD102.N1', 'Thiết kế đồ họa 3D', 3, 'Võ Tấn Phát', 'Thứ 5', '13:00 - 15:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(129, 'PE102.N10', 'Giáo dục thể chất 2', 1, 'Nguyễn Văn Nam', 'Thứ 7', '7:00 - 9:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(130, 'IT302.N1', 'Công nghệ phần mềm', 3, 'Lý Thanh Bình', 'Thứ 2', '9:00 - 11:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(131, 'BS302.N3', 'Thị trường chứng khoán', 3, 'Đỗ Mỹ Linh', 'Thứ 3', '13:00 - 15:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(132, 'MA204.N1', 'Toán rời rạc', 3, 'Ngô Bảo Châu', 'Thứ 4', '7:00 - 9:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(133, 'IT402.N1', 'Trí tuệ nhân tạo', 3, 'Phạm Công Minh', 'Thứ 6', '15:00 - 17:00', '2023-2024', 2, '2025-09-13 05:56:45'),
(134, 'SS102.N2', 'Kỹ năng thuyết trình', 2, 'Dương Thùy Trang', 'Thứ 5', '9:00 - 11:00', '2023-2024', 2, '2025-09-13 05:56:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Chờ xác nhận',
  `result_date` timestamp NULL DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female','other') DEFAULT 'other',
  `role` enum('student','admin') NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `gender`, `role`) VALUES
(5, 'admin', '$2y$10$U/nWhD52fQaQC0.aq8MRZuo39ie.swVIWSpdQ4eQOOYiwOJasMuSy', 'male', 'admin'),
(7, 'student', '$2y$10$l6LbPp6t1upxCEpGHCCegub9OiXKo5FoN24MthgnPYLN5JRxm46Om', 'male', 'student');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT cho bảng `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
