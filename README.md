# Đồ án Demo PHP MVC

Dự án PHP đơn giản được xây dựng trên mô hình MVC tự chế, bao gồm các chức năng cơ bản như đăng nhập, đăng xuất và một trang dashboard đơn giản.

## Tính năng chính

-   Kiến trúc MVC (Model-View-Controller) tùy chỉnh.
-   Cơ chế định tuyến (Routing) để xử lý URL thân thiện.
-   Xác thực người dùng (Đăng nhập / Đăng xuất).
-   Sử dụng PDO để tương tác với cơ sở dữ liệu một cách an toàn.
-   Quản lý người dùng, khóa học và đăng ký.
-   Chức năng tìm kiếm linh hoạt cho khóa học và đăng ký.
-   Kiểm soát giới hạn tín chỉ (tối đa 20 tín chỉ) khi đăng ký khóa học.

## Yêu cầu

-   XAMPP (hoặc một môi trường tương tự có Apache, MySQL, PHP).
-   Apache với module `mod_rewrite` đã được kích hoạt.
-   PHP
-   MySQL hoặc MariaDB

## Hướng dẫn Cài đặt và Chạy dự án

### Bước 1: Sao chép dự án vào `htdocs`

Đây là bước đầu tiên và quan trọng nhất để máy chủ Apache có thể tìm thấy và phục vụ dự án của bạn.

1.  **Sao chép (Copy)** toàn bộ thư mục dự án `PHP_MVC_PROJECT`.
2.  Dán (Paste) thư mục này vào thư mục `htdocs` của XAMPP. Đường dẫn mặc định thường là: `c:\xampp\htdocs`.
3.  Kết quả cuối cùng là bạn sẽ có thư mục dự án tại: `c:\xampp\htdocs\PHP_MVC_PROJECT`.

### Bước 2: Cài đặt Cơ sở dữ liệu

1.  Khởi động **Apache** và **MySQL** từ XAMPP Control Panel.
2.  Truy cập vào phpMyAdmin: `http://localhost/phpmyadmin`.
3.  Tạo một cơ sở dữ liệu mới với tên là `demo_php` và bảng mã (collation) là `utf8mb4_general_ci`.
4.  Chọn cơ sở dữ liệu `demo_php` vừa tạo.
5.  Vào tab **Import** (Nhập) trong phpMyAdmin.
6.  Nhấn vào **Choose File** (Chọn tệp) và chọn tệp `demo_php.sql` (tệp này nằm trong thư mục gốc của dự án).
7.  Nhấn **Go** (Thực hiện) để nhập dữ liệu và cấu trúc bảng.

### Bước 3: Cấu hình Apache

Để ứng dụng có thể sử dụng URL thân thiện (`/users/login` thay vì `index.php?url=...`), bạn cần kích hoạt `mod_rewrite`.

1.  Mở tệp cấu hình Apache tại: `c:\xampp\apache\conf\httpd.conf`.
2.  Tìm dòng `#LoadModule rewrite_module modules/mod_rewrite.so`.
3.  Xóa dấu `#` ở đầu dòng để kích hoạt module.
4.  Khởi động lại Apache trong XAMPP Control Panel.

## Chạy ứng dụng

Sau khi hoàn tất các bước trên, bạn có thể truy cập ứng dụng bằng cách mở trình duyệt và vào địa chỉ:

```
http://localhost/PHP_MVC_PROJECT/
```

Bạn sẽ được tự động chuyển hướng đến trang đăng nhập. Hãy sử dụng tài khoản `admin` / `123` hoặc `student` / `123` để đăng nhập.

## Vai trò người dùng và Chức năng

Dự án này hỗ trợ hai vai trò người dùng chính: **Quản trị viên (Admin)** và **Sinh viên (Student)**, mỗi vai trò có các quyền và chức năng riêng biệt.

### 1. Vai trò Sinh viên (Student)

Người dùng có vai trò Sinh viên có thể thực hiện các chức năng sau:

*   **Xem danh sách khóa học:** Xem các khóa học hiện có để đăng ký.
*   **Đăng ký khóa học:** Đăng ký các khóa học mong muốn, có kiểm tra giới hạn tín chỉ (tối đa 20 tín chỉ) cho mỗi học kỳ.
*   **Xem các môn học đã đăng ký:** Xem danh sách các khóa học mà mình đã đăng ký.
*   **Hủy đăng ký:** Hủy bỏ đăng ký đối với các khóa học của mình.
*   **Xem thông tin học phần đã xác nhận:** Xem các khóa học đã được quản trị viên xác nhận, được nhóm theo học kỳ.
*   **Tìm kiếm khóa học:** Tìm kiếm khóa học theo tên hoặc mã môn học.
*   **Tìm kiếm đăng ký:** Tìm kiếm các đăng ký khóa học của bản thân.
*   **Đổi mật khẩu:** Thay đổi mật khẩu tài khoản cá nhân (truy cập qua biểu tượng hồ sơ).
*   **Xem thông tin cá nhân:** Xem và cập nhật thông tin hồ sơ cá nhân.
*   **Đăng xuất:** Đăng xuất khỏi hệ thống (truy cập qua biểu tượng hồ sơ).

### 2. Vai trò Quản trị viên (Admin)

Người dùng có vai trò Quản trị viên có toàn quyền quản lý hệ thống và có thể thực hiện tất cả các chức năng của Sinh viên, cùng với các chức năng quản trị bổ sung sau:

*   **Quản lý Khóa học:**
    *   Xem danh sách tất cả các khóa học.
    *   Thêm khóa học mới vào hệ thống (lưu ý: mã lớp học phải là duy nhất, nếu trùng sẽ báo lỗi).
    *   Xóa các khóa học khỏi hệ thống.
    *   Tìm kiếm khóa học theo tên hoặc mã môn học.
*   **Quản lý Đăng ký:**
    *   Xem tất cả các đăng ký khóa học của tất cả người dùng.
    *   Xác nhận các yêu cầu đăng ký khóa học.
    *   Từ chối các yêu cầu đăng ký khóa học.
    *   Tìm kiếm tất cả các đăng ký theo tên sinh viên, tên khóa học hoặc mã khóa học.
*   **Quản lý Tài khoản Người dùng:**
    *   Xem danh sách tất cả các tài khoản người dùng.
    *   Thêm người dùng mới vào hệ thống (có thể chỉ định vai trò là Sinh viên hoặc Quản trị viên).
    *   Chỉnh sửa thông tin tài khoản người dùng hiện có (bao gồm cả vai trò).
    *   Xóa tài khoản người dùng (không thể xóa tài khoản quản trị viên khác).
*   **Đổi mật khẩu:** Thay đổi mật khẩu tài khoản cá nhân (truy cập qua biểu tượng hồ sơ).
*   **Xem thông tin cá nhân:** Xem và cập nhật thông tin hồ sơ cá nhân.
*   **Đăng xuất:** Đăng xuất khỏi hệ thống (truy cập qua biểu tượng hồ sơ).

## Cấu trúc thư mục

Dự án được tổ chức theo mô hình MVC (Model-View-Controller) tùy chỉnh, với các thư mục chính sau:

-   `/app`: Chứa toàn bộ logic nghiệp vụ và các thành phần cốt lõi của ứng dụng.
    -   `/app/bootstrap.php`: Tệp khởi tạo ứng dụng, nơi các thành phần chính được nạp và cấu hình.
    -   `/app/controllers`: Chứa các lớp Controller. Mỗi Controller xử lý các yêu cầu từ người dùng, tương tác với Model để lấy dữ liệu và truyền dữ liệu đó đến View để hiển thị. Ví dụ: `Users.php`, `Courses.php`.
    -   `/app/helpers`: Chứa các tệp chức năng hỗ trợ (helper functions) được sử dụng rộng rãi trong ứng dụng, giúp tái sử dụng mã và giữ cho Controller gọn gàng. Ví dụ: `session_helper.php`, `url_helper.php`.
    -   `/app/models`: Chứa các lớp Model. Mỗi Model đại diện cho một thực thể dữ liệu (ví dụ: User, Course, Registration) và chứa logic để tương tác với cơ sở dữ liệu (CRUD operations). Ví dụ: `User.php`, `Course.php`, `Registration.php`.
    -   `/app/views`: Chứa các tệp View. Các View chịu trách nhiệm hiển thị dữ liệu cho người dùng. Chúng thường chứa mã HTML trộn lẫn với PHP để hiển thị dữ liệu được truyền từ Controller.
        -   `/app/views/partials`: Chứa các phần nhỏ của View có thể tái sử dụng (ví dụ: các hàng của bảng, header, footer).
-   `/config`: Chứa các tệp cấu hình của ứng dụng.
    -   `/config/config.php`: Chứa các hằng số cấu hình toàn cục như thông tin cơ sở dữ liệu, URL gốc của ứng dụng, tên ứng dụng, v.v.
-   `/core`: Chứa các lớp lõi tạo nên framework MVC tùy chỉnh.
    -   `/core/App.php`: Lớp xử lý định tuyến (routing), phân tích URL và gọi Controller/Method tương ứng.
    -   `/core/Controller.php`: Lớp Controller cơ sở mà tất cả các Controller khác kế thừa. Nó cung cấp các phương thức chung như `model()` để tải Model và `view()` để tải View.
    -   `/core/Database.php`: Lớp xử lý kết nối và tương tác với cơ sở dữ liệu bằng PDO, cung cấp các phương thức để thực thi truy vấn.
-   `/public`: Là thư mục gốc của web (web root). Đây là thư mục duy nhất có thể truy cập trực tiếp từ trình duyệt.
    -   `/public/index.php`: Tệp front-controller, tất cả các yêu cầu đều đi qua tệp này. Nó khởi tạo ứng dụng và bắt đầu quá trình định tuyến.
    -   `/public/.htaccess`: Tệp cấu hình Apache để xử lý các yêu cầu URL thân thiện (URL Rewriting), chuyển hướng tất cả các yêu cầu đến `index.php`.
    -   `/public/img`: Chứa các tài nguyên hình ảnh của ứng dụng.
        -   `/public/img/avatars`: Chứa hình ảnh đại diện mặc định cho người dùng.
    -   Các tệp CSS, JavaScript (nếu có) cũng sẽ được đặt trong thư mục này hoặc các thư mục con tương ứng.
-   `demo_php.sql`: Tệp chứa cấu trúc cơ sở dữ liệu và dữ liệu mẫu cần thiết để khởi tạo ứng dụng.
-   `generate_hash.php`: Một tệp tiện ích dùng để tạo mật khẩu băm (hashed password) cho mục đích thử nghiệm hoặc khởi tạo.
-   `index.php`: Tệp chính của ứng dụng, thường chuyển hướng đến thư mục `/public`.
-   `README.md`: Tệp này, chứa thông tin tổng quan về dự án, hướng dẫn cài đặt, và mô tả các chức năng).