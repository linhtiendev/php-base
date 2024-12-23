<!-- chứa function dùng chung  -->
<?php
//  defined() kiểm tra hàm số có tồn tại hay không
// !defined() kiểm tra có không tồn tại hay không
if (!defined('_CODE')) {
    // truy cập kh hợp lệ sẽ dừng điều hướng truy cập
    die('Access denied...');
};
