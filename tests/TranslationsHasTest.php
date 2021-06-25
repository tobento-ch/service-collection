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
 * TranslationsHasTest tests
 */
class TranslationsHasTest extends TestCase
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
    
    public function testHasWithDefaultLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertTrue($t->has('title'));
    }
    
    public function testHasWithDotNotation()
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
        
        $this->assertTrue($t->has('meta.color'));
    }    

    public function testHasWithSpecificLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertTrue($t->has('title', 'fr'));
    }

    public function testHasWithSpecificLocaleFailsAsNotExist()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertFalse($t->has('title', 'it'));
    }

    public function testHasWithSpecificLocaleUsesLocalMapping()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $this->assertTrue($t->has('title', 'de-CH'));
    }

    public function testHasWithDefaultLocales()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertTrue($t->has('title', []));
    }
    
    public function testHasWithDefaultLocalesFailsAsNotAllHaveKey()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertFalse($t->has('desc', []));
    }
    
    public function testHasWithSpecificLocales()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertTrue($t->has('desc', ['de', 'en']));
    }

    public function testHasWithSpecificLocalesFailsAsNotAllHaveKey()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertFalse($t->has('desc', ['de', 'fr']));
    }    
}