<?php
namespace Application\App;


class Config {
    public static function get($path) {
        $setting = require __DIR__."/../setting.php";

        foreach (explode(".", $path) as $key) {
            if (!isset($setting[$key])) {
                return null;
            }
            $setting = $setting[$key];
        }

        return $setting;
    }
}