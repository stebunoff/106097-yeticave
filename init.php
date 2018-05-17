<?php
require_once 'functions.php';

$db = require_once 'config/db.php';
$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
if (!$link) {
    $error = mysqli_connect_error();
    $content = renderTemplate('templates/error.php', ['error' => $error]);
    print($content);
    exit();
}
mysqli_set_charset($link, "utf8");
?>
