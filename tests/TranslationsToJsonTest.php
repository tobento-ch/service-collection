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
use Tobento\Service\Collection\Translations;

/**
 * TranslationsToJsonTest tests
 */
class TranslationsToJsonTest extends TestCase
{
    protected array $translations = [];
    
    protected function setUp(): void
    {
        $this->translations = [
            'de' => [
                'title' => 'title de',
                'desc' => 'desc de',
            ],
            'en' => [
                'title' => 'title en',
                'desc' => 'desc en',
            ],
            'fr' => [
                'title' => 'title fr',
            ],
        ];
    }
    
    public function testToJson()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            json_encode($this->translations),
            $t->toJson()
        );
    }
}