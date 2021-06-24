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
 * CollectionMergeRecursiveTest tests
 */
class CollectionMergeRecursiveTest extends TestCase
{    
    public function testMerge()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car'
        ]))->mergeRecursive(['foo' => 'bar', 'title' => 'Car VW'])->all();
        
        $this->assertSame(
            [
                'key' => 'car',
                'title' => [
                    'Car',
                    'Car VW',
                ],
                'foo' => 'bar',
            ],
            $all
        );
    }   
}