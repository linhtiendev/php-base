<!-- chứa function dùng chung  -->
<?php
//  defined() kiểm tra hàm số có tồn tại hay không
// !defined() kiểm tra có không tồn tại hay không
if (!defined('_CODE')) {
    // truy cập kh hợp lệ sẽ dừng điều hướng truy cập
    die('Access denied...');
};

// tạo biến layout để truyền
function layouts($layoutName = 'header')
{
    if (file_exists(_WEB_PATH_TEMPLATES . '/layout/' . $layoutName . '.php')) {
        require_once _WEB_PATH_TEMPLATES . '/layout/' . $layoutName . '.php';
    }
}

// hàm xử lý truyền file css
function addCss($cssFiles = [])
{
    // Kiểm tra nếu $cssFiles là một chuỗi và chuyển nó thành mảng
    if (is_string($cssFiles)) {
        $cssFiles = [$cssFiles];
    }
    // Kiểm tra nếu $cssFiles là một mảng không rỗng
    if (!empty($cssFiles)) {
        foreach ($cssFiles as $cssFile) {
            // Kiểm tra nếu $cssFile là chuỗi và không rỗng
            if (is_string($cssFile) && !empty($cssFile)) {
                echo '<link rel="stylesheet" href="' . _WEB_HOST_TEMPLATES . '/css/' . $cssFile . '.css">';
            }
        }
    }
}
