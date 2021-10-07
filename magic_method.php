<?php

class Employee
{
    public function __toString()
    {
        return 'This class is:' . __CLASS__;
    }
}

$yamada = new Employee();
echo $yamada;             // This class is: Employee


class SomeClass
{
    private $values = array();  // privateな値を保存するコンテナ

    // privateなコンテナへのアクセサ（getter）
    public function __get($name)
    {
        echo "get: $name", PHP_EOL;
        if (!isset($this->values[$name])) {
            throw new OutOfBoundsException($name . " not found.");
        }

        return $this->value[$name];
    }


    // privateなコンテナへのアクセサ（setter）
    public function __set($name, $value)
    {
        echo "set: $name setted to $value", PHP_EOL;
        $this->values[$name] = $value;
    }

    public function __isset($name)
    {
        echo "isset: $name", PHP_EOL;
        unset($this->values[$name]);
    }

    public function __call($name, $args)
    {
        echo "call: $name", PHP_EOL;

        // アンダースコアをつけ、メソッド名とする
        $method_name = '_' . $name;
        if (!is_callable(array($this, $method_name))) {
            throw new BadMethodCallException($name . " method not found.");
        }

        return call_user_func_array(array($this, $method_name), $args);
    }

    public static function __callStatic($name, $args)
    {
        echo "callStatic: $name", PHP_EOL;

        $method_name = '_' . $name;
        if (!is_callable(array('self', $method_name))) {
            throw new BadMethodCallException($name . " method not found.");
        }
        return call_user_func_array(array('self', $method_name), $args);
    }

    private function _bar($value)
    {
        echo "bar called with arg '$value'", PHP_EOL;
    }

    private static function _staticBar($value)
    {
        echo "staticBar called with arg '$value'", PHP_EOL;
    }
}

$obj = new SomeClass();
$obj->foo = 10;   // set: foo setted to 10


var_dump($obj->foo);
// get: foo
// int(10)


var_dump(isset($obj->foo));
// isset: foo
// bool(true)

var_dump(empty($obj->foo));
// isset: foo
// get: foo
// bool(false)
// empty()は、まずその変数がセットされているか調べ、セットされている場合はその中身が空でないかどうかをチェックする仕組みなので、
// __isset()に続けて__get()も呼び出されていることがわかります。

unset($obj->foo);
var_dump(isset($obj->foo));
// unset: foo
// isset: foo
// bool(false)

$obj->bar('baz');
SomeClass::staticBar('baz');
// call: bar
// bar called with arg 'baz'
// callStaic: staticBar
// staticBar called with arg 'baz'