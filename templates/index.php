<section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php $index = 0;
$num = count($template_data['categories']);
while ($index < $num) {
    $cat = $template_data['categories'][$index];
    print('<li class="promo__item promo__item--' . htmlspecialchars($cat['class']) . '"><a class="promo__link" href="all-lots.html">' . htmlspecialchars($cat['category']) . '</a></li>');
    $index = $index + 1;
}?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
        <?php $index = 0;
$num = count($template_data['ads']);
while ($index < $num) {
    $lots = $template_data['ads'][$index];
    print('<li class="lots__item lot"><div class="lot__image"><img src="/img/' . htmlspecialchars($lots['image']) . '" width="350" height="260" alt="Сноуборд">
            </div>
            <div class="lot__info">
                <span class="lot__category">' . htmlspecialchars($lots['category']) . '</span>
                <h3 class="lot__title"><a class="text-link" href="lot.php?id=' . $lots['id'] . '">' . htmlspecialchars($lots['title']) . '</a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <span class="lot__amount">Стартовая цена</span>
                        <span class="lot__cost">' . htmlspecialchars(format_price($lots['price'])) . '</span>
                    </div>
                    <div class="lot__timer timer">' . time_to_expire(strtotime($lots['expire_datetime'])) . '</div>
                </div>
            </div>
        </li>');
    $index = $index + 1;
}
?>
        </ul>
    </section>
