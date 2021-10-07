<?php

class Foo
{
    public function helloGateway()
    {
        self::hello();
    }

    public static function hello()
    {
        echo __CLASS__, ' hello!', PHP_EOL;
    }
}

class Bar extends Foo
{
    public static function hello()
    {
        echo __CLASS__, ' hello!', PHP_EOL;
    }
}

$bar = new Bar();
$bar->helloGateway(); // Foo hello!


// Barクラスで "Bar hello!" と出力するためには、以下のように書き換え
class Foo
{
    public function helloGateway()
    {
        static::hello();  // ここを "self" から "static" に書き換える
    }

    public static function hello()
    {
        echo __CLASS__, ' hello!', PHP_EOL;
    }
}

class Bar extends Foo
{
    public static function hello()
    {
        echo __CLASS__, ' hello!', PHP_EOL;
    }
}

$bar = new Bar();
$bar->helloGateway(); // Bar hello!

// このように、遅延静的束縛は、親クラスから継承された子クラスのメソッド、定数、プロパティの解決を行うことを可能にします。
// これにより、抽象化が容易になり、設計の幅が広がります。