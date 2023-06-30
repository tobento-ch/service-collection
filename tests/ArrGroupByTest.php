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
 * ArrGroupByTest
 */
class ArrGroupByTest extends TestCase
{    
    public function testGroupByWithString()
    {
        $this->assertSame(
            [
                'animals' => [
                    0 => ['name' => 'bear', 'group' => 'animals'],
                    2 => ['name' => 'ant', 'group' => 'animals'],
                ],
                'cars' => [
                    1 => ['name' => 'audi', 'group' => 'cars'],
                    3 => ['name' => 'bmw', 'group' => 'cars'],
                ],
            ],
            Arr::groupBy(
                array: [
                    ['name' => 'bear', 'group' => 'animals'],
                    ['name' => 'audi', 'group' => 'cars'],
                    ['name' => 'ant', 'group' => 'animals'],
                    ['name' => 'bmw', 'group' => 'cars'],
                ],
                groupBy: 'group',
            )
        );
    }
    
    public function testGroupByWithCallable()
    {
        $this->assertSame(
            [
                'animals' => [
                    0 => ['name' => 'bear', 'group' => 'animals'],
                    2 => ['name' => 'ant', 'group' => 'animals'],
                ],
                'cars' => [
                    1 => ['name' => 'audi', 'group' => 'cars'],
                    3 => ['name' => 'bmw', 'group' => 'cars'],
                ],
            ],
            Arr::groupBy(
                array: [
                    ['name' => 'bear', 'group' => 'animals'],
                    ['name' => 'audi', 'group' => 'cars'],
                    ['name' => 'ant', 'group' => 'animals'],
                    ['name' => 'bmw', 'group' => 'cars'],
                ],
                groupBy: fn ($item) => $item['group'],
            )
        );
    }
    
    public function testGroupByWithUnknownGroup()
    {
        $this->assertSame(
            [
                '' => [
                    0 => ['name' => 'bear', 'group' => 'animals'],
                    1 => ['name' => 'audi', 'group' => 'cars'],
                ],
            ],
            Arr::groupBy(
                array: [
                    ['name' => 'bear', 'group' => 'animals'],
                    ['name' => 'audi', 'group' => 'cars'],
                ],
                groupBy: 'unknown',
            )
        );
    }
    
    public function testWithoutPreservingKeys()
    {
        $this->assertSame(
            [
                'animals' => [
                    0 => ['name' => 'bear', 'group' => 'animals'],
                    1 => ['name' => 'ant', 'group' => 'animals'],
                ],
                'cars' => [
                    0 => ['name' => 'audi', 'group' => 'cars'],
                    1 => ['name' => 'bmw', 'group' => 'cars'],
                ],
            ],
            Arr::groupBy(
                array: [
                    ['name' => 'bear', 'group' => 'animals'],
                    ['name' => 'audi', 'group' => 'cars'],
                    ['name' => 'ant', 'group' => 'animals'],
                    ['name' => 'bmw', 'group' => 'cars'],
                ],
                groupBy: 'group',
                preserveKeys: false,
            )
        );
    }
    
    public function testWithGroupAs()
    {
        $grouped = Arr::groupBy(
            array: [
                ['name' => 'bear', 'group' => 'animals'],
                ['name' => 'audi', 'group' => 'cars'],
                ['name' => 'ant', 'group' => 'animals'],
                ['name' => 'bmw', 'group' => 'cars'],
            ],
            groupBy: 'group',
            groupAs: fn (array $group) => (object) $group,
        );
        
        $isValid = [];
        
        foreach($grouped as $group) {
            $isValid[] = is_object($group);
        }
        
        $this->assertFalse(in_array(false, $isValid, true));
    }
}