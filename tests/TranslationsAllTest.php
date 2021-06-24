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
 * TranslationsAllTest tests
 */
class TranslationsAllTest extends TestCase
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
    
    public function testAllWithDefaultLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame($this->translations['en'], $t->all());
    }

    public function testAllWithSetLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocale('fr');
            
        $this->assertSame($this->translations['fr'], $t->all());
    }

    public function testAllWithSetLocaleInvalidReturnsEmptyArray()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocale('it');
            
        $this->assertSame([], $t->all());
    }

    public function testAllWithSetLocaleInvalidReturnsEmptyArrayEvenIfFallbackIsDefined()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleFallbacks(['it' => 'fr']);
        
        $t->setLocale('it');
            
        $this->assertSame([], $t->all());
    }
    
    public function testAllWithSetLocaleWithMappedLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $t->setLocale('de-CH');
            
        $this->assertSame($this->translations['de'], $t->all());
    }

    public function testAllWithLocale()
    {        
        $t = new Translations($this->translations, 'en');
            
        $this->assertSame($this->translations['de'], $t->all('de'));
    }

    public function testAllWithLocaleInvalidReturnsEmptyArray()
    {        
        $t = new Translations($this->translations, 'en');
            
        $this->assertSame([], $t->all('it'));
    }

    public function testAllWithLocaleAndWithMappedLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $this->assertSame($this->translations['de'], $t->all('de-CH'));
    }
    
    public function testAllWithDefaultLocales()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame($this->translations, $t->all([]));
    }
    
    public function testAllWithSpecificLocales()
    {        
        $t = new Translations($this->translations, 'en');
        
        $trans = $this->translations;
        unset($trans['en']);
        
        $this->assertSame($trans, $t->all(['de', 'fr']));
    }

    public function testAllWithSpecificLocalesIfLocaleIsInvalidReturnsEmptyArray()
    {        
        $t = new Translations($this->translations, 'en');
        
        $trans = [
            'de-CH' => [],
            'fr' => $this->translations['fr'],
        ];
        
        $this->assertSame($trans, $t->all(['de-CH', 'fr']));
    }
    
    public function testAllWithSpecificLocalesAndMappedLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $trans = $this->translations;
        unset($trans['en']);
        
        $this->assertSame($trans, $t->all(['de-CH', 'fr']));
    }     
}