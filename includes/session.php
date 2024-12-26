<!-- hàm liên quan đến session và cookie -->
<!-- dùng session để gửi dữ liệu giữa các phiên làm việc -->
<?php
if (!defined('_CODE')) {
    die('Access denied...');
};
// hàm gán session
function setSession($key, $value)
{
    return $_SESSION[$key] = $value;
}

// hàm đọc session
function getSession($key = '')
{
    if (empty($key)) {
        return $_SESSION;
    } else {
        // kiểm tra xem khóa có tồn tại
        if (isset($_SESSION[$key])) { {
                return $_SESSION[$key];
            }
        }
    }
}

// hàm xóa session
function removeSession($key = '')
{
    if (empty($key)) {
        session_destroy();
        return true;
    } else {
        // kiểm tra xem khóa có tồn tại
        if (isset($_SESSION[$key])) { {
                // gọi unset xóa khóa khỏi session
                unset($_SESSION[$key]);
                return true;
            }
        }
    }
}

// hàm lấy dl trong session và nó tự xóa đi

// hàm gán flash data
function setFlashData($key, $value)
{
    // phân biệt dữ liệu flash với các dữ liệu thông thường khác trong session.
    $key = 'flash_' . $key;
    return setSession($key, $value);
}

// hàm đọc flash data
// lấy dữ liệu flash từ session và sau khi lấy xong sẽ tự động xóa dữ liệu đó khỏi session.
function getFlashData($key)
{
    // tạo ra khóa chính xác mà dữ liệu flash đã được lưu trữ trong session
    $key = 'flash_' . $key;
    $data = getSession($key);
    //  xóa khóa đó khỏi session, vì dữ liệu flash chỉ cần được sử dụng một lần duy nhất
    removeSession($key);
    return $data;
}
