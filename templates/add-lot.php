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
$lot_name = $_POST['lot-name'] ?? '';
$lot_message = $_POST['message'] ?? '';
$lot_rate = $_POST['lot-rate'] ?? '';
$lot_step = $_POST['lot-step'] ?? '';
$lot_date = $_POST['lot-date'] ?? '';
?>
  <form class="form form--add-lot container <?=$template_data['form-class'];?>" action="/add.php" method="post" enctype = "multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
      <div class="form__item <?php if (isset($template_data['errors']['lot-name'])): print('form__item--invalid');endif;?>"> <!-- form__item--invalid -->
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=htmlspecialchars($lot_name, ENT_QUOTES);?>">
        <span class="form__error">Введите наименование лота</span>
      </div>
      <div class="form__item">
        <label for="category">Категория</label>
        <select id="category" name="category">
        <?php $index = 0;
$num = count($template_data['categories']);
while ($index < $num) {
    $cat = $template_data['categories'][$index];
    print('<option value="' . $cat['id'] . '">' . htmlspecialchars($cat['category']) . '</option>');
    $index = $index + 1;
}?>
          <option>Выберите категорию</option>
          <option>Доски и лыжи</option>
          <option>Крепления</option>
          <option>Ботинки</option>
          <option>Одежда</option>
          <option>Инструменты</option>
          <option>Разное</option>
        </select>
        <span class="form__error">Выберите категорию</span>
      </div>
    </div>
    <div class="form__item form__item--wide">
      <label for="message">Описание</label>
      <textarea id="message" name="message" placeholder="Напишите описание лота" value="<?=htmlspecialchars($lot_message, ENT_QUOTES);?>"></textarea>
      <span class="form__error">Напишите описание лота</span>
    </div>
    <div class="form__item form__item--file"> <!-- form__item--uploaded -->
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" id="photo2" name="lot-img" value="">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
    </div>
    <div class="form__container-three">
      <div class="form__item form__item--small <?php if (isset($template_data['errors']['lot-rate'])): print('form__item--invalid');endif;?>">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?=htmlspecialchars($lot_rate, ENT_QUOTES);?>">
        <span class="form__error">Введите начальную цену</span>
      </div>
      <div class="form__item form__item--small <?php if (isset($template_data['errors']['lot-step'])): print('form__item--invalid');endif;?>">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?=htmlspecialchars($lot_step, ENT_QUOTES);?>">
        <span class="form__error">Введите шаг ставки</span>
      </div>
      <div class="form__item <?php if (isset($template_data['errors']['lot-name'])): print('form__item--invalid');endif;?>">
        <label for="lot-date">Дата окончания торгов</label>
        <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?=htmlspecialchars($lot_date, ENT_QUOTES);?>">
        <span class="form__error">Введите дату завершения торгов</span>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <ul>
          <?php if (isset($template_data['errors'])): ?>
          <?php foreach ($template_data['errors'] as $err => $val): ?>
          <li><strong><?=$template_data['dict'][$err];?></strong>: <?=$val;?></li>
<?php endforeach;?>
          <?php endif;?>
    </ul>
    <button type="submit" class="button">Добавить лот</button>
  </form>
