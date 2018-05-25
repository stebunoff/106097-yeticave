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
            move_uploaded_file($tmp_name, 'img/avatars/' . $filename);
        }
    }

    $email = mysqli_real_escape_string($link, $form['email']);
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $res = mysqli_query($link, $sql);

    if (!empty($form['email']) && !(filter_var($form['email'], FILTER_VALIDATE_EMAIL))) {
        $errors['email'] = 'Укажите корректный e-mail';
    } else if (mysqli_num_rows($res) > 0) {
        $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
    }

    if (count($errors)) {
        $page_content = renderTemplate('templates/sign-up.php', ['errors' => $errors, 'dict' => $dict, 'form-class' => 'form--invalid', 'categories' => $categories]);
    } else {
        $password = password_hash($form['password'], PASSWORD_DEFAULT);

        if (!isset($form['path'])) {
            $form['path'] = '';
        }
        $sql = 'INSERT INTO users (reg_datetime, email, name, password, contacts, avatar) VALUES (NOW(), ?, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $form['name'], $password, $form['message'], $form['path']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: /login.php");
            exit();
        }
    }
} else {
    $page_content = renderTemplate('templates/sign-up.php', ['categories' => $categories, 'form-class' => '']);
}

$avatar = '';
if (isset($_SESSION['user'])) {
    $sql = 'SELECT u.image FROM users u WHERE u.name = ' . $_SESSION['user'];
    if ($res = mysqli_query($link, $sql)) {
        $avatar = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($link);
        $content = renderTemplate('templates/error.php', ['error' => $error]);
        print($content);
    }
}

$layout_content = renderTemplate('templates/layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeticave | Регистрация',
]);

print($layout_content);
