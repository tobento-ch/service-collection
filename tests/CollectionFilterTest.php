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
 * CollectionFilterTest tests
 */
class CollectionFilterTest extends TestCase
{    
    public function testFilter()
    {
        $all = (new Collection([
            'key',
            'title',
        ]))->filter(fn($value, $key) => $key >= 1)->all();
        
        $this->assertSame(
            [
                1 => 'title'
            ],
            $all
        );
    }   
}