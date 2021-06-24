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
 * CollectionLastTest tests
 */
class CollectionLastTest extends TestCase
{    
    public function testLast()
    {
        $last = (new Collection([
            2,
            8,
            9
        ]))->last();
        
        $this->assertSame(9, $last);
    }

    public function testLastOnEmptyCollectionReturnsNull()
    {
        $last = (new Collection([]))->last();
        
        $this->assertSame(null, $last);
    }    
    
    public function testLastByATruthTest()
    {
        $last = (new Collection([
            2,
            8,
            9
        ]))->last(fn($value) => $value < 9);
        
        $this->assertSame(8, $last);
    }
    
    public function testLastByATruthTestFailsReturnsFallback()
    {
        $last = (new Collection([
            2,
            8,
            9
        ]))->last(fn($value) => $value > 12, 15);
        
        $this->assertSame(15, $last);
    }     
}