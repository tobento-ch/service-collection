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
 * CollectionOnlyPresentTest tests
 */
class CollectionOnlyPresentTest extends TestCase
{    
    public function testOnlyPresent()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'red',
                'weight' => 1500,
            ]    
        ]))->onlyPresent(['title', 'meta.color'])->all();
        
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
    
    public function testReturnsOnlyPresentItems()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'red',
                'weight' => 1500,
            ]    
        ]))->onlyPresent(['bar', 'meta.foo', 'meta.color', 'title'])->all();
        
        $this->assertSame(
            [
                'meta' => [
                    'color' => 'red',
                ],
                'title' => 'Car',
            ],
            $all
        );
    }
}