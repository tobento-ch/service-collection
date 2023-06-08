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
use Tobento\Service\Collection\Arr;

/**
 * ArrDotTest
 */
class ArrDotTest extends TestCase
{    
    public function testDot()
    {
        $this->assertSame(
            [
                'foo' => 'foo value',
                'bar.bar1' => 'bar 1',
                'bar.bar2.bar2-1' => 'bar 2-1',
            ],
            Arr::dot([
                'foo' => 'foo value',
                'bar' => [
                    'bar1' => 'bar 1',
                    'bar2' => [
                        'bar2-1' => 'bar 2-1'
                    ],
                ],
            ])
        );
    }
    
    public function testUndot()
    {
        $this->assertSame(
            [
                'foo' => 'foo value',
                'bar' => [
                    'bar1' => 'bar 1',
                    'bar2' => [
                        'bar2-1' => 'bar 2-1'
                    ],
                ],
            ],
            Arr::unflat([
                'foo' => 'foo value',
                'bar.bar1' => 'bar 1',
                'bar.bar2.bar2-1' => 'bar 2-1',
            ])
        );
    }
    
    public function testUndotWithCallback()
    {
        $this->assertSame(
            [
                'foo' => 'Foo value',
                'bar' => [
                    'bar1' => 'Bar 1',
                    'bar2' => [
                        'bar2-1' => 'Bar 2-1'
                    ],
                ],
            ],
            Arr::unflat([
                'foo' => 'foo value',
                'bar.bar1' => 'bar 1',
                'bar.bar2.bar2-1' => 'bar 2-1',
            ], function($value, $key) {
                return ucfirst($value);
            })
        );
    }    
}