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

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

$categories = [];

$sql = 'SELECT id, category, class FROM categories';
$result = mysqli_query($link, $sql);
if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($link);
    $content = renderTemplate('templates/error.php', ['error' => $error]);
    print($content);
}
