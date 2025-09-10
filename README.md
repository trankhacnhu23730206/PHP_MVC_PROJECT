# Đồ án Demo PHP MVC

Dự án PHP đơn giản được xây dựng trên mô hình MVC tự chế, bao gồm các chức năng cơ bản như đăng nhập, đăng xuất và một trang dashboard đơn giản.

## Tính năng chính

-   Kiến trúc MVC (Model-View-Controller) tùy chỉnh.
-   Cơ chế định tuyến (Routing) để xử lý URL thân thiện.
-   Xác thực người dùng (Đăng nhập / Đăng xuất).
-   Sử dụng PDO để tương tác với cơ sở dữ liệu một cách an toàn.

## Yêu cầu

-   XAMPP (hoặc một môi trường tương tự có Apache, MySQL, PHP).
-   Apache với module `mod_rewrite` đã được kích hoạt.
-   PHP
-   MySQL hoặc MariaDB

## Hướng dẫn Cài đặt và Chạy dự án

### Bước 1: Cài đặt Cơ sở dữ liệu

1.  Khởi động **Apache** và **MySQL** từ XAMPP Control Panel.
2.  Truy cập vào phpMyAdmin: `http://localhost/phpmyadmin`.
3.  Tạo một cơ sở dữ liệu mới với tên là `demo_php` và bảng mã (collation) là `utf8mb4_general_ci`.
4.  Chọn database `demo_php` vừa tạo, vào tab **SQL** và chạy đoạn mã sau để tạo bảng `users`:

    ```sql
    CREATE TABLE `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```

### Bước 2: Tạo người dùng mẫu

Để có thể đăng nhập, bạn cần tạo ít nhất một người dùng trong database.

1.  **Tạo mật khẩu mã hóa**:
    *   Truy cập vào đường dẫn: `http://localhost/demoPHP/generate_hash.php` (hoặc `http://localhost:<PORT>/demoPHP/generate_hash.php` nếu bạn dùng port khác).
    *   Trang này sẽ tạo ra một chuỗi mật khẩu đã được mã hóa cho mật khẩu `123`. Hãy **sao chép** chuỗi mã hóa đó.

2.  **Thêm người dùng vào database**:
    *   Quay lại tab **SQL** trong phpMyAdmin và chạy lệnh sau. **Lưu ý:** thay thế `CHUỖI_MÃ_HÓA_BẠN_VỪA_SAO_CHÉP` bằng chuỗi bạn đã sao chép ở trên.

    ```sql
    INSERT INTO `users` (`username`, `password`) VALUES ('testuser', 'CHUỖI_MÃ_HÓA_BẠN_VỪA_SAO_CHÉP');
    ```

    *   Sau bước này, bạn đã có một người dùng với tài khoản là `testuser` và mật khẩu là `123`.

### Bước 3: Cấu hình Apache

Để ứng dụng có thể sử dụng URL thân thiện (`/users/login` thay vì `index.php?url=...`), bạn cần kích hoạt `mod_rewrite`.

1.  Mở tệp cấu hình Apache tại: `c:\xampp\apache\conf\httpd.conf`.
2.  Tìm dòng `#LoadModule rewrite_module modules/mod_rewrite.so`.
3.  Xóa dấu `#` ở đầu dòng để kích hoạt module.
4.  Khởi động lại Apache trong XAMPP Control Panel.

## Chạy ứng dụng

Sau khi hoàn tất các bước trên, bạn có thể truy cập ứng dụng bằng cách mở trình duyệt và vào địa chỉ:

```
http://localhost/demoPHP/
```

Bạn sẽ được tự động chuyển hướng đến trang đăng nhập. Hãy sử dụng tài khoản `testuser` / `123` để đăng nhập.

## Cấu trúc thư mục

-   `/app`: Chứa logic chính của ứng dụng (controllers, models, views).
-   `/config`: Chứa các tệp cấu hình, ví dụ như thông tin kết nối database.
-   `/core`: Chứa các lớp lõi của framework (bộ định tuyến, controller cơ sở...).
-   `/public`: Là thư mục gốc của web, chứa các tệp công khai như `index.php` (front-controller), `.htaccess` và sau này có thể chứa CSS, JS, hình ảnh.
