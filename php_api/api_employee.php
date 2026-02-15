<?php

include 'condb.php';

$action = $_POST['action'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action) {
    // เพิ่ม / แก้ไข / ลบ
    switch($action) {

        case 'add':
            $full_name = $_POST['full_name'];
            $department = $_POST['department'];
            $salary = $_POST['salary'];
            $active = $_POST['active'];

            // อัพโหลดไฟล์รูป
            $filename = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = "image/";
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $filename = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $targetDir . $filename;
                move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
            }

            $sql = "INSERT INTO employees (full_name, department, salary, active, image)
                    VALUES (:full_name, :department, :salary, :active, :image)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':department', $department);
            $stmt->bindParam(':salary', $salary);
            $stmt->bindParam(':active', $active);
            $stmt->bindParam(':image', $filename);

            if ($stmt->execute()) {
                echo json_encode(["message" => "เพิ่มพนักงานสำเร็จ"]);
            } else {
                echo json_encode(["error" => "เพิ่มพนักงานล้มเหลว"]);
            }
            break;

        case 'update':
            $emp_id = $_POST['emp_id'];
            $full_name = $_POST['full_name'];
            $department = $_POST['department'];
            $salary = $_POST['salary'];
            $active = $_POST['active'];

            // อัพโหลดไฟล์รูป
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = "image/";
                $filename = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $targetDir . $filename;
                move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
                $imageSQL = ", image = :image";
            } else {
                $imageSQL = "";
            }

            $sql = "UPDATE employees SET 
                        full_name = :full_name,
                        department = :department,
                        salary = :salary,
                        active = :active
                        $imageSQL
                    WHERE emp_id = :emp_id";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':department', $department);
            $stmt->bindParam(':salary', $salary);
            $stmt->bindParam(':active', $active);
            $stmt->bindParam(':emp_id', $emp_id);
            if (isset($filename)) $stmt->bindParam(':image', $filename);

            if ($stmt->execute()) {
                echo json_encode(["message" => "แก้ไขพนักงานสำเร็จ"]);
            } else {
                echo json_encode(["error" => "แก้ไขพนักงานล้มเหลว"]);
            }
            break;

        case 'delete':
            $emp_id = $_POST['emp_id'];
            $stmt = $conn->prepare("DELETE FROM employees WHERE emp_id = :emp_id");
            $stmt->bindParam(':emp_id', $emp_id);
            if ($stmt->execute()) {
                echo json_encode(["message" => "ลบพนักงานสำเร็จ"]);
            } else {
                echo json_encode(["error" => "ลบพนักงานล้มเหลว"]);
            }
            break;

        default:
            echo json_encode(["error" => "Action ไม่ถูกต้อง"]);
            break;
    }

} else {
    // GET: ดึงข้อมูลพนักงาน
    $stmt = $conn->prepare("SELECT * FROM employees ORDER BY emp_id DESC");
    if ($stmt->execute()) {
        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "data" => $employees]);
    } else {
        echo json_encode(["success" => false, "data" => []]);
    }
}
?>