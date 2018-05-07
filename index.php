<?php
require_once 'functions.php';

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
$ads = [
    [
    'title' => '2014 Rossignol District Snowboard',
    'category' => 'Доски и лыжи',
    'price' => '10999',
    'url' => 'img/lot-1.jpg'
    ],
    [
    'title' => 'DC Ply Mens 2016/2017 Snowboard',
    'category' => 'Доски и лыжи',
    'price' => '159999',
    'url' => 'img/lot-2.jpg'
    ],
    [
        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => '8000',
        'url' => 'img/lot-3.jpg'
    ],
    [
        'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => '10999',
        'url' => 'img/lot-4.jpg'
    ],
    [
        'title' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => '7500',
        'url' => 'img/lot-5.jpg'
    ],
    [
        'title' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => '5400',
        'url' => 'img/lot-6.jpg'
    ]
];

function format_price ($price) {
    $rounded_price = ceil($price);
    if ($rounded_price > 1000) {
        $rounded_price = number_format ($rounded_price, 0, ",", " ");
    };
    $fancy_price = $rounded_price . " ₽";
    return $fancy_price;
};

function time_to_expire () {
    date_default_timezone_set('Europe/Moscow');
    $exp_time = strtotime('tomorrow');
    $curr_time = strtotime('now');
    $time_to_exp = $exp_time - $curr_time;
    return $time_to_exp;
}

$sec_in_hour = 3600;
$sec_in_min = 60;

$page_content = renderTemplate ('templates/index.php', ['ads' => $ads, 'sec_in_hour' => $sec_in_hour, 'sec_in_min' => $sec_in_min]);
$layout_content = renderTemplate ('templates/layout.php', ['content' => $page_content, 'title' => 'YetiCave - Главная', 'auth' => $is_auth, 'username' => $user_name, 'avatar' => $user_avatar, 'categories' => $categories]);
print($layout_content);
?>
