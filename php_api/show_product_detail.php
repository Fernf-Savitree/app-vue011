<?php

/* ✅ เปิด error ตอนพัฒนา (แนะนำ) */
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/* ❌ ถ้าโปรดักชันค่อยปิด */
// error_reporting(0);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'condb.php';

try {

    /* ✅ ตรวจสอบ id */
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo json_encode([
            "success" => false,
            "message" => "ไม่พบ Product ID"
        ]);
        exit;
    }

    /* ✅ รับค่า id */
    $id = $_GET['id'];  
    // ไม่ต้อง intval ถ้า product_id เป็น string เช่น 00000001

    /* ✅ Query */
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->execute([$id]);

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    /* ✅ ถ้าไม่พบข้อมูล */
    if (!$product) {
        echo json_encode([
            "success" => false,
            "message" => "ไม่พบสินค้า"
        ]);
        exit;
    }

    /* ✅ ส่งข้อมูลกลับ */
    echo json_encode([
        "success" => true,
        "data" => $product
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Database Error",
        "error" => $e->getMessage()   // 🔥 ลบออกได้ถ้าโปรดักชัน
    ]);

}