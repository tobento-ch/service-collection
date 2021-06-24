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
 * CollectionFlattenTest tests
 */
class CollectionFlattenTest extends TestCase
{    
    public function testFlatten()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'foo' => 'bar'
            ]
        ]))->flatten()->all();
        
        $this->assertSame(
            [
                0 => 'car',
                1 => 'Car',
                2 => 'bar',
            ],
            $all
        );
    }   
}