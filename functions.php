<?php
function renderTemplate($template_path, $template_data)
{
    ob_start();
    if (file_exists($template_path)) {
        require_once "$template_path";
    } else {
        return "Файл $template_path не найден";
    }
    $content = ob_get_clean();
    return $content;
}

function format_price($price)
{
    $rounded_price = ceil($price);
    if ($rounded_price > 1000) {
        $rounded_price = number_format($rounded_price, 0, ",", " ");
    }
    ;
    $fancy_price = $rounded_price . " ₽";
    return $fancy_price;
};

function time_to_expire($exp_time)
{
    date_default_timezone_set('Europe/Moscow');
    $sec_in_day = 86400;
    $sec_in_hour = 3600;
    $sec_in_min = 60;
    $curr_time = strtotime('now');
    $time_to_exp = floor(($exp_time - $curr_time) / $sec_in_day) . ":" . floor(($exp_time - $curr_time) % $sec_in_day / $sec_in_hour) . ":" . floor(($exp_time - $curr_time) % $sec_in_day % $sec_in_hour / $sec_in_min);
    return $time_to_exp;
}

// function getPhrase($number, $titles)
// {
//     $cases = [2, 0, 1, 1, 1, 2];

//     return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
// }

function human_time_diff($unixtime)
{$unixtimeAgo = time() - $unixtime;
    if ($unixtimeAgo < 60) {
        return 'меньше минуты назад';
    }
    $phrases = ['минут', 'часов', 'дней', 'месяцев', 'лет'];
    $length = [60, 60 * 60, 60 * 60 * 24, 60 * 60 * 24 * 30, 60 * 60 * 24 * 365];
    for ($i = count($length) - 1; $i >= 0; $i--) {
        if ($unixtimeAgo / $length[$i] >= 1) {
            break;
        }
    }
    $text = floor($unixtimeAgo / $length[$i]) . ' ' . $phrases[$i] . ' назад';
    return $text;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);
    if ($stmt === false) {
        $error = mysqli_error($link);
        $content = renderTemplate('templates/error.php', ['error' => $error]);
        print($content . "Запрос: " . $sql);
        exit;
    }
    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            } else if (is_string($value)) {
                $type = 's';
            } else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}

// function human_time_diff($time)
// {
//     $stf = 0;
//     $cur_time = time();
//     $diff = $cur_time - $time;

//     $seconds = ['секунда', 'секунды', 'секунд'];
//     $minutes = ['минута', 'минуты', 'минут'];
//     $hours = ['час', 'часа', 'часов'];
//     $days = ['день', 'дня', 'дней'];
//     $weeks = ['неделя', 'недели', 'недель'];
//     $months = ['месяц', 'месяца', 'месяцев'];
//     $years = ['год', 'года', 'лет'];
//     $decades = ['десятилетие', 'десятилетия', 'десятилетий'];

//     $phrase = [$seconds, $minutes, $hours, $days, $weeks, $months, $years, $decades];
//     $length = [1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600];

//     for ($i = sizeof($length) - 1; ($i >= 0) && (($no = $diff / $length[$i]) <= 1); $i--) {
//         ;
//     }
//     if ($i < 0) {
//         $i = 0;
//     }
//     $_time = $cur_time - ($diff % $length[$i]);
//     $no = floor($no);
//     $value = sprintf("%d %s ", $no, getPhrase($no, $phrase[$i]));

//     if (($stf == 1) && ($i >= 1) && (($cur_time - $_time) > 0)) {
//         $value .= time_ago($_time);
//     }

//     return $value . ' назад';
// }
