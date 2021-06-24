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
 * CollectionSetTest tests
 */
class CollectionSetTest extends TestCase
{    
    public function testSet()
    {
        $all = (new Collection([
            'title' => 'Car'
        ]))->set('color', 'red')->all();
        
        $this->assertSame(
            [
                'title' => 'Car',
                'color' => 'red',
            ],
            $all
        );
    }
    
    public function testSetWithDotNotation()
    {
        $all = (new Collection([
            'title' => 'Car'
        ]))->set('meta.color', 'red')->all();
        
        $this->assertSame(
            [
                'title' => 'Car',
                'meta' => [
                   'color' => 'red', 
                ],
            ],
            $all
        );
    } 
    
    public function testSetWithDotNotationOverwritesExisting()
    {
        $all = (new Collection([
            'title' => 'Car',
            'meta' => 'foo',
        ]))->set('meta.color', 'red')->all();
        
        $this->assertSame(
            [
                'title' => 'Car',
                'meta' => [
                   'color' => 'red', 
                ],
            ],
            $all
        );
    }     
}