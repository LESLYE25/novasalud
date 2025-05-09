<?php 	
require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	
    $productName    = $_POST['productName'];
    $quantity       = $_POST['quantity'];
    $rate           = $_POST['rate'];
    $brandName      = $_POST['brandName'];
    $categoryName   = $_POST['categoryName'];
    $mrp            = $_POST['mrp'];
    $bno            = $_POST['bno'];
    $expdate        = $_POST['expdate'];
    $productStatus  = $_POST['productStatus'];
    $stock          = $_POST['stock'];
    $orderDate      = date('Y-m-d');

    // Manejo de la imagen
    $image = $_FILES['Medicine']['name'];
    $target = "../assets/myimages/" . basename($image);
    $upload = move_uploaded_file($_FILES['Medicine']['tmp_name'], $target);

    if (!$upload) {
        $valid['messages'] = "Error al subir la imagen.";
        echo json_encode($valid);
        exit;
    }

    // Consulta preparada
    $stmt = $connect->prepare("INSERT INTO product 
        (product_name, product_image, brand_id, categories_id, quantity, rate, mrp, bno, expdate, stock, added_date, active, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $active = $productStatus;
    $status = 1;

    $stmt->bind_param(
        "ssiiiisssisii",
        $productName,
        $image,
        $brandName,
        $categoryName,
        $quantity,
        $rate,
        $mrp,
        $bno,
        $expdate,
        $stock,
        $orderDate,
        $active,
        $status
    );

    if ($stmt->execute()) {
        $valid['success'] = true;
        $valid['messages'] = "Producto agregado correctamente.";
        header('Location: ../product.php');
        exit;
    } else {
        $valid['success'] = false;
        $valid['messages'] = "Error al agregar producto: " . $stmt->error;
    }

    $stmt->close();
    $connect->close();

    echo json_encode($valid);
}
?>
