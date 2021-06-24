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
 * CollectionKeysTest tests
 */
class CollectionKeysTest extends TestCase
{    
    public function testKeys()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car',
        ]))->keys()->all();
        
        $this->assertSame(
            [
                0 => 'key',
                1 => 'title',
            ],
            $all
        );
    }
    
    public function testKeysWithASearchValue()
    {
        $all = (new Collection([
            'blue', 'red', 'blue', 'green'
        ]))->keys('blue', strict: false)->all();
        
        $this->assertSame(
            [
                0 => 0,
                1 => 2,
            ],
            $all
        );
    }    
}