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
 * CollectionDeleteTest tests
 */
class CollectionDeleteTest extends TestCase
{    
    public function testDelete()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'red'
            ]    
        ]))->delete('meta.color')->delete('key')->all();
        
        $this->assertSame(
            ['title' => 'Car', 'meta' => []],
            $all
        );
    }   
}