<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Collection\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Collection\StrictTypedData;
use Tobento\Service\Collection\TypedDataInterface;

/**
 * StrictTypedDataTest tests
 */
class StrictTypedDataTest extends TestCase
{
    public function testThatImplementsTypedDataInterface()
    {
        $this->assertInstanceOf(TypedDataInterface::class, new StrictTypedData());
    }
    
    public function testNewMethodReturnsNewInstanceWithData()
    {
        $data = new StrictTypedData(['order' => ['comment' => 'Hi']]);
        $order = $data->new($data->array('order'));
        
        $this->assertFalse($data === $order);
        $this->assertSame(['comment' => 'Hi'], $order->all());
        $this->assertSame('Hi', $order->string('comment'));
        $this->assertSame(['order' => ['comment' => 'Hi']], $data->all());
    }
    
    public function testNewMethodWithMissingOrInvalidSectionReturnsEmptyData()
    {
        $data = new StrictTypedData(['order' => 'invalid']);
        
        $this->assertSame([], $data->new($data->array('order'))->all());
        $this->assertSame([], $data->new($data->array('missing'))->all());
        $this->assertSame(1, $data->new($data->array('order'))->int('quantity', 1));
    }
    
    public function testHasMethod()
    {
        $data = new StrictTypedData(['title' => 'Car', 'empty' => null, 'meta' => ['color' => 'red']]);
        
        $this->assertTrue($data->has('title'));
        $this->assertTrue($data->has('empty'));
        $this->assertTrue($data->has('meta.color'));
        $this->assertFalse($data->has('missing'));
        $this->assertFalse($data->has('meta.missing'));
    }
    
    public function testGetMethodReturnsValueWithoutTypeCheck()
    {
        $data = new StrictTypedData(['quantity' => '3', 'meta' => ['color' => 'red']]);
        
        $this->assertSame('3', $data->get('quantity'));
        $this->assertSame('3', $data->get('quantity', 5));
        $this->assertSame('red', $data->get('meta.color'));
        $this->assertSame(null, $data->get('missing'));
        $this->assertSame('default', $data->get('missing', 'default'));
    }
    
    public function testStringMethod()
    {
        $data = new StrictTypedData([
            'title' => 'Car',
            'empty' => '',
            'int' => 3,
            'float' => 2.5,
            'bool' => true,
            'null' => null,
            'array' => ['Car'],
            'meta' => ['color' => 'red'],
        ]);
        
        $this->assertSame('Car', $data->string('title'));
        $this->assertSame('', $data->string('empty', 'default'));
        $this->assertSame('red', $data->string('meta.color'));
        $this->assertSame('', $data->string('missing'));
        $this->assertSame('default', $data->string('missing', 'default'));
        $this->assertSame('default', $data->string('int', 'default'));
        $this->assertSame('default', $data->string('float', 'default'));
        $this->assertSame('default', $data->string('bool', 'default'));
        $this->assertSame('default', $data->string('null', 'default'));
        $this->assertSame('default', $data->string('array', 'default'));
    }
    
    public function testIntMethod()
    {
        $data = new StrictTypedData([
            'quantity' => 3,
            'zero' => 0,
            'negative' => -2,
            'numeric_string' => '3',
            'float' => 3.0,
            'bool' => true,
            'null' => null,
            'order' => ['quantity' => 5],
        ]);
        
        $this->assertSame(3, $data->int('quantity'));
        $this->assertSame(0, $data->int('zero', 1));
        $this->assertSame(-2, $data->int('negative'));
        $this->assertSame(5, $data->int('order.quantity'));
        $this->assertSame(0, $data->int('missing'));
        $this->assertSame(1, $data->int('missing', 1));
        $this->assertSame(1, $data->int('numeric_string', 1));
        $this->assertSame(1, $data->int('float', 1));
        $this->assertSame(1, $data->int('bool', 1));
        $this->assertSame(1, $data->int('null', 1));
    }
    
    public function testFloatMethod()
    {
        $data = new StrictTypedData([
            'price' => 2.5,
            'zero' => 0.0,
            'int' => 3,
            'numeric_string' => '2.5',
            'null' => null,
            'product' => ['price' => 9.9],
        ]);
        
        $this->assertSame(2.5, $data->float('price'));
        $this->assertSame(0.0, $data->float('zero', 1.5));
        $this->assertSame(9.9, $data->float('product.price'));
        $this->assertSame(0.0, $data->float('missing'));
        $this->assertSame(1.5, $data->float('missing', 1.5));
        $this->assertSame(1.5, $data->float('int', 1.5));
        $this->assertSame(1.5, $data->float('numeric_string', 1.5));
        $this->assertSame(1.5, $data->float('null', 1.5));
    }
    
    public function testBoolMethod()
    {
        $data = new StrictTypedData([
            'gift' => true,
            'express' => false,
            'checkbox' => '1',
            'on' => 'on',
            'int' => 1,
            'null' => null,
            'order' => ['gift' => true],
        ]);
        
        $this->assertSame(true, $data->bool('gift'));
        $this->assertSame(false, $data->bool('express', true));
        $this->assertSame(true, $data->bool('order.gift'));
        $this->assertSame(false, $data->bool('missing'));
        $this->assertSame(true, $data->bool('missing', true));
        $this->assertSame(false, $data->bool('checkbox'));
        $this->assertSame(false, $data->bool('on'));
        $this->assertSame(false, $data->bool('int'));
        $this->assertSame(true, $data->bool('null', true));
    }
    
    public function testArrayMethod()
    {
        $data = new StrictTypedData([
            'order' => ['comment' => 'Hi', 'quantity' => '3'],
            'items' => ['a', 'b'],
            'empty' => [],
            'string' => 'Car',
            'null' => null,
        ]);
        
        $this->assertSame(['comment' => 'Hi', 'quantity' => '3'], $data->array('order'));
        $this->assertSame(['a', 'b'], $data->array('items'));
        $this->assertSame([], $data->array('empty', ['default']));
        $this->assertSame([], $data->array('missing'));
        $this->assertSame(['default'], $data->array('missing', ['default']));
        $this->assertSame(['default'], $data->array('string', ['default']));
        $this->assertSame(['default'], $data->array('null', ['default']));
    }
    
    public function testListMethod()
    {
        $data = new StrictTypedData([
            'items' => ['a', 'b'],
            'empty' => [],
            'assoc' => ['key' => 'a'],
            'gap' => [0 => 'a', 2 => 'b'],
            'unordered' => [1 => 'b', 0 => 'a'],
            'string' => 'a',
            'order' => ['ids' => [1, 2]],
        ]);
        
        $this->assertSame(['a', 'b'], $data->list('items'));
        $this->assertSame([], $data->list('empty', ['default']));
        $this->assertSame([1, 2], $data->list('order.ids'));
        $this->assertSame([], $data->list('missing'));
        $this->assertSame(['default'], $data->list('missing', ['default']));
        $this->assertSame(['default'], $data->list('assoc', ['default']));
        $this->assertSame(['default'], $data->list('gap', ['default']));
        $this->assertSame(['default'], $data->list('unordered', ['default']));
        $this->assertSame(['default'], $data->list('string', ['default']));
    }
    
    public function testAllMethod()
    {
        $this->assertSame([], (new StrictTypedData())->all());
        $this->assertSame(['title' => 'Car'], (new StrictTypedData(['title' => 'Car']))->all());
    }
    
    public function testDotNotationWithDirectKeyContainingDot()
    {
        $data = new StrictTypedData(['order.comment' => 'Direct', 'order' => ['comment' => 'Nested']]);
        
        $this->assertSame('Direct', $data->string('order.comment'));
    }
    
    public function testIntegerKeys()
    {
        $data = new StrictTypedData(['a', 'b', 'items' => [[1, 2]]]);
        
        $this->assertSame('a', $data->string(0));
        $this->assertSame('b', $data->string(1));
        $this->assertSame(2, $data->int('items.0.1'));
    }
}