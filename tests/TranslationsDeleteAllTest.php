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
 * TranslationsDeleteAllTest tests
 */
class TranslationsDeleteAllTest extends TestCase
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
    
    public function testDeleteAllWithDefaultLocale()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            [
                'de' => [
                    'title' => 'title de',
                    'desc' => 'desc de',
                ],
                'fr' => [
                    'title' => 'title fr',
                ],
            ],
            $t->deleteAll()->all([])
        );
    }

    public function testDeleteAllWithSpecificLocale()
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
            ],
            $t->deleteAll('fr')->all([])
        );
    }

    public function testDeleteAllWithSpecificLocaleUsesLocalMapping()
    {        
        $t = new Translations($this->translations, 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $this->assertSame(
            [
                'en' => [
                    'title' => 'title en',
                    'desc' => 'desc en',
                ],
                'fr' => [
                    'title' => 'title fr',
                ],
            ],
            $t->deleteAll('de-CH')->all([])
        );
    }

    public function testDeleteAllWithDefaultLocales()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            [],
            $t->deleteAll([])->all([])
        );
    }
    
    public function testDeleteAllWithSpecificLocales()
    {        
        $t = new Translations($this->translations, 'en');
        
        $this->assertSame(
            [
                'fr' => [
                    'title' => 'title fr',
                ],
            ],
            $t->deleteAll(['de', 'en'])->all([])
        );
    }   
}