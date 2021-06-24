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
 * CollectionOnlyTest tests
 */
class CollectionOnlyTest extends TestCase
{    
    public function testOnly()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'red',
                'weight' => 1500,
            ]    
        ]))->only(['title', 'meta.color'])->all();
        
        $this->assertSame(
            [
                'title' => 'Car',
                'meta' => [
                    'color' => 'red',
                ]                
            ],
            $all
        );
    }
    
    public function testOnlyIfKeysDoesNotExistReturnsWithNullValues()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'red',
                'weight' => 1500,
            ]    
        ]))->only(['bar', 'meta.foo', 'colors.foo'])->all();
        
        $this->assertSame(
            [
                'bar' => null,
                'meta' => [
                    'foo' => null,
                ],
                'colors' => [
                    'foo' => null,
                ]
            ],
            $all
        );
    }
    
    public function testOnlyIfKeysDoesNotExistReturnsWithFallbackValue()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'red',
                'weight' => 1500,
            ]    
        ]))->only(['bar', 'meta.foo', 'colors.foo'], 'default')->all();
        
        $this->assertSame(
            [
                'bar' => 'default',
                'meta' => [
                    'foo' => 'default',
                ],
                'colors' => [
                    'foo' => 'default',
                ]
            ],
            $all
        );
    }     
}