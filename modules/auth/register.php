<?php
if (!defined('_CODE')) {
    die('Access denied...');
}
$dataPageTitle = ['pageTitle' => 'Đăng ký tài khoản'];
layouts('header', $dataPageTitle);
addCss('auth/register');

if (isPost()) {
    $filterAll = filter();
    $errors = []; // mảng chứa lỗi

    // validate fullname: bắt buộc nhập, min 5 kí tự
    if (empty($filterAll['fullname'])) {
        $errors['fullname']['required'] = 'Bạn phải nhập đầy đủ họ tên';
    } else {
        if (strlen($filterAll['fullname']) < 5) {
            $errors['fullname']['min'] = 'Bạn phải nhập ít nhất 5 kí tự';
        }
    }

    // validate email: bắt buộc nhập, đúng định dạng, kiểm tra tồn tại trong db
    if (empty($filterAll['email'])) {
        $errors['email']['required'] = 'Bạn phải nhập email';
    } else {
        $email = $filterAll['email'];
        // kiểm tra email trong db trùng lập và lấy ra
        $sql = "SELECT id FROM users WHERE email = '$email'";
        // getRows trả về > 0 <=> email đã tồn tại
        if (getRows($sql) > 0) {
            $errors['email']['unique'] = 'Email đã tồn tại';
        }
    }

    // validate phone: bắt buộc nhập, đúng định dạng(số đầu là số 0 và phía sau đủ 9 số),
    if (empty($filterAll['phone'])) {
        $errors['phone']['required'] = 'Bạn phải nhập số điện thoại';
    } else {
        if (!isPhone($filterAll['phone'])) {
            $errors['phone']['isPhone'] = 'Số điện thoại không hợp lệ';
        }
    }

    // validate password: bắt buộc nhập, >=8 ký tự
    if (empty($filterAll['password'])) {
        $errors['password']['required'] = 'Bạn phải nhập mật khẩu';
    } else {
        if (strlen($filterAll['password']) < 8) {
            $errors['password']['min'] = 'Mật khẩu ít nhất 8 ký tự';
        }
    }

    // validate password confirm: bắt buộc nhập, giống với password
    if (empty($filterAll['password_confirm'])) {
        $errors['password_confirm']['required'] = 'Bạn phải nhập xác nhận mật khẩu';
    } else {
        if ($filterAll['password'] != $filterAll['password_confirm']) {
            $errors['password_confirm']['match'] = 'Mật khẩu nhập lại không đúng';
        }
    }
    if (empty($errors)) {
        // gọi session flashdata
        setFlashData('smg', 'Đăng ký thành công!');
        setFlashData('smg_type', 'success');
        // redirect('?module=auth&action=login');
    } else {
        // gọi session flashdata
        setFlashData('smg', 'Vui lòng kiểm tra lại dữ liệu!');
        setFlashData('smg_type', 'danger');
        // lưu dl của mảng vào lỗi
        setFlashData('errors', $errors);
        // lưu lại dl cũ, tránh nhập lại input
        setFlashData('old_data', $filterAll);
        // điều hướng đến trang auth
        redirect('?module=auth&action=register');
    }
}

// lấy flash data
$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old_data = getFlashData('old_data'); // biến lưu lại giá trị cũ
?>

<div class="row">
    <div class="col-6" style="margin: 50px auto;">
        <h2 class="text-center text-uppercase">Đăng Ký</h2>
        <?php
        if (!empty($smg)) {
            getSmg($smg, $smg_type);
        }
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="title" class="form__label">Họ và Tên</label>
                <input name="fullname" type="fullname" class="form-control form__input" placeholder="Nhập họ và tên"
                    value="<?php echo oldData('fullname', $old_data) ?>" />
                <?php
                // reset: lấy ra phần tử đầu tiên của mảng
                // echo (!empty($errors['fullname'])) ? '<span class="error">' . reset($errors['fullname']) . '</span>' : null;
                echo form_error('fullname', '<span class="error">', '</span>', $errors);
                ?>
            </div>
            <div class="form-group">
                <label for="title" class="form__label">Email</label>
                <input name="email" type="email" class="form-control form__input" placeholder="Nhập email"
                    value="<?php echo oldData('email', $old_data) ?>" />
                <?php
                echo form_error('email', '<span class="error">', '</span>', $errors);
                ?>
            </div>
            <div class="form-group">
                <label for="title" class="form__label">Số điện thoại</label>
                <input name="phone" type="number" class="form-control form__input" placeholder="Nhập số điện thoại"
                    value="<?php echo oldData('phone', $old_data) ?>" />
                <?php
                echo form_error('phone', '<span class="error">', '</span>', $errors);
                ?>
            </div>
            <div class="form-group">
                <label for="title" class="form__label">Mật khẩu</label>
                <input name="password" type="password" class="form-control form__input" placeholder="Nhập mật khẩu" />
                <?php
                echo form_error('password', '<span class="error">', '</span>', $errors);
                ?>
            </div>
            <div class="form-group">
                <label for="title" class="form__label">Xác nhận mật khẩu</label>
                <input name="password_confirm" type="password" class="form-control form__input" placeholder="Nhập lại mật khẩu" />
                <?php
                echo form_error('password_confirm', '<span class="error">', '</span>', $errors);
                ?>
            </div>
            <div class="d-flex mt-4">
                <button type="submit" class="primary_btn_custom submit__btn btn btn-primary btn-block">Đăng Ký</button>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <p class="text-center">Bạn đã có tài khoản?</p>
                <p class="text-center"><a href="?module=auth&action=login" class="text-dark text-decoration-none">Đăng nhập</a></p>
            </div>
        </form>
    </div>
</div>

<?php
layouts('footer');
?>