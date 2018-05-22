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
  <section class="lot-item container">
    <h2><?=htmlspecialchars($template_data['lot']['title']);?></h2>
    <div class="lot-item__content">
      <div class="lot-item__left">
        <div class="lot-item__image">
          <img src="img/<?=htmlspecialchars($template_data['lot']['image']);?>" width="730" height="548" alt="<?=htmlspecialchars($template_data['lot']['category']);?>">
        </div>
        <p class="lot-item__category">Категория: <span><?=htmlspecialchars($template_data['lot']['category']);?></span></p>
        <p class="lot-item__description"><?=htmlspecialchars($template_data['lot']['description']);?></p>
      </div>
      <div class="lot-item__right">
        <div class="lot-item__state">
          <div class="lot-item__timer timer">
          <?=time_to_expire(strtotime($template_data['lot']['expire_datetime']));?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?=htmlspecialchars(format_price($template_data['price']['price']));?></span>
            </div>
            <div class="lot-item__min-cost">
              Мин. ставка <span><?=htmlspecialchars(format_price($template_data['price']['min_bid']));?></span>
            </div>
          </div>
          <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
            <p class="lot-item__form-item">
              <label for="cost">Ваша ставка</label>
              <input id="cost" type="number" name="cost" placeholder="12 000">
            </p>
            <button type="submit" class="button">Сделать ставку</button>
          </form>
        </div>
        <div class="history">
          <h3>История ставок (<span>10</span>)</h3>
          <table class="history__list">
            <?php
$num = count($template_data['bids']);
if ($num > 0) {
    $index = 0;
    $max_bids_to_show = 9;
    while (($index < $num) or $index == $max_bids_to_show) {
        $bid = $template_data['bids'][$index];
        print('<tr class="history__item"><td class="history__name">' . htmlspecialchars($bid['name']) . '</td><td class="history__price">' . htmlspecialchars(format_price($bid['bid'])) . '<td class="history__time">' . human_time_diff(strtotime($bid['datetime'])) . '</td>');
        $index = $index + 1;
    }
} else {
    print('У данного лота пока нет ставок');
}?>
          </table>
        </div>
      </div>
    </div>
  </section>
