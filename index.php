<?php
require_once 'init.php';

$sql = 'SELECT l.id, l.title, l.start_price, l.image, l.category_id, l.expire_datetime, c.category, COUNT(b.id) AS bids_number, IFNULL(MAX(b.bid), l.start_price) AS price FROM lots l JOIN categories c ON c.id = l.category_id LEFT JOIN bids b ON l.id = b.lot_id WHERE l.expire_datetime > NOW() GROUP BY l.id ORDER BY l.creation_datetime DESC';
if ($res = mysqli_query($link, $sql)) {
    $ads = mysqli_fetch_all($res, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($link);
    $content = renderTemplate('templates/error.php', ['error' => $error]);
    print($content);
}

$page_content = renderTemplate('templates/index.php', ['ads' => $ads, 'categories' => $categories]);

$layout_content = renderTemplate('templates/layout.php', ['content' => $page_content, 'title' => 'YetiCave - Главная', 'categories' => $categories]);
print($layout_content);
