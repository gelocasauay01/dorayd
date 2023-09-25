<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/auth.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ProductController.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/controller/CartController.php");

$productController = new ProductController($dataSource);
$cartController = new CartController($dataSource);

if (isset($_POST["action"]) && $_POST["action"] === "add_to_cart") {
    if ($auth->checkLoggedIn()) {
        $cart = $productController->checkInCart($auth->getUser()->getId(), $_POST["variant_id"]);
        if (empty($cart)) {
            $productController->addToCart($auth->getUser()->getId(), $_POST["variant_id"], $_POST["quantity"]);
        } else {
            $cartController->setQuantity($cart[0]["CartId"], $_POST["quantity"]);
        }
        header("Location: /view/pages/cart.php");
    } else {
        header("Location: /view/pages/login.php");
    }
}

die();
