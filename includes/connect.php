<!-- kết nối với db -->
<?php
if (!defined('_CODE')) {
    die('Access denied...');
};

// Tạo đối tượng $conn (kết nối cơ sở dữ liệu) để các file khác sử dụng.
try {
    // Thiết lập kết nối PDO
    if (class_exists('PDO')) {
        // Chuỗi DSN chứa thông tin để kết nối cơ sở dữ liệu
        $dsn = 'mysql:dbname=' . _DB . ';host=' . _HOST;
        $option = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // set utf8
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // tạo thông báo ra ngoại lệ khi gặp lỗi
        ];
        // Tạo một đối tượng PDO để kết nối cơ sở dữ liệu
        $conn = new PDO($dsn, _USER, _PASS, $option);
    }
} catch (Exception $exception) {
    echo '<div> style="color:red; padding: 5px 15px; border:1px solid red;">';
    echo $exception->getMessage() . '<br>';
    echo '</div>';
    die();
}
