<?php

namespace Pjson\Tests;

use Pjson\Pjson;

class PjsonTest extends \PHPUnit\Framework\TestCase
{
    public function test_it_can_set_value()
    {
        $value = 'This is a test string';
        $pjson = new Pjson;
        $pjson->test = $value;
        $pjson->set('test2', $value);

        $result = $pjson->toArray();

        $this->assertEquals($result['test'], $value);
        $this->assertEquals($result['test2'], $value);
    }

    public function test_it_can_set_object()
    {
        $pjson = new Pjson;
        $pjson->test(function ($pjson) {
            $pjson->greeting = 'Hello';
            $pjson->farewell = 'Goodbye';
        });

        $result = $pjson->toArray();

        $this->assertEquals($result['test']['greeting'], 'Hello');
        $this->assertEquals($result['test']['farewell'], 'Goodbye');
    }

    public function test_it_can_set_array()
    {
        $values = ['hamburgers', 'fries', 'soda'];

        $pjson = new Pjson;
        $pjson->test($values, function ($pjson, $item) {
            $pjson->food = $item;
        });

        $result = $pjson->toArray();

        $this->assertEquals($result['test'][0]['food'], 'hamburgers');
        $this->assertEquals($result['test'][1]['food'], 'fries');
        $this->assertEquals($result['test'][2]['food'], 'soda');
    }

    public function test_it_can_serialize_to_json()
    {
        $pjson = new Pjson;
        $pjson->test = 'Test string';
        $pjson->test_list = ['one', 'two', 'three'];
        $pjson->test_object_list(['four', 'five'], function ($pjson, $num) {
            $pjson->number = $num;
        });

        $result = $pjson->serialize();

        $decode = json_decode($result);

        $this->assertEquals($decode->test, 'Test string');
        $this->assertEquals($decode->test_list, ['one', 'two', 'three']);
        $this->assertEquals($decode->test_object_list[0]->number, 'four');  
        $this->assertEquals($decode->test_object_list[1]->number, 'five');  
    }
}
