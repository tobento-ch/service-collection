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

/**
 * CollectionGetTest tests
 */
class CollectionGetTest extends TestCase
{    
    public function testGet()
    {
        $value = (new Collection([
            'key' => 'car',
            'title' => 'Car',
        ]))->get('title');
        
        $this->assertSame('Car', $value);
    }
    
    public function testGetReturnsNullIfNotExist()
    {
        $value = (new Collection([
            'key' => 'car',
            'title' => 'Car',
        ]))->get('foo');
        
        $this->assertSame(null, $value);
    }    

    public function testGetReturnsValueAsExistAndFallbackIsSameType()
    {
        $value = (new Collection([
            'key' => 'car',
            'title' => 'Car',
        ]))->get('title', 'Foo');
        
        $this->assertSame('Car', $value);
    }
    
    public function testGetReturnsFallbackTypeIfNotSame()
    {
        $value = (new Collection([
            'key' => 'car',
            'title' => 'Car',
        ]))->get('title', []);
        
        $this->assertSame([], $value);
    }
    
    public function testGetReturnsIntFallbackTypeIfNotSame()
    {
        $value = (new Collection([
            'key' => 'car',
            'title' => 'Car',
        ]))->get('title', 5);
        
        $this->assertSame(5, $value);
    }
    
    public function testGetUsingDotNotation()
    {
        $value = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'red'
            ]
        ]))->get('meta.color');
        
        $this->assertSame('red', $value);
    }    
}