<?php

if (!isset($_COOKIE['yeticave'])) {
    http_response_code(403);
    exit;
}

require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;

    $required = ['lot-name', 'lot-rate', 'lot-step', 'lot-date', 'category', 'message'];
    $dict = ['lot-name' => 'Наименование лота', 'lot-rate' => 'Начальная цена лота', 'lot-step' => 'Шаг ставки', 'lot-date' => 'Дата завершения торгов', 'file' => 'Изображение', 'category' => 'Категория', 'message' => 'Описание'];
    $errors = [];
    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
        if ($key == ('lot-rate' or 'lot-step') && ctype_digit($_POST[$key]) && ($_POST[$key] > 0)) {
            $errors[$key] = 'Поле может содержать только цифры больше нуля';
        }
        if ($key == 'category' && ctype_digit($_POST[$key])) {
            $errors[$key] = 'Выберите значение из списка';
        }
    }

    if (isset($_FILES['lot-img']['name']) and $_FILES['lot-img']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['lot-img']['tmp_name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpeg") {
            $errors['file'] = 'Загрузите картинку в формате JPEG';
        } else {
            $filename = uniqid() . '.jpg';
            $lot['path'] = $filename;
            move_uploaded_file($tmp_name, 'img/' . $filename);

            $sql = 'INSERT INTO lots (creation_datetime, title, description, image, start_price, expire_datetime, price_increment, author_id, category_id) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';

            $stmt = db_get_prepare_stmt($link, $sql, [$lot['lot-name'], $lot['message'], $lot['path'], $lot['lot-rate'], $lot['lot-date'], $lot['lot-step'], $_SESSION['user']['id'], $lot['category']]);
            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                $lot_id = mysqli_insert_id($link);
                header("Location: /lot.php?id=" . $lot_id);
            } else {
                $content = renderTemplate('templates/error.php', ['error' => mysqli_error($link)]);
                print($content);
            }
        }
    } else {
        $errors['file'] = 'Вы не загрузили файл';
    }

    if (count($errors)) {
        $page_content = renderTemplate('templates/add-lot.php', ['errors' => $errors, 'dict' => $dict, 'form-class' => 'form--invalid', 'categories' => $categories]);
    } else {
        $page_content = renderTemplate('templates/lot.php', ['lot' => $lot, 'categories' => $categories]);
    }
} else {
    $page_content = renderTemplate('templates/add-lot.php', ['form-class' => '', 'categories' => $categories]);
}

$layout_content = renderTemplate('templates/layout.php', ['content' => $page_content, 'title' => 'Yeticave - добавление лота', 'categories' => $categories]);
print($layout_content);
