<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/mysql.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/controller/AuthController.php");

session_start();
$auth = new AuthController($dataSource);

if (isset($_SESSION["user_id"])) {
    $auth->loginWithId($_SESSION["user_id"]);
}
