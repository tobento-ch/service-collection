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
 * TranslationsTest tests
 */
class TranslationsTest extends TestCase
{    
    public function testNewTranslations()
    {
        $translations = [
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
        
        $t = new Translations($translations);
        
        $this->assertSame($translations, $t->all([]));
    }
    
    public function testNewTranslationsWithNoItems()
    {
        $t = new Translations();
        
        $this->assertSame([], $t->all([]));
    }

    public function testMakeMethod()
    {
        $t = Translations::make(['de' => []]);
        
        $this->assertSame(['de' => []], $t->all([]));
    }
    
    public function testMakeMethodWithNoItems()
    {
        $t = Translations::make();
        
        $this->assertSame([], $t->all([]));
    }    
}