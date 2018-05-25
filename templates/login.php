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
$user_email = $_POST['email'] ?? '';
?>
  <form class="form container <?php if (isset($template_data['errors'])): print('form--invalid');endif;?>" action="/login.php" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
    <div class="form__item <?php if (isset($template_data['errors']['email'])): print('form__item--invalid');endif;?>"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=htmlspecialchars($user_email, ENT_QUOTES);?>">
      <span class="form__error">Введите e-mail</span>
    </div>
    <div class="form__item form__item--last <?php if (isset($template_data['errors']['password'])): print('form__item--invalid');endif;?>">
      <label for="password">Пароль*</label>
      <input id="password" type="text" name="password" placeholder="Введите пароль" >
      <span class="form__error">Введите пароль</span>
    </div>
    <button type="submit" class="button">Войти</button>
  </form>
  <?php if (isset($template_data['errors'])): ?>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <ul>
          <?php foreach ($template_data['errors'] as $err => $val): ?>
          <li><strong><?=$template_data['dict'][$err];?></strong>: <?=$val;?></li>
<?php endforeach;?>
    </ul>
    <?php endif;?>
