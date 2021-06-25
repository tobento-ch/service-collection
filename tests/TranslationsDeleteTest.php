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
 * TranslationsDeleteTest tests
 */
class TranslationsDeleteTest extends TestCase
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
    
    public function testDeleteWithDefaultLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            [
                'de' => [
                    'title' => 'title de',
                    'desc' => 'desc de',
                ],
                'en' => [
                    'desc' => 'desc en',
                ],
                'fr' => [
                    'title' => 'title fr',
                ],
            ],
            $t->delete('title')->all([])
        );
    }
    
    public function testDeleteWithDotNotation()
    {        
        $t = new Translations([
            'de' => [
                'title' => 'title de',
            ],
            'en' => [
                'desc' => 'desc en',
                'meta' => [
                    'color' => 'blue',
                ],
            ],
        ], 'en');
        
        $this->assertSame(
            [
                'de' => [
                    'title' => 'title de',
                ],
                'en' => [
                    'desc' => 'desc en',
                    'meta' => [],
                ],
            ],
            $t->delete('meta.color')->all([])
        );
    }    

    public function testDeleteWithSpecificLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            [
                'de' => [
                    'title' => 'title de',
                    'desc' => 'desc de',
                ],
                'en' => [
                    'title' => 'title en',
                    'desc' => 'desc en',
                ],
                'fr' => [
                ],
            ],
            $t->delete('title', 'fr')->all([])
        );
    }

    public function testDeleteWithSpecificLocaleUsesLocalMapping()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $this->assertSame(
            [
                'de' => [
                    'desc' => 'desc de',
                ],
                'en' => [
                    'title' => 'title en',
                    'desc' => 'desc en',
                ],
                'fr' => [
                    'title' => 'title fr',
                ],
            ],
            $t->delete('title', 'de-CH')->all([])
        );
    }

    public function testDeleteWithDefaultLocales()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            [
                'de' => [
                    'desc' => 'desc de',
                ],
                'en' => [
                    'desc' => 'desc en',
                ],
                'fr' => [
                ],
            ],
            $t->delete('title', [])->all([])
        );
    }
    
    public function testDeleteWithSpecificLocales()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            [
                'de' => [
                    'desc' => 'desc de',
                ],
                'en' => [
                    'desc' => 'desc en',
                ],
                'fr' => [
                    'title' => 'title fr',
                ],
            ],
            $t->delete('title', ['de', 'en'])->all([])
        );
    }   
}