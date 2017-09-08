<?php

session_start();
$functions = $_POST['functions'];
$location = $_SESSION['location'];

if ($functions == "getPriceQtyQtyDmg") {

    $product_id = $_POST['product_id'];
    getPriceQtyQtyDmg($product_id);
}

function getPriceQtyQtyDmg($product_id) {

    require_once('config/config.php');

    global $location;

    $sql = "select price,quantity,quantity_damaged from stock WHERE id = " . $product_id . " AND location = '" . $location . "';";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $price = $row['price'];
        $quantity = $row['quantity'];
        $quantity_damaged = $row['quantity_damaged'];
        $arr = $arrayName = array('price' => $row['price'], 'quantity' => $row['quantity'], 'quantity_damaged' => $row['quantity_damaged']);

        echo json_encode($arr);
    }
}
?>

