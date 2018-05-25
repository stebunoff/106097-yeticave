<?php

unset($_COOKIE['yeticave']);
setcookie('yeticave', '', time() - 3600, '/');
header("Location: /index.php");
exit;
