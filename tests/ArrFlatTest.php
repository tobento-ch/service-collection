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
 * ArrFlatTest
 */
class ArrFlatTest extends TestCase
{    
    public function testFlat()
    {
        $this->assertSame(
            [
                'foo' => 'foo value',
                'bar[bar1]' => 'bar 1',
                'bar[bar2][bar2-1]' => 'bar 2-1',
            ],
            Arr::flat([
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
    
    public function testFlatWithCallback()
    {
        $this->assertSame(
            [
                'foo' => 'Foo value',
                'bar[bar1]' => 'Bar 1',
                'bar[bar2][bar2-1]' => 'Bar 2-1',
            ],
            Arr::flat([
                'foo' => 'foo value',
                'bar' => [
                    'bar1' => 'bar 1',
                    'bar2' => [
                        'bar2-1' => 'bar 2-1'
                    ],
                ],
            ], function($value, $key) {
                return ucfirst($value);
            })
        );
    }
    
    public function testUnflat()
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
                'bar[bar1]' => 'bar 1',
                'bar[bar2][bar2-1]' => 'bar 2-1',
            ])
        );
    }
    
    public function testUnflatWithCallback()
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
                'bar[bar1]' => 'bar 1',
                'bar[bar2][bar2-1]' => 'bar 2-1',
            ], function($value, $key) {
                return ucfirst($value);
            })
        );
    }    
}