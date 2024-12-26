<!-- chứa hàm liên quan đến xử lý db -->
<?php
if (!defined('_CODE')) {
    die('Access denied...');
};

// hàm query thao tác trực tiếp với db
function query($sql, $data = [], $check = false)
{
    global $conn;
    $result = false;
    try {
        // Chuẩn bị sẵn một câu truy vấn SQL để có thể thực thi một cách an toàn
        $statement = $conn->prepare($sql);

        if (!empty($data)) {
            $result = $statement->execute($data);
        } else {
            $result = $statement->execute();
        }
    } catch (Exception $exp) {
        echo $exp->getMessage() . '<br >';
        echo 'File: ' . $exp->getFile() . '<br >';
        echo 'Line: ' . $exp->getLine();
        die();
    }
    if ($check) {
        return $statement;
    }
    return $result;
}

// hàm insert vào data
function insert($table, $data)
{
    // lấy key trong data, $data = ['fullname' => 'John Doe', 'age' => 25];
    $key = array_keys($data); // Kết quả: ['fullname', 'age']
    // dùng hàm implode để nối phần tử của mảng thành một chuỗi 
    $field = implode(',', $key); // Chuỗi các tên cột, cách nhau bởi dấu phẩy ,
    $valuetb = ':' . implode(',:', $key);

    // tạo biến truyền hàm query để thao tác với db
    $sql = 'INSERT INTO ' . $table . '(' . $field . ')' . 'VALUES(' . $valuetb . ')';
    // truy vấn sẽ có dạng INSERT INTO student (fullname, age) VALUES (:fullname, :age)
    $kq = query($sql, $data); //truy vấn và trả ra kết quả
    return $kq;
}

// hàm update data
// $condition là biến điều kiện để sửa
function update($table, $data, $condition = '')
{
    $update = '';
    foreach ($data as $key => $value) {
        $update .= $key . '= :' . $key . ',';
    }
    // xóa dấu , ở cuối chuỗi để câu truy vấn SQL hợp lệ.
    $update = trim($update, ',');
    // kết quả: $update = "fullname = :fullname, email = :email, phone = :phone";
    if (!empty($condition)) {
        $sql = 'UPDATE ' . $table . ' SET ' . $update . ' WHERE ' . $condition;
    } else {
        $sql = 'UPDATE ' . $table . ' SET ' . $update;
    }
    $kq = query($sql, $data);
    return $kq;
    // UPDATE users SET fullname = :fullname, email = :email, phone = :phone WHERE id = 2
}

// hàm delete
function delete($table, $condition = '')
{
    if (empty($condition)) {
        die('Error: Condition is required to delete data.');
        // $sql = 'DELETE FROM ' . $table;
    } else {
        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $condition;
    }
    $kq = query($sql);
    return $kq;
}

// select data
// lấy nhiều dòng dữ liệu
function getRaw($sql)
{
    $result = query($sql, '', true);
    if (is_object($result)) {
        $dataFetch = $result->fetchAll(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}

// lấy một dòng dữ liệu
function oneRaw($sql)
{
    $result = query($sql, '', true);
    if (is_object($result)) {
        $dataFetch = $result->fetch(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}

// đếm số dòng dữ liệu
function getRaws($sql)
{
    $result = query($sql, '', true);
    if (!empty($result)) {

        return $result->rowCount();
    }
}
