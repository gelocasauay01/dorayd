<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/mysql.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/controller/CartController.php");

$cartController = new CartController($dataSource);

if (isset($_POST["action"]) && $_POST["action"] === "delete" && isset($_POST["cart_id"])) {
    $cartController->deleteCartItems($_POST["cart_id"]);
    header("Location: /view/pages/cart.php");
} else if (isset($_POST["action"]) && $_POST["action"] === "add_quantity") {
    $cartController->setQuantity($_POST["cart_id"], $_POST["quantity"]);
    die("done");
}

die();
