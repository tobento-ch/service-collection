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
 * TranslationsAddTest tests
 */
class TranslationsAddTest extends TestCase
{    
    public function testAdd()
    {        
        $t = new Translations([], 'en');
        
        $t->add('title', 'title en');
        
        $this->assertSame(['en' => ['title' => 'title en']], $t->all([]));
    }
    
    public function testAddNoOverwrite()
    {        
        $t = new Translations(['en' => ['title' => 'title en']], 'en');
        
        $t->add('title', 'title new');
        
        $this->assertSame(['en' => ['title' => 'title en']], $t->all([]));
    }
    
    public function testAddWithLocale()
    {        
        $t = new Translations([], 'en');
        
        $t->add('title', 'title fr', 'fr');
        
        $this->assertSame(['fr' => ['title' => 'title fr']], $t->all([]));
    }

    public function testAddWithLocaleAndMappedLocale()
    {        
        $t = new Translations([], 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $t->add('title', 'title de', 'de-CH');
        
        $this->assertSame(['de' => ['title' => 'title de']], $t->all([]));
    }
    
    public function testAddWithLocalesEmptySetsValuesToDefaultLocale()
    {        
        $t = new Translations([], 'en');
        
        $t->add('title', 'title all', []);
        
        $this->assertSame(['en' => ['title' => 'title all']], $t->all([]));
    }
    
    public function testAddWithLocalesEmptySetsValuesToDefaultLocaleAndOthers()
    {        
        $t = new Translations(['fr' => []], 'en');
        
        $t->add('title', 'title all', []);
        
        $this->assertSame(
            ['fr' => ['title' => 'title all'], 'en' => ['title' => 'title all']],
            $t->all([])
        );
    }
    
    public function testAddWithLocalesSpecificSetsValuesOnlyToThose()
    {        
        $t = new Translations([], 'en');
        
        $t->add('title', 'title all', ['fr', 'de']);
        
        $this->assertSame(
            ['fr' => ['title' => 'title all'], 'de' => ['title' => 'title all']],
            $t->all([])
        );
    }
    
    public function testAddWithLocalesSpecificSetsValuesOnlyToThoseUsesLocaleMappings()
    {        
        $t = new Translations([], 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $t->add('title', 'title all', ['fr', 'de-CH']);
        
        $this->assertSame(
            ['fr' => ['title' => 'title all'], 'de' => ['title' => 'title all']],
            $t->all([])
        );
    }
    
    public function testAddWithLocalesSpecificSetsValuesNoOverwrite()
    {        
        $t = new Translations(['de' => ['title' => 'title de']], 'en');
        
        $t->setLocaleMapping(['de-CH' => 'de']);
        
        $t->add('title', 'title all', ['de-CH', 'en']);
        
        $this->assertSame(
            ['de' => ['title' => 'title de'], 'en' => ['title' => 'title all']],
            $t->all([])
        );
    }    
}