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
 * CollectionReplaceRecursiveTest tests
 */
class CollectionReplaceRecursiveTest extends TestCase
{    
    public function testReplace()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'colors' => [
                'blue', 'red'
            ]
        ]))->replaceRecursive(['colors' => [0 => 'green']])->all();
        
        $this->assertSame(
            [
                'key' => 'car',
                'title' => 'Car',
                'colors' => [
                    'green', 'red'
                ],
            ],
            $all
        );
    }   
}