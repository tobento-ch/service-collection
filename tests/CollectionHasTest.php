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
 * CollectionHasTest tests
 */
class CollectionHasTest extends TestCase
{    
    public function testHas()
    {
        $has = (new Collection([
            'key' => 'car',
            'title' => 'Car'
        ]))->has('title', 'key');
        
        $this->assertTrue($has);
    }
    
    public function testHasWithArray()
    {
        $has = (new Collection([
            'key' => 'car',
            'title' => 'Car'
        ]))->has(['title', 'key']);
        
        $this->assertTrue($has);
    }    
    
    public function testHasReturnsFalseIfOneDoesNotExist()
    {
        $has = (new Collection([
            'key' => 'car',
            'title' => 'Car'
        ]))->has('title', 'foo');
        
        $this->assertFalse($has);
    }
    
    public function testHasWithDotNotation()
    {
        $has = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'red'
            ]
        ]))->has('title', 'meta.color');
        
        $this->assertTrue($has);
    }
    
    public function testHasWithDotNotationNumberIndex()
    {
        $has = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                0 => 'red',
                1 => 'blue'
            ]
        ]))->has('title', 'meta.1');
        
        $this->assertTrue($has);
    }
    
    public function testHasWithNullValue()
    {
        $has = (new Collection([
            'key' => null,
            'meta' => [
                'color' => null
            ],
            'options' => [
                'colors' => [
                    'red' => null,
                ]
            ]            
        ]))->has('key', 'meta.color', 'options.colors.red');
        
        $this->assertTrue($has);
    }
}