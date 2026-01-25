<?php
include 'condb.php'; //เชื่อมต่อฐานข้อมูล

header('Content-Type: application/json');

try {
    $stmt = $conn->query("SELECT * FROM products");
    $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($datas);
    
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>