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
 * CollectionToJsonTest tests
 */
class CollectionToJsonTest extends TestCase
{    
    public function testToJson()
    {
        $json = (new Collection([
            'key' => 'car',
            'title' => 'Car'  
        ]))->toJson();
        
        $this->assertSame(
            '{"key":"car","title":"Car"}',
            $json
        );
    }   
}