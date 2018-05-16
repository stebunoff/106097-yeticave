<?php
require_once 'init.php';

if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
}
else {
    $sql = 'SELECT id, category FROM categories';
    $result = mysqli_query($link, $sql);
    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        $content = include_template('error.php', ['error' => $error]);
    }
    
    $sql = 'SELECT l.title, l.start_price, l.image, l.category_id, c.category, COUNT(b.id) AS bids_number, l.start_price + l.price_increment * COUNT(b.id) AS price FROM lots l JOIN categories c ON c.id = l.category_id JOIN bids b ON l.id = b.lot_id WHERE l.expire_datetime > NOW() GROUP BY b.lot_id ORDER BY l.creation_datetime DESC';
    if ($res = mysqli_query($link, $sql)) {
        $ads = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        $content = include_template('error.php', ['error' => $error]);
    }  
}

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

// $ads = [
//     [
//     'title' => '2014 Rossignol District Snowboard',
//     'category' => 'Доски и лыжи',
//     'price' => '10999',
//     'url' => 'img/lot-1.jpg'
//     ],
//     [
//     'title' => 'DC Ply Mens 2016/2017 Snowboard',
//     'category' => 'Доски и лыжи',
//     'price' => '159999',
//     'url' => 'img/lot-2.jpg'
//     ],
//     [
//         'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
//         'category' => 'Крепления',
//         'price' => '8000',
//         'url' => 'img/lot-3.jpg'
//     ],
//     [
//         'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
//         'category' => 'Ботинки',
//         'price' => '10999',
//         'url' => 'img/lot-4.jpg'
//     ],
//     [
//         'title' => 'Куртка для сноуборда DC Mutiny Charocal',
//         'category' => 'Одежда',
//         'price' => '7500',
//         'url' => 'img/lot-5.jpg'
//     ],
//     [
//         'title' => 'Маска Oakley Canopy',
//         'category' => 'Разное',
//         'price' => '5400',
//         'url' => 'img/lot-6.jpg'
//     ]
// ];

$page_content = renderTemplate ('templates/index.php', ['ads' => $ads]);
$layout_content = renderTemplate ('templates/layout.php', ['content' => $page_content, 'title' => 'YetiCave - Главная', 'auth' => $is_auth, 'username' => $user_name, 'avatar' => $user_avatar, 'categories' => $categories]);
print($layout_content);
?>
