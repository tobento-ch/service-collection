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
 * CollectionReplaceTest tests
 */
class CollectionReplaceTest extends TestCase
{    
    public function testReplace()
    {
        $all = (new Collection([
            'key' => 'car',
            'title' => 'Car'
        ]))->replace(['title' => 'Car VW', 'foo' => 'bar'])->all();
        
        $this->assertSame(
            [
                'key' => 'car',
                'title' => 'Car VW',
                'foo' => 'bar',
            ],
            $all
        );
    }   
}