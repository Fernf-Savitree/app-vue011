<?php
include 'condb.php';
header("Content-Type: application/json; charset=UTF-8");

try {
    $method = $_SERVER['REQUEST_METHOD'];

    // ✅ ดึงข้อมูลประเภทสินค้าทั้งหมด
    if ($method === "GET") {
        $stmt = $conn->prepare("SELECT * FROM type ORDER BY Type_ID DESC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "data" => $result]);
    }

    // ✅ เพิ่มข้อมูลประเภทสินค้า
    elseif ($method === "POST") {
        // ตรวจสอบว่าข้อมูลมาจาก JSON หรือ form-data
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';

        if (stripos($contentType, "application/json") !== false) {
            $data = json_decode(file_get_contents("php://input"), true);
        } else {
            $data = $_POST;
        }

        // ตรวจสอบค่าว่าง
        if (empty($data["Type_name"])) {
            echo json_encode(["success" => false, "message" => "กรุณากรอกข้อมูลให้ครบ"]);
            exit;
        }

        // เพิ่มข้อมูลพนักงาน
        $stmt = $conn->prepare("INSERT INTO type (Type_name)
                                VALUES (:Type_name)");

        $stmt->bindParam(":Type_name", $data["Type_name"]);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "เพิ่มข้อมูลพนักงานเรียบร้อย"]);
        } else {
            echo json_encode(["success" => false, "message" => "ไม่สามารถเพิ่มข้อมูลพนักงานได้"]);
        }
    }

    // ✅ แก้ไขข้อมูล
    elseif ($method === "PUT") {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["Type_ID"])) {
            echo json_encode(["success" => false, "message" => "ไม่พบค่า Type_ID"]);
            exit;
        }

        $Type_ID = intval($data["Type_ID"]);

       
            $sql = "UPDATE type
                   SET Type_name = :Type_name
                        WHERE Type_ID = :id";


        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":Type_name", $data["Type_name"]);
        //if (!empty($data["password"])) {
            //$stmt->bindParam(":password", $password_hash);
        //}
        $stmt->bindParam(":id", $Type_ID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "แก้ไขข้อมูลเรียบร้อย"]);
        } else {
            echo json_encode(["success" => false, "message" => "ไม่สามารถแก้ไขข้อมูลได้"]);
        }
    
    }
        // ✅ ลบข้อมูล
    elseif ($method === "DELETE") {
            $data = json_decode(file_get_contents("php://input"), true);
    
            if (!isset($data["Type_ID"])) {
                echo json_encode(["success" => false, "message" => "ไม่พบค่า Type_ID"]);
                exit;
            }

        $stmt = $conn->prepare("DELETE FROM type WHERE Type_ID = :id");
        $stmt->bindParam(":id", $data["Type_ID"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "ลบข้อมูลเรียบร้อย"]);
        } else {
            echo json_encode(["success" => false, "message" => "ไม่สามารถลบข้อมูลได้"]);
        }
    }

    else {
        echo json_encode(["success" => false, "message" => "Method ไม่ถูกต้อง"]);
    }

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>