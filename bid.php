<?php
require_once 'init.php';

$bid = $_POST;
$errors = [];
if (isset($_COOKIE['yeticave'])) {
    if (empty($bid['cost'])) {
        if (ctype_digit($bid['cost']) && $bid['cost'] >= $bid['actual--price']) {
            $sql = 'INSERT INTO bids (datetime, bid, author_id, lot_id) VALUES (NOW(), ?, ?, ?)';

            $stmt = db_get_prepare_stmt($link, $sql, [$bid['cost'], $_SESSION['user']['id'], $_GET['id']]);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                header("Location: /lot.php?id=" . $_GET['id']);
                $sql = "SELECT l.title, l.image, l.description, l.expire_datetime, c.category
                FROM lots l
                JOIN categories c ON c.id = l.category_id
                WHERE l.id = " . $_GET['id'];
                $result = mysqli_query($link, $sql);
                $lot_info = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $sql_price = "SELECT IFNULL(MAX(b.bid), l.start_price) AS price, IFNULL(MAX(b.bid), l.start_price) + l.price_increment AS min_bid
                            FROM lots l
                            LEFT JOIN bids b ON l.id = b.lot_id
                            WHERE l.id = " . $_GET['id'];
                $result_price = mysqli_query($link, $sql_price);
                $price_info = mysqli_fetch_array($result_price, MYSQLI_ASSOC);
                $sql = "SELECT u.name, b.bid, b.datetime FROM bids b JOIN users u ON u.id = b.author_id  WHERE b.lot_id = " . $_GET['id'] . " ORDER BY b.datetime DESC LIMIT 10";
                $result = mysqli_query($link, $sql);
                $bids_info = mysqli_fetch_all($result, MYSQLI_ASSOC);
            } else {
                $content = renderTemplate('templates/error.php', ['error' => mysqli_error($link)]);
                print($content);
            }
        } else {
            $errors = 'Укажите ставку больше ' . $bid['actual-price'];
        }
    } else {
        $errors = 'Введите ставку.';
    }
} else {
    $errors = 'Пожалуйста, авторизируйтесь.';
}

$page_content = renderTemplate('templates/lot.php', ['lot' => $lot_info, 'bids' => $bids_info, 'price' => $price_info, 'categories' => $categories, 'id' => $id]);
$layout_content = renderTemplate('templates/layout.php', ['content' => $page_content, 'title' => $lot_info['title'], 'categories' => $categories]);
print($layout_content);
