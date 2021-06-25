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
 * CollectionAddTest tests
 */
class CollectionAddTest extends TestCase
{    
    public function testAdd()
    {
        $this->assertSame(
            ['foo' => 'bar'],
            (new Collection())->add('foo', 'bar')->all()
        );
    }
    
    public function testAddShouldNotAddIfExist()
    {
        $this->assertSame(
            ['foo' => 'bar'],
            (new Collection(['foo' => 'bar']))->add('foo', 'new')->all()
        );
    }
    
    public function testAddShouldAddIfNull()
    {
        $this->assertSame(
            ['foo' => 'new'],
            (new Collection(['foo' => null]))->add('foo', 'new')->all()
        );
    }
    
    public function testAddShouldNotAddIfEmpty()
    {
        $this->assertSame(
            ['foo' => ''],
            (new Collection(['foo' => '']))->add('foo', 'new')->all()
        );
    }    
    
    public function testAddWithDotNotationShouldNotAddIfExist()
    {
        $this->assertSame(
            ['foo' => ['bar' => 'something']],
            (new Collection(['foo' => ['bar' => 'something']]))->add('foo.bar', 'new')->all()
        );
    }    
    
    public function testAddWithNumbers()
    {
        $this->assertSame(
            [4, 5, 9, 4 => null],
            (new Collection([4, 5, 9]))->add(4, null)->all()
        );
    }
    
    public function testAddWithNumbersShouldNotAddIfExist()
    {
        $this->assertSame(
            [4, 5, 9],
            (new Collection([4, 5, 9]))->add(2, null)->all()
        );
    }    
}