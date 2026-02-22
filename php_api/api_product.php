<?php

include 'condb.php';

$action = $_POST['action'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action) {
    // เพิ่ม / แก้ไข / ลบ
    switch($action) {

        case 'add':
            $product_name = $_POST['product_name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $category_id = $_POST['category_id'];

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

            $sql = "INSERT INTO products (product_name, description, price, stock, category_id, image)
                    VALUES (:product_name, :description, :price, :stock, :category_id, :image)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':image', $filename);

            if ($stmt->execute()) {
                echo json_encode(["message" => "เพิ่มสินค้าสำเร็จ"]);
            } else {
                echo json_encode(["error" => "เพิ่มสินค้าล้มเหลว"]);
            }
            break;

        case 'update':
            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $category_id = $_POST['category_id'];


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

            $sql = "UPDATE products SET 
                        product_name = :product_name,
                        description = :description,
                        price = :price,
                        stock = :stock
                        category_id = :category_id

                        $imageSQL
                    WHERE product_id = :product_id";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':product_id', $product_id);
            if (isset($filename)) $stmt->bindParam(':image', $filename);

            if ($stmt->execute()) {
                echo json_encode(["message" => "แก้ไขสินค้าสำเร็จ"]);
            } else {
                echo json_encode(["error" => "แก้ไขสินค้าล้มเหลว"]);
            }
            break;

        case 'delete':
            $product_id = $_POST['product_id'];
            $stmt = $conn->prepare("DELETE FROM products WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id);
            if ($stmt->execute()) {
                echo json_encode(["message" => "ลบสินค้าสำเร็จ"]);
            } else {
                echo json_encode(["error" => "ลบสินค้าล้มเหลว"]);
            }
            break;

        default:
            echo json_encode(["error" => "Action ไม่ถูกต้อง"]);
            break;
    }

} else {
    // ประเภทสินค้า
    if (isset($_GET['type']) && $_GET['type'] == 'categories') {
            // ดึงข้อมูลประเภทสินค้า
            $stmt = $conn->prepare("SELECT * FROM categories");
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(["success" => true, "data" => $categories]);
        } else {
            // แสดงข้อมูลสินค้าทั้งหมด
            $stmt = $conn->prepare("SELECT pd.*, ct.category_name FROM products pd INNER JOIN categories ct ON pd.category_id = ct.category_id");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(["success" => true, "data" => $products]);
        }
}
?>