<?php
require_once 'init.php';

if (!isset($_GET['id'])) {
    $content = renderTemplate('templates/error.php', ['error' => 'Лот с этим идентификатором не найден.']);
    print($content);
    exit;
} else {
    $id = intval($_GET['id']);
    $sql = "SELECT l.title, l.image, l.description, l.expire_datetime, c.category
        FROM lots l
        JOIN categories c ON c.id = l.category_id
        WHERE l.id = " . $id;
    $sql_price = "SELECT IFNULL(MAX(b.bid), l.start_price) AS price, IFNULL(MAX(b.bid), l.start_price) + l.price_increment AS min_bid
        FROM lots l
        LEFT JOIN bids b ON l.id = b.lot_id
        WHERE l.id = " . $id;
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) == 0) {
            http_response_code(404);
            $content = renderTemplate('templates/error.php', ['error' => 'Лот с этим идентификатором не найден.']);
            print($content);
            exit;
        } else {
            $lot_info = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $result_price = mysqli_query($link, $sql_price);
            $price_info = mysqli_fetch_array($result_price, MYSQLI_ASSOC);
            $sql = "SELECT u.name, b.bid, b.datetime FROM bids b JOIN users u ON u.id = b.author_id  WHERE b.lot_id = " . $id . " ORDER BY b.datetime DESC LIMIT 10";
            $result = mysqli_query($link, $sql);
            $bids_info = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    } else {
        $error = mysqli_error($link);
        $content = renderTemplate('templates/error.php', ['error' => $error]);
        print($content);
    }
}

$page_content = renderTemplate('templates/lot.php', ['lot' => $lot_info, 'bids' => $bids_info, 'price' => $price_info, 'categories' => $categories]);
$layout_content = renderTemplate('templates/layout.php', ['content' => $page_content, 'title' => $lot_info['title'], 'auth' => $is_auth, 'username' => $user_name, 'avatar' => $user_avatar, 'categories' => $categories]);
print($layout_content);
