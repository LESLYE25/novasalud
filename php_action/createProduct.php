<?php 	
require_once 'core.php';

if ($_POST) {	
    $productName    = $_POST['productName'];
    $quantity       = $_POST['quantity'];
    $rate           = $_POST['rate'];
    $brandName      = $_POST['brandName'];
    $categoryName   = $_POST['categoryName'];
    $bno            = $_POST['bno'];
    $expdate        = $_POST['expdate'];
    $productStatus  = $_POST['productStatus'];
    $stock          = $_POST['stock'];
    $orderDate      = date('Y-m-d');

    // Subida de imagen
    $image = $_FILES['Medicine']['name'];
    $target = "../assets/myimages/" . basename($image);

    if (!move_uploaded_file($_FILES['Medicine']['tmp_name'], $target)) {
        // Si falla la subida, redirige con error (opcional: mostrar mensaje en pantalla)
        header("Location: ../product.php?error=imagen");
        exit;
    }

    // Preparar la consulta
    $stmt = $connect->prepare("INSERT INTO product 
        (product_name, product_image, brand_id, categories_id, quantity, rate, bno, expdate, stock, added_date, active, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $active = $productStatus;
    $status = 1;

    $stmt->bind_param(
        "ssiiiisssiii",
        $productName,
        $image,
        $brandName,
        $categoryName,
        $quantity,
        $rate,
        $bno,
        $expdate,
        $stock,
        $orderDate,
        $active,
        $status
    );

    if ($stmt->execute()) {
        // Redirige si todo sale bien
        header('Location: ../product.php?success=1');
        exit;
    } else {
        // Error en la ejecución
        header("Location: ../product.php?error=bd");
        exit;
    }

    $stmt->close();
    $connect->close();
}
?>
