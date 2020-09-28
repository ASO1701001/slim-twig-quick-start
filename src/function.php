<?php
function escape($array) {
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = escape($value);
        } else {
            $array[$key] = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
        }
    }

    return $array;
}

function random(int $count) {
    $random = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
    $string = null;
    for ($i = 0; $i < $count; $i++) {
        $string .= $random[rand(0, count($random) - 1)];
    }

    return $string;
}

function csrfTokenGenerate() {
    $csrfToken = random(20);
    $_SESSION["csrf_token"] = $csrfToken;
    return $csrfToken;
}