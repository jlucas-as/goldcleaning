<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

function is_mobile() {
    $devices = "/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i";
    return preg_match($devices, $_SERVER["HTTP_USER_AGENT"]);
}

function email_link() {
    return "mailto:". env('EMAIL_TEXT');
}

function slugify($string) {
    return Str::slug($string, '-');
}

function asset($string) {
    return url('public/'. $string);
}

function search_array($haystack, $needle, $index = NULL) {
    if (is_null($haystack)) return -1;

    $arrayIterator = new \RecursiveArrayIterator( $haystack );
    $iterator      = new \RecursiveIteratorIterator( $arrayIterator );

    while ($iterator->valid()) {
        if (((isset($index) and ($iterator->key() == $index)) or (!isset($index))) and ($iterator->current() == $needle)) {
            return $arrayIterator->key();
        }

        $iterator->next();
    }

    return -1;
}