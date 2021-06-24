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
 * CollectionExceptTest tests
 */
class CollectionExceptTest extends TestCase
{    
    public function testExcept()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'red',
                'weight' => 1500,
            ]
        ]))->except(['key', 'meta.weight'])->all();
        
        $this->assertSame(
            [
                'title' => 'Car',
                'meta' => [
                    'color' => 'red',
                ]
            ],
            $all
        );
    }   
}