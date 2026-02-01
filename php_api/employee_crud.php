<?php
include 'condb.php';
header("Content-Type: application/json; charset=UTF-8");

try {
    $method = $_SERVER['REQUEST_METHOD'];

    // ✅ ดึงข้อมูลลูกค้าทั้งหมด
    if ($method === "GET") {
        $stmt = $conn->prepare("SELECT * FROM employees ORDER BY emp_id DESC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "data" => $result]);
    }

    // ✅ เพิ่มข้อมูลพนักงาน
    elseif ($method === "POST") {
        // ตรวจสอบว่าข้อมูลมาจาก JSON หรือ form-data
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';

        if (stripos($contentType, "application/json") !== false) {
            $data = json_decode(file_get_contents("php://input"), true);
        } else {
            $data = $_POST;
        }

        // ตรวจสอบค่าว่าง
        if (empty($data["full_name"]) || empty($data["department"]) || empty($data["salary"]) || empty($data["active"])) {
            echo json_encode(["success" => false, "message" => "กรุณากรอกข้อมูลให้ครบ"]);
            exit;
        }

        // เพิ่มข้อมูลพนักงาน
        $stmt = $conn->prepare("INSERT INTO employees (full_name, department, salary, active)
                                VALUES (:full_name, :department, :salary, :active)");

        $stmt->bindParam(":full_name", $data["full_name"]);
        $stmt->bindParam(":department", $data["department"]);
        $stmt->bindParam(":salary", $data["salary"]);
        $stmt->bindParam(":active", $data["active"]);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "เพิ่มข้อมูลพนักงานเรียบร้อย"]);
        } else {
            echo json_encode(["success" => false, "message" => "ไม่สามารถเพิ่มข้อมูลพนักงานได้"]);
        }
    }

    // ✅ แก้ไขข้อมูล
    elseif ($method === "PUT") {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["emp_id"])) {
            echo json_encode(["success" => false, "message" => "ไม่พบค่า emp_id"]);
            exit;
        }

        $emp_id = intval($data["emp_id"]);

       
            $sql = "UPDATE employees 
                   SET full_name = :full_name, 
                        department = :department, 
                        salary = :salary, 
                        active = :active
                    WHERE emp_id = :id";
      

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":full_name", $data["full_name"]);
        $stmt->bindParam(":department", $data["department"]);
        $stmt->bindParam(":salary", $data["salary"]);
        $stmt->bindParam(":active", $data["active"]);
        //if (!empty($data["password"])) {
            //$stmt->bindParam(":password", $password_hash);
        //}
        $stmt->bindParam(":id", $emp_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "แก้ไขข้อมูลเรียบร้อย"]);
        } else {
            echo json_encode(["success" => false, "message" => "ไม่สามารถแก้ไขข้อมูลได้"]);
        }
    
    }
        // ✅ ลบข้อมูล
    elseif ($method === "DELETE") {
            $data = json_decode(file_get_contents("php://input"), true);
    
            if (!isset($data["emp_id"])) {
                echo json_encode(["success" => false, "message" => "ไม่พบค่า emp_id"]);
                exit;
            }

        $stmt = $conn->prepare("DELETE FROM employees WHERE emp_id = :id");
        $stmt->bindParam(":id", $data["emp_id"], PDO::PARAM_INT);

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