<?php
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $required = ['email', 'password', 'name', 'message'];
    $dict = ['email' => 'E-mail', 'password' => 'Пароль', 'name' => 'Имя', 'message' => 'Контактные данные'];
    $errors = [];

    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    if (isset($_FILES['avatar']['name']) and $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['avatar']['tmp_name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpeg") {
            $form['path'] = null;
            $errors['file'] = 'Загрузите картинку в формате JPEG';
        } else {
            $filename = uniqid() . '.jpg';
            $form['path'] = $filename;
            move_uploaded_file($tmp_name, 'img/' . $filename);
        }
    }
    $email = mysqli_real_escape_string($link, $form['email']);
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $res = mysqli_query($link, $sql);

    if (!$res) {
        $content = renderTemplate('templates/error.php', ['error' => mysqli_error($link)]);
        print($content);
    } else if (mysqli_num_rows($res) > 0) {
        $errors[] = 'Пользователь с этим email уже зарегистрирован';
    } else {
        $password = password_hash($form['password'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (reg_datetime, email, name, password, message, avatar) VALUES (NOW(), ?, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $form['name'], $password, $form['message'], $form['path']]);
        $res = mysqli_stmt_execute($stmt);
    }

    if (count($errors)) {
        $page_content = renderTemplate('templates/sign-up.php', ['errors' => $errors, 'dict' => $dict, 'form-class' => 'form--invalid', 'categories' => $categories]);
    }
    if ($res && empty($errors)) {
        header("Location: /enter.php");
        exit();
    }
}

$page_content = renderTemplate('templates/sign-up.php', ['categories' => $categories, 'form-class' => '']);

$layout_content = renderTemplate('templates/layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeticave | Регистрация',
    'auth' => $is_auth,
    'username' => $user_name,
    'avatar' => $user_avatar,
]);

print($layout_content);
