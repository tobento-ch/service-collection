<?php

/**
 * TOBENTO
 *
 * @copyright    Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Collection;

use ArrayAccess;

/**
 * Array helper methods
 */
class Arr
{
    /**
     * Set an item to array
     *
     * @param array|ArrayAccess $array
     * @param string|int $key
     * @param mixed $value The value to set
     * @return array|ArrayAccess
     */
    public static function set($array, string|int $key, mixed $value)
    {    
        return static::setByNotation($array, $key, $value);
    }

    /**
     * Add an item to array if it does not exist or is null
     *
     * @param array|ArrayAccess $array
     * @param string|int $key
     * @param mixed $value The value to set
     * @return array|ArrayAccess
     */
    public static function add($array, string|int $key, mixed $value)
    {
        if (static::get($array, $key) === null)
        {
            return static::set($array, $key, $value);
        }
        
        return $array;
    }    
    
    /**
     * Get an item from array
     *
     * @param array|ArrayAccess $array
     * @param string|int $key
     * @param mixed $default Any default value if item does not exist
     * @return mixed
     */
    public static function get($array, string|int $key, mixed $default = null): mixed
    {
        return static::getByNotation($array, $key, $default);
    }

    /**
     * Has an item array
     *
     * @param array|ArrayAccess $array
     * @param string|int $key
     * @return bool
     */
    public static function has($array, string|int $key): bool
    {
        return static::hasByNotation($array, $key);
    }

    /**
     * Delete an item
     *
     * @param array|ArrayAccess $array
     * @param string|int $key
     * @return array|ArrayAccess
     */
    public static function delete($array, string|int $key)
    {
        return static::deleteByNotation($array, $key);
    }

    /**
     * Return first item in the array passing a given truth test.
     *
     * @param iterable $array
     * @param null|callable $callback
     * @param mixed $default
     * @return mixed
     */
    public static function first($array, ?callable $callback = null, mixed $default = null): mixed
    {
        if (!is_iterable($array)) {
            return $default;
        }
        
        if (is_null($callback)) {
            if (empty($array)) {
                return $default;
            }

            foreach ($array as $item) {
                return $item;
            }
        }

        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * Return the last item in the array passing a given truth test.
     *
     * @param array $array
     * @param null|callable $callback
     * @param  mixed $default
     * @return mixed
     */
    public static function last($array, ?callable $callback = null, mixed $default = null): mixed
    {
        if (!is_iterable($array)) {
            return $default;
        }
        
        if (is_null($callback)) {
            return empty($array) ? $default : end($array);
        }

        return static::first(array_reverse($array, true), $callback, $default);
    }    
    
    /**
     * First item key
     *
     * @param array $array
     * @param mixed $default
     * @return mixed
     */
    public static function firstKey($array, mixed $default = null): mixed
    {
        if (!is_array($array)) {
            return $default;
        }
        
        $first = array_key_first($array);
        
        return !is_null($first) ? $first : $default;
    }

    /**
     * Last item key
     *
     * @param array $array
     * @param mixed $default
     * @return mixed
     */
    public static function lastKey($array, mixed $default = null): mixed
    {
        if (!is_array($array)) {
            return $default;
        }
        
        $last = array_key_last($array);
        
        return !is_null($last) ? $last : $default;
    }
    
    /**
     * Get only the items from the keys specified.
     * If key does not exists it sets default specified.
     *
     * @param array|ArrayAccess $array
     * @param array $keys The keys.
     * @param mixed $default A default value if a key does not exist.
     * @return array|ArrayAccess
     */
    public static function only($array, array $keys, mixed $default = null)
    {
        if (! static::arrayable($array)) {
            return [];
        }
        
        $items = [];
        
        foreach($keys as $key)
        {
            $items = static::set($items, $key, static::get($array, $key, $default));
        }
        
        return $items;
    }
    
    /**
     * Get only the items present from the keys specified.
     *
     * @param array|ArrayAccess $array
     * @param array $keys The keys.
     * @return array|ArrayAccess
     */
    public static function onlyPresent($array, array $keys)
    {
        if (! static::arrayable($array)) {
            return [];
        }
        
        $items = [];
        
        foreach($keys as $key)
        {
            if (static::has($array, $key)) {
                $items = static::set($items, $key, static::get($array, $key));
            }
        }
        
        return $items;
    }    

    /**
     * Get all items except the keys specified.
     *
     * @param array|ArrayAccess $array
     * @param array $keys The keys.
     * @return array|ArrayAccess
     */
    public static function except($array, array $keys)
    {
        if (! static::arrayable($array)) {
            return [];
        }
        
        $items = $array;
        
        foreach($keys as $key)
        {        
            $items = static::delete($items, $key);
        }
        
        return $items;
    }

    /**
     * Flatten array to single level array
     *
     * @param iterable $array
     * @param int|float $depth
     * @return array
     */
    public static function flatten($array, int|float $depth = INF): array
    {
        $result = [];

        foreach ($array as $item)
        {
            $item = $item instanceof Collection ? $item->all() : $item;

            if (! is_array($item)) {
                $result[] = $item;
            } else {
                $values = $depth === 1
                    ? array_values($item)
                    : static::flatten($item, $depth - 1);

                foreach ($values as $value)
                {
                    $result[] = $value;
                }
            }
        }
        
        return $result;
    }
    
    /**
     * Flatten array with notation.
     *
     * @param iterable $array
     * @param string $prepend
     * @param string $notation
     * @return array
     */
    public static function dot($array, string $prepend = '', string $notation = '.'): array
    {
        $result = [];
        
        foreach ($array as $key => $value)
        {
            if (is_array($value) && !empty($value))
            {
                $result = array_merge($result, static::dot($value, $prepend.$key.$notation, $notation));
            }
            else {
                $result[$prepend.$key] = $value;
            }
        }
        
        return $result;
    }
    
    /**
     * Undot array with notation.
     *
     * @param iterable $array
     * @param null|callable $callback A callback e.g. fn($value, $key): mixed (value)
     * @param string $notation
     * @return array
     */
    public static function undot($array, null|callable $callback = null, string $notation = '.'): array
    {
        $result = [];

        foreach ($array as $key => $value) {

            if (!is_null($callback)) {
                $value = $callback($value, $key);
            }
            
            static::setByNotation($result, $key, $value, $notation);
        }

        return $result;
    }
    
    /**
     * Flatten array with array like notation.
     *
     * @param iterable $array
     * @param null|callable $callback A callback e.g. fn($value, $key): mixed (value)
     * @return array
     */
    public static function flat($array, null|callable $callback = null): array
    {
        $dotted = static::dot($array);
        $result = [];
        
        foreach($dotted as $key => $value) {
            
            $keyArr = explode('.', $key);
            $key = $keyArr[0]; 
            unset($keyArr[0]);

            foreach ($keyArr as $k) {
                $key .= '['.$k.']';
            }
            
            if (!is_null($callback)) {
                $value = $callback($value, $key);
            }

            $result[$key] = $value;
        }
        
        return $result;
    }
    
    /**
     * Unflatten array with array like notation.
     *
     * @param iterable $array
     * @param null|callable $callback A callback e.g. fn($value, $key): mixed (value)
     * @return array
     */
    public static function unflat($array, null|callable $callback = null): array
    {
        $dotted = [];

        foreach ($array as $key => $value) {
            
            if (is_string($key)) {
                $key = str_replace(['[]', '[', ']'], ['', '.', ''], $key);
            }
            
            $dotted[$key] = $value;
        }

        return static::undot($dotted, $callback);
    }
    
    /**
     * If the given key exists in the array.
     *
     * @param array|ArrayAccess $array
     * @param string|int $key
     * @return bool
     */
    public static function exists($array, string|int $key): bool
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    /**
     * Delete an item by notation
     * 
     * @param array|ArrayAccess $array
     * @param string|int $key
     * @param string $notation The notation to be used.
     * @return array|ArrayAccess
     */         
    public static function deleteByNotation(&$array, string|int $key, string $notation = '.')
    {
        if (! static::arrayable($array)) {
            return [];
        }

        if (static::exists($array, $key)) {
            unset($array[$key]);
            return $array;
        }
        
        if (! static::hasNotation($key, $notation)) {
            return $array;
        }

        if ($array instanceof ArrayAccess) {
            return $array;
        }
        
        $keys = explode($notation, $key);
        $cur = &$array;
        $lastKey = array_pop($keys);
        
        foreach($keys as $curKey){
            $cur = &$cur[$curKey]; 
        }
        
        if (!is_array($cur)) {
            unset($cur);
            return $array;
        }

        if (!array_key_exists($lastKey, $cur)) {
            return $array;
        }
        
        unset($cur[$lastKey]);
        unset($cur);
        return $array;
    }
    
    /**
     * Has an item by notation.
     * 
     * @param array|ArrayAccess $array
     * @param  string|int $key
     * @param string $notation The notation to be used.
     * @return bool
     */         
    public static function hasByNotation($array, string|int $key, string $notation = '.'): bool
    {
        if (! static::arrayable($array)) {
            return false;
        }

        if (static::exists($array, $key)) {
            return true;
        }
        
        if (! static::hasNotation($key, $notation)) {
            return false;
        }
        
        $keys = explode($notation, $key);

        // array depth
        foreach ($keys as $k)
        {
            if (is_array($array) && array_key_exists($k, $array)) {
                $array = $array[$k];
            } else {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Has the key a notation pattern.
     * 
     * @param string|int $key
     * @param string $notation The notation to be used.
     * @return bool
     */         
    public static function hasNotation(string|int $key, string $notation = '.'): bool
    {
        if (!is_string($key)) {
            return false;
        }
        return (strpos($key, $notation) === false) ? false : true;
    }

    /**
     * Set value by using a notation for depth.
     * 
     * @param array|ArrayAccess $array
     * @param string|int $key
     * @param mixed $value Any value
     * @param string $notation The notation to be used.
     * @return array|ArrayAccess
     */         
    public static function setByNotation(&$array, string|int $key, mixed $value, string $notation = '.')
    {
        if (! static::arrayable($array)) {
            return is_array($value) ? $value : [$value];
        }
        
        if (! static::hasNotation($key, $notation)) {
            $array[$key] = $value;
            return $array;
        }

        if ($array instanceof ArrayAccess) {
            return $array;
        }
        
        $keys = explode($notation, $key);
        $data = &$array;
        
        $lastKey = array_pop($keys);
        
        foreach($keys as $k)
        {
            if (isset($data[$k])) {
                if (!is_array($data[$k])){
                    $data[$k] = [];
                }
                $data = &$data[$k];
            } else {
                $data = &$data[$k];
            }
        }
        
        $data[$lastKey] = $value;
        unset($data);
        return $array;
    }
    
    /**
     * Get an item by notation.
     * 
     * @param array|ArrayAccess $array
     * @param string|int $key
     * @param mixed $default A default value if not found.
     * @param string $notation The notation to be used.
     * @return mixed The item found or otherwise the default value if set.
     */         
    public static function getByNotation($array, string|int $key, mixed $default = null, string $notation = '.'): mixed
    {
        if (! static::arrayable($array)) {
            return $default;
        }
        
        if (static::exists($array, $key)) {
            return $array[$key];
        }
        
        if (! static::hasNotation($key, $notation)) {
            return $default;
        }

        $keys = explode($notation, $key);

        foreach ($keys as $k)
        {
            if (is_array($array) && array_key_exists($k, $array)) {
                $array = $array[$k];
                continue;
            } else {
                $array = $default;
                break;
            }
        }

        return $array;
    }
    
    /**
     * If the value is arrayable
     *
     * @param mixed $value
     * @return bool
     */
    public static function arrayable(mixed $value): bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }    
}