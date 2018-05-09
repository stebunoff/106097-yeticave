<?php
function renderTemplate ($template_path, $template_data) {
    ob_start();
    if (file_exists($template_path)) {
    require_once "$template_path";
    } else {
        return "";
    }
    $content = ob_get_clean();
    return $content;
}

function format_price ($price) {
    $rounded_price = ceil($price);
    if ($rounded_price > 1000) {
        $rounded_price = number_format ($rounded_price, 0, ",", " ");
    };
    $fancy_price = $rounded_price . " ₽";
    return $fancy_price;
};

function time_to_expire () {
    date_default_timezone_set('Europe/Moscow');
    $sec_in_hour = 3600;
    $sec_in_min = 60;
    $exp_time = strtotime('tomorrow');
    $curr_time = strtotime('now');
    $time_to_exp = floor(($exp_time - $curr_time)/$sec_in_hour) . ":" . floor(($exp_time - $curr_time) % $sec_in_hour / $sec_in_min);
    return $time_to_exp;
}
?>
