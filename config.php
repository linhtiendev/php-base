<!-- các hằng của pj -->
<?php

const _MODULE = 'home'; // điều hướng mặc định là trang home
const _ACTION = 'dashboard'; // mặc định trang dashboard nếu action rỗng

const _CODE = true; // check truy cập hợp lệ

// thiết lập host
// $_SERVER('HTTP_HOST') giúp xác định host đang chạy
define('_WEB_HOST', 'http://' . $_SERVER['HTTP_HOST'] . '/management_user'); //http://localhost/management_user
define('_WEB_HOST_TEMPLATES', _WEB_HOST . '/templates');

// thiết lập path
// hằng số __DIR__ giúp xác định path
define('_WEB_PATH', __DIR__); // \xampp\htdocs\management_user
define('_WEB_PATH_TEMPLATES', _WEB_PATH . '/templates');
