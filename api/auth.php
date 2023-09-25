<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/mysql.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/controller/AuthController.php");

$auth = new AuthController($dataSource);

if (isset($_GET["action"]) && $_GET["action"] === "login") {
    // Handle Login
    try {
        $auth->loginWithCredentials($_GET["email"], $_GET["password"]);
        session_start();
        $_SESSION["user_id"] = $auth->getUser()->getId();
        header("Location: /index.php");
    } catch (NoAccountException) {
        session_destroy();
        header("Location: /view/pages/login.php?error=1");
    }
} else if (isset($_GET["action"]) && $_GET["action"] === "logout") {
    // Handle Logout
    $auth->logout();
    session_start();
    session_destroy();
    header("Location: /index.php");
} else {
    // Handle Register
    $auth->register($_POST);
    header("Location: /view/pages/login.php");
}

die();
