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
 * CollectionFirstTest tests
 */
class CollectionFirstTest extends TestCase
{    
    public function testFirst()
    {
        $first = (new Collection([
            2,
            8,
            9
        ]))->first();
        
        $this->assertSame(2, $first);
    }
    
    public function testFirstOnEmptyCollectionReturnsNull()
    {
        $first = (new Collection([]))->first();
        
        $this->assertSame(null, $first);
    }    
    
    public function testFirstByATruthTest()
    {
        $first = (new Collection([
            2,
            8,
            9
        ]))->first(fn($value) => $value > 2);
        
        $this->assertSame(8, $first);
    }
    
    public function testFirstByATruthTestFailsReturnsFallback()
    {
        $first = (new Collection([
            2,
            8,
            9
        ]))->first(fn($value) => $value > 12, 15);
        
        $this->assertSame(15, $first);
    }    
}