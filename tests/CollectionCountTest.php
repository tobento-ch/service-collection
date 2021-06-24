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
 * CollectionCountTest tests
 */
class CollectionCountTest extends TestCase
{    
    public function testCount()
    {
        $count = (new Collection([
            'key' => 'car',
            'title' => 'Car'  
        ]))->count();
        
        $this->assertSame(2, $count);
    }   
}