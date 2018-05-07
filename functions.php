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
?>
