<?php
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    $required = ['email', 'password'];
    $dict = ['email' => 'E-mail', 'password' => 'Пароль'];
    $errors = [];
    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }

    $email = mysqli_real_escape_string($link, $form['email']);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($link, $sql);
    if ($res = mysqli_query($link, $sql)) {
        $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
    } else {
        $error = mysqli_error($link);
        $content = renderTemplate('templates/error.php', ['error' => $error]);
        print($content);
    }
    if (!count($errors) and $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
        $page_content = renderTemplate('templates/login.php', ['form' => $form, 'errors' => $errors, 'dict' => $dict, 'categories' => $categories]);
    } else {
        header("Location: /index.php");
        exit();
    }
} else {
    $page_content = renderTemplate('templates/login.php', ['categories' => $categories]);
}

$layout_content = renderTemplate('templates/layout.php', ['content' => $page_content, 'title' => 'Yeticave - Вход', 'categories' => $categories]);
print($layout_content);
