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
 * TranslationsSetTest tests
 */
class TranslationsSetTest extends TestCase
{    
    public function testSet()
    {        
        $t = new Translations([], 'en');
        
        $t->set('title', 'title en');
        
        $this->assertSame(['en' => ['title' => 'title en']], $t->all([]));
    }
    
    public function testSetWitDotNotation()
    {        
        $t = new Translations([], 'en');
        
        $t->set('meta.color', 'blue');
        
        $this->assertSame(['en' => ['meta' => ['color' => 'blue']]], $t->all([]));
    }    
    
    public function testSetWithLocale()
    {        
        $t = new Translations([], 'en');
        
        $t->set('title', 'title fr', 'fr');
        
        $this->assertSame(['fr' => ['title' => 'title fr']], $t->all([]));
    }

    public function testSetWithLocaleAndMappedLocale()
    {        
        $t = new Translations([], 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $t->set('title', 'title de', 'de-CH');
        
        $this->assertSame(['de' => ['title' => 'title de']], $t->all([]));
    }
    
    public function testSetWithLocalesEmptySetsValuesToDefaultLocale()
    {        
        $t = new Translations([], 'en');
        
        $t->set('title', 'title all', []);
        
        $this->assertSame(['en' => ['title' => 'title all']], $t->all([]));
    }
    
    public function testSetWithLocalesEmptySetsValuesToDefaultLocaleAndOthers()
    {        
        $t = new Translations(['fr' => []], 'en');
        
        $t->set('title', 'title all', []);
        
        $this->assertSame(
            ['fr' => ['title' => 'title all'], 'en' => ['title' => 'title all']],
            $t->all([])
        );
    }
    
    public function testSetWithLocalesSpecificSetsValuesOnlyToThose()
    {        
        $t = new Translations([], 'en');
        
        $t->set('title', 'title all', ['fr', 'de']);
        
        $this->assertSame(
            ['fr' => ['title' => 'title all'], 'de' => ['title' => 'title all']],
            $t->all([])
        );
    }
    
    public function testSetWithLocalesSpecificSetsValuesOnlyToThoseUsesLocaleMappings()
    {        
        $t = new Translations([], 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $t->set('title', 'title all', ['fr', 'de-CH']);
        
        $this->assertSame(
            ['fr' => ['title' => 'title all'], 'de' => ['title' => 'title all']],
            $t->all([])
        );
    }     
}