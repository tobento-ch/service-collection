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
 * TranslationsGetTest tests
 */
class TranslationsGetTest extends TestCase
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
                'desc' => 'desc fr',
            ],
        ];
    }
    
    public function testGetWithDefaultLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            $this->translations['en']['title'],
            $t->get('title')
        );
    }
    
    public function testGetWithDefaultLocaleDotNotation()
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
            'blue',
            $t->get('meta.color')
        );
    }    
    
    public function testGetWithDefaultLocaleReturnsDefaultValueIfNotExist()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            'default value',
            $t->get('foo', 'default value')
        );
    }

    public function testGetWithLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            $this->translations['de']['title'],
            $t->get('title', null, 'de')
        );
    }

    public function testGetWithLocaleReturnsDefaultValueIfNotExist()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            'default value',
            $t->get('title', 'default value', 'it')
        );
    }

    public function testGetWithLocaleUsesLocaleMapping()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $this->assertSame(
            $this->translations['de']['title'],
            $t->get('title', null, 'de-CH')
        );
    }
    
    public function testGetWithLocaleUsesLocaleFallback()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleFallbacks(['it' => 'de']);
        
        $this->assertSame(
            $this->translations['de']['title'],
            $t->get('title', null, 'it')
        );
    }
    
    public function testGetWithLocaleNotUsesLocaleFallbackAsDefaultValueIsset()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleFallbacks(['it' => 'de']);
        //$t->setLocaleMapping(['de-CH' => 'de']);
        
        $this->assertSame(
            'title it',
            $t->get('title', 'title it', 'it')
        );
    }    
    
    public function testGetWithLocaleUsesLocaleMappingAndUsesLocaleFallback()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleFallbacks(['it' => 'de']);
        $t->setLocaleMapping(['it-IT' => 'it']);
        
        $this->assertSame(
            $this->translations['de']['title'],
            $t->get('title', null, 'it-IT')
        );
    }

    public function testGetWithDefaultLocales()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            [
                'de' => 'title de',
                'en' => 'title en',
                'fr' => 'title fr',
            ],
            $t->get('title', null, [])
        );
    }
    
    public function testGetWithDefaultLocalesEmptyReturnsDefaultLocale()
    {        
        $t = new Translations([], 'en');
        
        $this->assertSame(
            [
                'en' => 'default value',
            ],
            $t->get('title', 'default value', [])
        );
    }
    
    public function testGetWithSpecificLocales()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            [
                'de' => 'title de',
                'fr' => 'title fr',
            ],
            $t->get('title', null, ['de', 'fr'])
        );
    }
    
    public function testGetWithSpecificLocalesUsesLocaleMapping()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $this->assertSame(
            [
                'de-CH' => 'title de',
                'fr' => 'title fr',
            ],
            $t->get('title', null, ['de-CH', 'fr'])
        );
    }    
    
    public function testGetWithSpecificLocalesIfLocaleDoesNotExistFallsbackToDefaultLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            [
                'de' => 'title de',
                'fr' => 'title fr',
                'it' => 'title en',
            ],
            $t->get('title', null, ['de', 'fr', 'it'])
        );
    }

    public function testGetWithSpecificLocalesIfLocaleDoesNotExistFallsbackToFallbackLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleFallbacks(['it' => 'de']);
        
        $this->assertSame(
            [
                'de' => 'title de',
                'fr' => 'title fr',
                'it' => 'title de',
            ],
            $t->get('title', null, ['de', 'fr', 'it'])
        );
    } 
    
    public function testGetWithSpecificLocalesIfLocaleDoesNotExistFallsbackNotToDefaultLocaleAsDefaultValueIsSet()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            [
                'de' => 'title de',
                'fr' => 'title fr',
                'it' => 'default value',
            ],
            $t->get('title', 'default value', ['de', 'fr', 'it'])
        );
    }

    public function testGetWithSpecificLocalesIfLocaleDoesNotExistFallsbackNotToDefaultLocaleAsDefaultValueIsSetEvenIfHasLocaleFallback()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleFallbacks(['it' => 'de']);
        
        $this->assertSame(
            [
                'de' => 'title de',
                'fr' => 'title fr',
                'it' => 'default value',
            ],
            $t->get('title', 'default value', ['de', 'fr', 'it'])
        );
    }     
}