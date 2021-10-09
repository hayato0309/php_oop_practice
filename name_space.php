<?php
// namespace.php

namespace Project\Module;

// 下記ファイルにクラスが定義されているものとします
require_once 'Foo/Bar/Baz.php';
require_once 'Hoge/Fuga.php';
require_once 'Module/Klass/Some.php';

use Foo\Bar as BBB;
use Hoge\Fuga;

class Piyo
{
}

$obj1 = new \Directory(); // 完全修飾なので、グローバルのDirectoryクラス

$obj2 = new BBB\Baz(); // エイリアスに基づいてコンパイル時にFoo\Bar\Bazクラスとなる

$obj3 = new Fuga();  // インポートルールに基づいてコンパイル時にHoge\Fugaクラスとなる

$obj4 = new Klass\Some(); // 修飾名で該当するインポートルールが無いため、コンパイル時に現在の名前空間であるProject\Moduleが先頭につけられ、Project\Module\Klass\Someクラスと解釈される

$obj5 = new Piyo(); // 非修飾名で該当するインポートルールが無いため、コンパイル時の変換はない
// 実行時に現在の名前空間が先頭に付与されたProject\Module\Piyoクラスと解釈される

some_func(); // 実行時にProject\Module\some_func()関数を探し、なければグローバル関数を実行

BBB\SOME_CONST(); // コンパイル時にFoo\Bar\SOME_CONST定数に変換される

SOME_CONST(); // 実行しにProject\Module\SOME_CONSTがなければグローバルのSOME_CONST定数が評価される



// 動的な名前空間の利用
$class_name = 'Project\Module\SomeClass';
$obj = new $class_name(); // new Project\Module\SomeClass()
