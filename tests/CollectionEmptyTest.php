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
use Tobento\Service\Collection\Collection;

/**
 * CollectionEmptyTest tests
 */
class CollectionEmptyTest extends TestCase
{    
    public function testEmpty()
    {
        $empty = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'red'
            ]     
        ]))->empty('title');
        
        $this->assertFalse($empty);
    }
    
    public function testEmptyCollection()
    {
        $empty = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'red'
            ]     
        ]))->empty();
        
        $this->assertFalse($empty);
    }
    
    public function testEmptyCollectionIsEmpty()
    {
        $empty = (new Collection([]))->empty();
        
        $this->assertTrue($empty);
    }    
    
    public function testEmptyWithNullValueIsEmpty()
    {
        $empty = (new Collection([
            'key' => 'car',
            'title' => null,
            'meta' => [
                'color' => 'red'
            ]     
        ]))->empty('title');
        
        $this->assertTrue($empty);
    }
    
    public function testEmptyWithEmptyValueIsEmpty()
    {
        $empty = (new Collection([
            'key' => 'car',
            'title' => '',
            'meta' => [
                'color' => 'red'
            ]     
        ]))->empty('title');
        
        $this->assertTrue($empty);
    }    
    
    public function testEmptyWithDotNotation()
    {
        $empty = (new Collection([
            'key' => 'car',
            'title' => 'Car',
            'meta' => [
                'color' => 'red'
            ]     
        ]))->empty('meta.color');
        
        $this->assertFalse($empty);
    }
    
    public function testEmptyWithNumbers()
    {
        $empty = (new Collection([
            5,8,9     
        ]))->empty(1);
        
        $this->assertFalse($empty);
    }
    
    public function testEmptyWithNumbersIsEmpty()
    {
        $empty = (new Collection([
            5,8,9     
        ]))->empty(4);
        
        $this->assertTrue($empty);
    }    
}