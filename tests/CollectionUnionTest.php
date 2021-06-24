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
 * CollectionUnionTest tests
 */
class CollectionUnionTest extends TestCase
{    
    public function testUnion()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car'  
        ]))->union(['title' => 'foo', 'foo' => 'bar'])->all();
        
        $this->assertSame(
            [
                'key' => 'car',
                'title' => 'Car',
                'foo' => 'bar',
            ],
            $all
        );
    }   
}