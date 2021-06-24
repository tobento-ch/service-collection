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
 * CollectionTest tests
 */
class CollectionTest extends TestCase
{    
    public function testNewCollection()
    {
        $c = new Collection(['foo' => 'bar']);
        
        $this->assertSame(['foo' => 'bar'], $c->all());
    }
    
    public function testNewCollectionWithNoItems()
    {
        $c = new Collection();
        
        $this->assertSame([], $c->all());
    }

    public function testMakeMethod()
    {
        $c = Collection::make(['foo' => 'bar']);
        
        $this->assertSame(['foo' => 'bar'], $c->all());
    }
    
    public function testMakeMethodWithNoItems()
    {
        $c = Collection::make();
        
        $this->assertSame([], $c->all());
    }    
}