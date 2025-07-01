<?php

class Utils
{
    public static function strip_lang($lang)
    {
        return str_replace('/', '', $lang);
    }

    public static function init_lang()
    {
        $lang = 'fr';
        if (isset ($_GET ['lang'])) {
            $lang = $_GET ['lang'];
        } else {
            if (isset ($_SESSION ['lang'])) {
                $lang = $_SESSION ['lang'];
            }
        }
        if ($lang == 'en') {
            $currentUri = $_SERVER['REQUEST_URI'];
            if (!preg_match('/^' . preg_quote('/mayang', '/') . '/', $currentUri)
                && !preg_match('/^' . preg_quote('/index', '/') . '/', $currentUri)) {
                $lang = 'fr';
            }
        }
        if ($lang == 'es') {
            $currentUri = $_SERVER['REQUEST_URI'];
            if (preg_match('/^' . preg_quote('/mayang', '/') . '/', $currentUri)) {
                $lang = 'en';
            }
            if (preg_match('/^' . preg_quote('/index', '/') . '/', $currentUri)) {
                $lang = 'en';
            }
        }
        $_SESSION ['lang'] = Utils::strip_lang($lang);
    }

    public static function show_lang($lang)
    {
        $currentUri = $_SERVER['REQUEST_URI'];
        if ($lang == 'en') {
            if (preg_match('/^' . preg_quote('/index', '/') . '/', $currentUri)) {
                return true;
            }
            if (preg_match('/^' . preg_quote('/mayang2026', '/') . '/', $currentUri)) {
                return true;
            }
        }
        if ($lang == 'es') {
            if (preg_match('/^' . preg_quote('/index', '/') . '/', $currentUri)) {
                return false;
            }
            if (!preg_match('/^' . preg_quote('/mayang2026', '/') . '/', $currentUri)) {
                return true;
            }
        }
        if ($lang == 'fr') {
            return true;
        }
        return false;
    }

    public static function get_lang()
    {
        return $_SESSION ['lang'];
    }

    public static function is_lang($lang)
    {
        $lang = Utils::strip_lang($lang);
        return Utils::get_lang() == $lang;
    }

    public static function get_flag_href($lang)
    {
        $lang = Utils::strip_lang($lang);
        $uri = $_SERVER ['REQUEST_URI'];
        if (preg_match('/(.*)lang=(\w+)(.*)/i', $uri)) {
            return preg_replace('/(.*)lang=(\w+)(.*)/i', '${1}lang=' . $lang . '${3}', $uri);
        } else if (preg_match('/(.*)\?(.*)/i', $uri)) {
            return $uri . '&lang=' . $lang;
        } else {
            return $uri . '?lang=' . $lang;
        }
    }

    public static function get_menu_class($uri, $uri2, $uri3)
    {
        if (strstr($_SERVER ['REQUEST_URI'], $uri) || strstr($_SERVER ['REQUEST_URI'], $uri2)|| strstr($_SERVER ['REQUEST_URI'], $uri3)) {
            return 'active';
        } else {
            return '';
        }
    }

    public static function i18n($lang, $key)
    {
        $lang = Utils::strip_lang($lang);
        return $lang [$key] [Utils::get_lang()];
    }

    public static function i19n($lang)
    {
        $lang = Utils::strip_lang($lang);
        return $lang [Utils::get_lang()];
    }

    public static function info($msg)
    {
        date_default_timezone_set('Europe/Paris');
        $date = new DateTime ();
        file_put_contents('../website.log', $date->format('Y-m-d H:i:s') . ' INFO  ' . $msg . PHP_EOL, FILE_APPEND);
    }

    public static function error($msg)
    {
        date_default_timezone_set('Europe/Paris');
        $date = new DateTime ();
        file_put_contents('../website.log', $date->format('Y-m-d H:i:s') . ' ERROR ' . $msg . PHP_EOL, FILE_APPEND);
    }
}
