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
use Tobento\Service\Collection\Collection;
use Tobento\Service\Collection\LenientTypedData;
use Tobento\Service\Collection\StrictTypedData;

/**
 * CollectionTypedDataTest tests
 */
class CollectionTypedDataTest extends TestCase
{
    public function testStrictTypedMethod()
    {
        $collection = new Collection([
            'order' => ['comment' => 'Hi', 'quantity' => '3'],
            'gift' => true,
        ]);
        
        $typed = $collection->strictTyped();
        
        $this->assertInstanceOf(StrictTypedData::class, $typed);
        $this->assertSame($collection->all(), $typed->all());
        $this->assertSame('Hi', $typed->string('order.comment'));
        $this->assertSame(1, $typed->int('order.quantity', 1));
        $this->assertSame(true, $typed->bool('gift'));
        $this->assertSame('Hi', $typed->new($typed->array('order'))->string('comment'));
    }
    
    public function testStrictTypedMethodIsSnapshot()
    {
        $collection = new Collection(['title' => 'Car']);
        $typed = $collection->strictTyped();
        $collection->set('title', 'Bike');
        
        $this->assertSame('Car', $typed->string('title'));
        $this->assertSame('Bike', $collection->strictTyped()->string('title'));
    }
    
    public function testLenientTypedMethod()
    {
        $collection = new Collection([
            'query' => ['page' => '2', 'amount' => '2.5'],
            'newsletter' => 'on',
            'quantity' => 'abc',
        ]);
        
        $typed = $collection->lenientTyped();
        
        $this->assertInstanceOf(LenientTypedData::class, $typed);
        $this->assertSame($collection->all(), $typed->all());
        $this->assertSame(2, $typed->int('query.page', 1));
        $this->assertSame(2.5, $typed->float('query.amount'));
        $this->assertSame(true, $typed->bool('newsletter'));
        $this->assertSame(1, $typed->int('quantity', 1));
        $this->assertSame(2, $typed->new($typed->array('query'))->int('page'));
    }
    
    public function testLenientTypedMethodIsSnapshot()
    {
        $collection = new Collection(['page' => '2']);
        $typed = $collection->lenientTyped();
        $collection->set('page', '3');
        
        $this->assertSame(2, $typed->int('page'));
        $this->assertSame(3, $collection->lenientTyped()->int('page'));
    }
    
    public function testGetMethodIsNotAffected()
    {
        $collection = new Collection(['quantity' => 3, 'price' => 2.5]);
        
        $this->assertSame('3', $collection->get('quantity', ''));
        $this->assertSame(2.5, $collection->get('price', 1));
    }
}