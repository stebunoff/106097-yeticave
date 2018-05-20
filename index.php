<?php
require_once 'init.php';

$sql = 'SELECT l.id, l.title, l.start_price, l.image, l.category_id, l.expire_datetime, c.category, COUNT(b.id) AS bids_number, l.start_price + l.price_increment * COUNT(b.id) AS price FROM lots l JOIN categories c ON c.id = l.category_id LEFT JOIN bids b ON l.id = b.lot_id WHERE l.expire_datetime > NOW() GROUP BY l.id ORDER BY l.creation_datetime DESC';
if ($res = mysqli_query($link, $sql)) {
    $ads = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($link);
    $content = renderTemplate('templates/error.php', ['error' => $error]);
    print($content);
}

$page_content = renderTemplate('templates/index.php', ['ads' => $ads, 'categories' => $categories]);
$layout_content = renderTemplate('templates/layout.php', ['content' => $page_content, 'title' => 'YetiCave - Главная', 'auth' => $is_auth, 'username' => $user_name, 'avatar' => $user_avatar, 'categories' => $categories]);
print($layout_content);
