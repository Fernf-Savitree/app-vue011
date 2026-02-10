<?php

include 'condb.php';

$data = json_decode(file_get_contents("php://input"), true);

if (
    !isset($data['first_name']) ||
    !isset($data['last_name']) ||
    !isset($data['phone']) ||
    !isset($data['email'])
) {
    echo json_encode([
        "success" => false,
        "message" => "ข้อมูลไม่ครบ"
    ]);
    exit;
}

try {
    $sql = "INSERT INTO student
            (first_name, last_name, phone, email)
            VALUES
            (:first_name, :last_name, :phone, :email)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':first_name' => $data['first_name'],
        ':last_name'  => $data['last_name'],
        ':phone'     => $data['phone'],
        ':email'  => $data['email'],
    ]);

    echo json_encode([
        "success" => true,
        "message" => "เพิ่มข้อมูลเรียบร้อย"
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}