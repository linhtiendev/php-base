<!-- chứa hàm liên quan đến xử lý db -->
<?php
if (!defined('_CODE')) {
    die('Access denied...');
};

// hàm query thao tác trực tiếp với db
function query($sql, $data = [])
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
