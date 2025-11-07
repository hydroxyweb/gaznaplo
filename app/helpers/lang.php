<?php

use Leaf\Http\Request;

function __($key) {
    static $translations = null;
    static $lang = null;
    
    if ($translations === null) {
        $request = new Request;
        $lang = $request->get('lang') ?? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en', 0, 2);
        $lang = in_array($lang, ['hu', 'en']) ? $lang : 'en';

        $translations = include __DIR__ . "/../lang/{$lang}.php";
    }

    return $translations[$key] ?? $key;
}