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
use Tobento\Service\Collection\LenientTypedData;
use Tobento\Service\Collection\TypedDataInterface;

/**
 * LenientTypedDataTest tests
 */
class LenientTypedDataTest extends TestCase
{
    public function testThatImplementsTypedDataInterface()
    {
        $this->assertInstanceOf(TypedDataInterface::class, new LenientTypedData());
    }
    
    public function testNewMethodReturnsNewInstanceWithData()
    {
        $data = new LenientTypedData(['order' => ['quantity' => '3']]);
        $order = $data->new($data->array('order'));
        
        $this->assertInstanceOf(LenientTypedData::class, $order);
        $this->assertFalse($data === $order);
        $this->assertSame(3, $order->int('quantity'));
        $this->assertSame(['order' => ['quantity' => '3']], $data->all());
    }
    
    public function testHasMethod()
    {
        $data = new LenientTypedData(['page' => '2', 'empty' => '', 'filter' => ['color' => 'red']]);
        
        $this->assertTrue($data->has('page'));
        $this->assertTrue($data->has('empty'));
        $this->assertTrue($data->has('filter.color'));
        $this->assertFalse($data->has('missing'));
    }
    
    public function testGetMethodReturnsValueWithoutTypeCheck()
    {
        $data = new LenientTypedData(['page' => '2']);
        
        $this->assertSame('2', $data->get('page'));
        $this->assertSame('2', $data->get('page', 1));
        $this->assertSame(null, $data->get('missing'));
        $this->assertSame('default', $data->get('missing', 'default'));
    }
    
    public function testStringMethod()
    {
        $data = new LenientTypedData([
            'title' => 'Car',
            'numeric' => '3',
            'int' => 3,
            'float' => 2.5,
            'bool' => true,
            'array' => ['Car'],
        ]);
        
        $this->assertSame('Car', $data->string('title'));
        $this->assertSame('3', $data->string('numeric'));
        $this->assertSame('default', $data->string('missing', 'default'));
        $this->assertSame('default', $data->string('int', 'default'));
        $this->assertSame('default', $data->string('float', 'default'));
        $this->assertSame('default', $data->string('bool', 'default'));
        $this->assertSame('default', $data->string('array', 'default'));
    }
    
    public function testIntMethod()
    {
        $data = new LenientTypedData([
            'int' => 3,
            'string' => '3',
            'zero' => '0',
            'negative' => '-3',
            'plus' => '+3',
            'leading_zero' => '03',
            'decimal' => '3.0',
            'exponent' => '1e3',
            'space_before' => ' 3',
            'space_after' => '3 ',
            'empty' => '',
            'text' => 'abc',
            'overflow' => '9223372036854775808',
            'float' => 3.0,
            'bool' => true,
            'array' => ['3'],
            'query' => ['page' => '2'],
        ]);
        
        $this->assertSame(3, $data->int('int'));
        $this->assertSame(3, $data->int('string'));
        $this->assertSame(0, $data->int('zero', 1));
        $this->assertSame(-3, $data->int('negative'));
        $this->assertSame(3, $data->int('plus'));
        $this->assertSame(2, $data->int('query.page'));
        $this->assertSame(0, $data->int('missing'));
        $this->assertSame(1, $data->int('missing', 1));
        $this->assertSame(1, $data->int('leading_zero', 1));
        $this->assertSame(1, $data->int('decimal', 1));
        $this->assertSame(1, $data->int('exponent', 1));
        $this->assertSame(1, $data->int('space_before', 1));
        $this->assertSame(1, $data->int('space_after', 1));
        $this->assertSame(1, $data->int('empty', 1));
        $this->assertSame(1, $data->int('text', 1));
        $this->assertSame(1, $data->int('overflow', 1));
        $this->assertSame(1, $data->int('float', 1));
        $this->assertSame(1, $data->int('bool', 1));
        $this->assertSame(1, $data->int('array', 1));
    }
    
    public function testFloatMethod()
    {
        $data = new LenientTypedData([
            'float' => 2.5,
            'int' => 3,
            'string' => '2.5',
            'string_int' => '3',
            'negative' => '-2.5',
            'leading_dot' => '.5',
            'zero' => '0.0',
            'exponent' => '1e3',
            'exponent_upper' => '1.5E3',
            'comma' => '2,5',
            'space_before' => ' 2.5',
            'space_after' => '2.5 ',
            'empty' => '',
            'text' => 'abc',
            'inf' => 'INF',
            'bool' => true,
            'array' => ['2.5'],
            'product' => ['price' => '9.90'],
        ]);
        
        $this->assertSame(2.5, $data->float('float'));
        $this->assertSame(3.0, $data->float('int'));
        $this->assertSame(2.5, $data->float('string'));
        $this->assertSame(3.0, $data->float('string_int'));
        $this->assertSame(-2.5, $data->float('negative'));
        $this->assertSame(0.5, $data->float('leading_dot'));
        $this->assertSame(0.0, $data->float('zero', 1.5));
        $this->assertSame(9.9, $data->float('product.price'));
        $this->assertSame(0.0, $data->float('missing'));
        $this->assertSame(1.5, $data->float('missing', 1.5));
        $this->assertSame(1.5, $data->float('exponent', 1.5));
        $this->assertSame(1.5, $data->float('exponent_upper', 1.5));
        $this->assertSame(1.5, $data->float('comma', 1.5));
        $this->assertSame(1.5, $data->float('space_before', 1.5));
        $this->assertSame(1.5, $data->float('space_after', 1.5));
        $this->assertSame(1.5, $data->float('empty', 1.5));
        $this->assertSame(1.5, $data->float('text', 1.5));
        $this->assertSame(1.5, $data->float('inf', 1.5));
        $this->assertSame(1.5, $data->float('bool', 1.5));
        $this->assertSame(1.5, $data->float('array', 1.5));
    }
    
    public function testBoolMethod()
    {
        $data = new LenientTypedData([
            'true' => true,
            'false' => false,
            'one' => '1',
            'string_true' => 'true',
            'on' => 'on',
            'yes' => 'yes',
            'upper' => 'TRUE',
            'zero' => '0',
            'string_false' => 'false',
            'off' => 'off',
            'no' => 'no',
            'empty' => '',
            'two' => '2',
            'text' => 'abc',
            'space' => ' 1',
            'int' => 1,
            'array' => ['1'],
            'form' => ['newsletter' => 'on'],
        ]);
        
        $this->assertSame(true, $data->bool('true'));
        $this->assertSame(false, $data->bool('false', true));
        $this->assertSame(true, $data->bool('one'));
        $this->assertSame(true, $data->bool('string_true'));
        $this->assertSame(true, $data->bool('on'));
        $this->assertSame(true, $data->bool('yes'));
        $this->assertSame(true, $data->bool('upper'));
        $this->assertSame(true, $data->bool('form.newsletter'));
        $this->assertSame(false, $data->bool('zero', true));
        $this->assertSame(false, $data->bool('string_false', true));
        $this->assertSame(false, $data->bool('off', true));
        $this->assertSame(false, $data->bool('no', true));
        $this->assertSame(false, $data->bool('empty', true));
        $this->assertSame(false, $data->bool('missing'));
        $this->assertSame(true, $data->bool('missing', true));
        $this->assertSame(true, $data->bool('two', true));
        $this->assertSame(true, $data->bool('text', true));
        $this->assertSame(true, $data->bool('space', true));
        $this->assertSame(true, $data->bool('int', true));
        $this->assertSame(true, $data->bool('array', true));
    }
    
    public function testArrayMethod()
    {
        $data = new LenientTypedData([
            'filter' => ['color' => 'red'],
            'string' => 'red',
        ]);
        
        $this->assertSame(['color' => 'red'], $data->array('filter'));
        $this->assertSame([], $data->array('missing'));
        $this->assertSame(['default'], $data->array('string', ['default']));
    }
    
    public function testListMethod()
    {
        $data = new LenientTypedData([
            'ids' => ['1', '2'],
            'assoc' => ['key' => '1'],
            'string' => '1,2',
        ]);
        
        $this->assertSame(['1', '2'], $data->list('ids'));
        $this->assertSame([], $data->list('missing'));
        $this->assertSame(['default'], $data->list('assoc', ['default']));
        $this->assertSame(['default'], $data->list('string', ['default']));
    }
    
    public function testAllMethod()
    {
        $this->assertSame([], (new LenientTypedData())->all());
        $this->assertSame(['page' => '2'], (new LenientTypedData(['page' => '2']))->all());
    }
}