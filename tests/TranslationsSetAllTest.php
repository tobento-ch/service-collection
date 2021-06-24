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
 * TranslationsSetAllTest tests
 */
class TranslationsSetAllTest extends TestCase
{    
    public function testSetAll()
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
        
        $t = new Translations();
        $t->setAll($translations);
        
        $this->assertSame($translations, $t->all([]));
    }
    
    public function testSetAllOverwritesTranslations()
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
        
        $t = new Translations(['de' => ['title' => 'foo']]);
        $t->setAll($translations);
        
        $this->assertSame($translations, $t->all([]));
    }     
}