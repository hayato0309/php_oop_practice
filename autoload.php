<?php

function __autoload($name)
// __autoload()はPHP7.2で非推奨
// https://www.php.net/manual/ja/function.autoload.php
{
    $filename = $name . '.php';
    if (is_readable($filename)) {
        require $filename;
    }
}

$obj = new Foo();
