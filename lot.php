<?php
require_once 'init.php';
$content = '';

$id = intval($_GET['id']);

if (!isset($id)) {
    $content = renderTemplate('error.php', ['error' => 'Лот с этим идентификатором не найден.']);
    print($content); 
} else {
$sql = "SELECT l.title, l.image, l.description, c.category, l.start_price + l.price_increment * COUNT(b.id) AS price, l.start_price + l.price_increment * (COUNT(b.id) + 1) AS min_bid FROM lots l "
. "JOIN categories c ON c.id = l.category_id "
. "LEFT JOIN bids b ON l.id = b.lot_id "
. "WHERE l.id = " . $id; 
// . "GROUP BY l.id";

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) == 0) {
        http_response_code(404);
        print($content);
    }
    else {
        $lot_info = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $sql = "SELECT u.name, b.bid, b.datetime FROM bids b JOIN users u ON u.id = b.author_id  WHERE b.lot_id = " . $id;
        $result = mysqli_query($link, $sql);
        $bids_info = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
else {
    $error = mysqli_error($link);
    $content = renderTemplate('templates/error.php', ['error' => $error]);
    print($content);
}
}

$page_content = renderTemplate ('templates/lot.php', ['lot' => $lot_info, 'bids' => $bids_info, 'categories' => $categories]);
$layout_content = renderTemplate ('templates/layout.php', ['content' => $page_content, 'title' => $lot_info['title'], 'auth' => $is_auth, 'username' => $user_name, 'avatar' => $user_avatar, 'categories' => $categories]);
print($layout_content);
?>
