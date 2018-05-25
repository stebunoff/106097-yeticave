<nav class="nav">
    <ul class="nav__list container">
    <?php $index = 0;
$num = count($template_data['categories']);
while ($index < $num) {
    $cat = $template_data['categories'][$index];
    print('<li class="nav__item"><a href="all-lots.html">' . htmlspecialchars($cat['category']) . '</a></li>');
    $index = $index + 1;
}?>
    </ul>
  </nav>
<?php
$user_name = $_POST['name'] ?? '';
$user_email = $_POST['email'] ?? '';
$user_message = $_POST['message'] ?? '';
?>
  <form class="form container <?=$template_data['form-class'];?>" action="/reg.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item <?php if (isset($template_data['errors']['email'])): print('form__item--invalid');endif;?>"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=htmlspecialchars($user_email, ENT_QUOTES);?>">
      <span class="form__error">Введите e-mail</span>
    </div>
    <div class="form__item <?php if (isset($template_data['errors']['password'])): print('form__item--invalid');endif;?>">
      <label for="password">Пароль*</label>
      <input id="password" type="text" name="password" placeholder="Введите пароль">
      <span class="form__error">Введите пароль</span>
    </div>
    <div class="form__item <?php if (isset($template_data['errors']['name'])): print('form__item--invalid');endif;?>">
      <label for="name">Имя*</label>
      <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=htmlspecialchars($user_name, ENT_QUOTES);?>">
      <span class="form__error">Введите имя</span>
    </div>
    <div class="form__item <?php if (isset($template_data['errors']['message'])): print('form__item--invalid');endif;?>">
      <label for="message">Контактные данные*</label>
      <textarea id="message" name="message" placeholder="Напишите как с вами связаться" value="<?=htmlspecialchars($user_message, ENT_QUOTES);?>"></textarea>
      <span class="form__error">Напишите как с вами связаться</span>
    </div>
    <div class="form__item form__item--file form__item--last">
      <label>Аватар</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" name="avatar" type="file" id="photo2" value="">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
    </div>
    <?php if (isset($template_data['errors'])): ?>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <ul>
          <?php foreach ($template_data['errors'] as $err => $val): ?>
          <li><strong><?=$template_data['dict'][$err];?></strong>: <?=$val;?></li>
<?php endforeach;?>
    </ul>
    <?php endif;?>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
  </form>
