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
 * CollectionAnyTest tests
 */
class CollectionAnyTest extends TestCase
{    
    public function testAny()
    {
        $exists = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'blue'
            ]
        ]))->any('foo', 'meta.color');
        
        $this->assertTrue($exists);
    }
    
    public function testAnyWithArray()
    {
        $exists = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'blue'
            ]
        ]))->any(['foo', 'meta.color']);
        
        $this->assertTrue($exists);
    }    
    
    public function testAnyReturnsFalseIfNoneExists()
    {
        $exists = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'blue'
            ]
        ]))->any('foo', 'meta.foo');
        
        $this->assertFalse($exists);
    }

    public function testAnyReturnsTrueOnMultidimensionalArray()
    {
        $exists = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'blue'
            ]
        ]))->any('foo', 'meta');
        
        $this->assertTrue($exists);
    } 
    
    public function testAnyReturnsFalseWithDotEnding()
    {
        $exists = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'blue'
            ]
        ]))->any('foo', 'meta.');
        
        $this->assertFalse($exists);
    }
    
    public function testAnyWithNumbersIndex()
    {
        $exists = (new Collection([
            2 => 'car',
            3 => 'Car',
            4 => [
                'color' => 'blue'
            ]
        ]))->any(2, 8);
        
        $this->assertTrue($exists);
    }
    
    public function testAnyWithNumbersIndexAndNotation()
    {
        $exists = (new Collection([
            2 => 'car',
            3 => 'Car',
            4 => [
                'color' => 'blue'
            ]
        ]))->any(8, '4.color');
        
        $this->assertTrue($exists);
    }

    public function testAnyWithNumbersOnly()
    {
        $exists = (new Collection([
            2, 4, 8, 9
        ]))->any(0,1);
        
        $this->assertTrue($exists);
    }
    
    public function testAnyWithNumbersOnlyReturnsFalse()
    {
        $exists = (new Collection([
            2, 4, 8, 9
        ]))->any(8);
        
        $this->assertFalse($exists);
    }    
}