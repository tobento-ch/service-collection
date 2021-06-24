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
 * CollectionSetAllTest tests
 */
class CollectionSetAllTest extends TestCase
{    
    public function testSetAll()
    {
        $c = new Collection();
        $c->setAll(['foo' => 'bar']);
        $this->assertSame(['foo' => 'bar'], $c->all());
    }
    
    public function testSetAllOverwriteConstructItems()
    {
        $c = new Collection(['foo' => 'bar']);
        $c->setAll([]);
        $this->assertSame([], $c->all());
    }    
}