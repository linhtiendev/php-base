<?php
if (!defined('_CODE')) {
    die('Access denied...');
}

$dataPageTitle = ['pageTitle' => 'Đăng nhập tài khoản'];
layouts('header', $dataPageTitle);
addCss('auth/login');

// kiểm tra trang thái đăng nhập, nếu đã đăng nhập và có token sẽ điều hướng về dashboard
if (isLogin()) {
    redirect('?module=home&action=dashboard');
}

// kiểm tra phương thức post
if (isPost()) {
    $filterAll = filter();

    // check rỗng cho input
    if (!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))) {
        // kiểm tra đăng nhập
        $email = $filterAll['email'];
        $password = $filterAll['password'];

        // truy vấn thông tin users theo email
        $userQuery = oneRaw("SELECT password, id FROM users WHERE email = '$email'");

        if (!empty($userQuery)) {
            // lấy password được hash trong db ra
            $passwordHash = $userQuery['password'];
            // lấy id trong db ra
            $userId = $userQuery['id'];

            // so sánh password được nhập trong input và password được hash trong db 
            if (password_verify($password, $passwordHash)) {
                // token login check user có đang đăng nhập
                // tạo token login
                $tokenLogin = sha1(uniqid() . time());

                // lấy dl để insert vào bảng login token
                $dataInsert = [
                    'user_id' => $userId,
                    'token' => $tokenLogin,
                    'create_at' => date('Y-m-d H:i:s'),
                ];
                // insert dataInsert vào bảng logintoken
                $insertStatus = insert('logintoken', $dataInsert);
                if ($insertStatus) {
                    // insert thành công
                    // lưu login token vào session
                    setSession('logintoken', $tokenLogin);
                    redirect('?module=home&action=dashboard');
                } else {
                    setFlashData('msg', 'Không thể đăng nhập, vui lòng thử lại sau');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Mật khẩu không chính xác');
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', 'Email không tồn tại');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Vui lòng nhập email và mật khẩu');
        setFlashData('msg_type', 'danger');
    }
    redirect('?module=auth&action=login');
}

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');

?>

<div class="row">
    <div class="col-6" style="margin: 50px auto;">
        <h2 class="text-center">Đăng Nhập</h2>
        <?php
        if (!empty($msg)) {
            getSmg($msg, $msg_type);
        }
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="title" class="form__label">Email</label>
                <input name="email" type="email" class="form-control form__input" placeholder="Nhập email" />
            </div>
            <div class="form-group">
                <label for="" class="form__label">Password</label>
                <input name="password" type="password" class="form-control form__input" placeholder="Nhập mật khẩu" />
            </div>
            <button type="submit" class="primary_btn_custom submit__btn btn btn-primary btn-block">Đăng nhập</button>
            <hr />
            <div class="d-flex justify-content-between">
                <p class="text-center"><a href="?module=auth&action=register" class="text-dark text-decoration-none">Đăng ký</a></p>
                <p class="text-center"><a href="?module=auth&action=forgot_password" class="text-dark text-decoration-none">Quên mật khẩu</a></p>
            </div>
        </form>
    </div>
</div>

<?php
layouts('footer');
?>