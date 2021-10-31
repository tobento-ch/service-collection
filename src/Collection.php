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

use Tobento\Service\Macro\Macroable;
use Tobento\Service\Support\Arrayable;
use Tobento\Service\Support\Jsonable;
use Tobento\Service\Support\Str;
use JsonSerializable;
use IteratorAggregate;
use ArrayIterator;
use Traversable;
use Countable;

/**
 * Collection
 */
class Collection implements Arrayable, IteratorAggregate, Countable, Jsonable, JsonSerializable
{
    use Macroable;
    
    /**
     * @var array The items.
     */    
    protected array $items = [];
            
    /**
     * Create a collection.
     *
     * @param mixed $items The items.
     */    
    final public function __construct(
        mixed $items = []
    ){
        $this->setAll($items);
    }

    /**
     * Set all items
     * 
     * @param mixed $items The items
     * @return static
     */         
    public function setAll(mixed $items): static
    {
        $this->items = $this->ensureItems($items);
        return $this;
    }
    
    /**
     * Make a new collection.
     * 
     * @param mixed $items The items
     * @return static
     */         
    public static function make(mixed $items = []): static
    {
        return new static($items);
    }
    
    /**
     * Get the items.
     * 
     * @return array The items.
     */         
    public function all(): array
    {
        return $this->items;
    }
        
    /**
     * Set an item value by key.
     * 
     * @param string|int $key The key.
     * @param mixed $value The value.
     * @return static $this
     */
    public function set(string|int $key, mixed $value): static
    {
        $this->items = Arr::set($this->items, $key, $value);
        return $this;
    }

    /**
     * Add an item value if it does not exist or is null.
     * 
     * @param string|int $key The key.
     * @param mixed $value The value.
     * @return static $this
     */
    public function add(string|int $key, mixed $value): static
    {
        $this->items = Arr::add($this->items, $key, $value);    
        return $this;
    }    
                    
    /**
     * Get an item value by key.
     *
     * @param string|int $key The key.
     * @param mixed $default A default value.
     * @return mixed The value or the default value if not exist.
     */
    public function get(string|int $key, mixed $default = null): mixed
    {
        return $this->ensureType(Arr::get($this->items, $key, $default), $default);
    }
        
    /**
     * If an item exists.
     *
     * @param mixed $key The key.
     * @return bool True if exist, else false.
     */
    public function has(mixed $key): bool
    {
        $keys = is_array($key) ? $key : func_get_args();
        
        foreach($keys as $key)
        {
            if (! Arr::has($this->items, $key)) {
                return false;
            }            
        }
        
        return true;
    }

    /**
     * If has any key.
     *
     * @param mixed $key The key.
     * @return bool True if one of it exist, otherwise false.
     */
    public function any(mixed $key): bool
    {
        $keys = is_array($key) ? $key : func_get_args();
        
        foreach($keys as $key)
        {
            if (Arr::has($this->items, $key)) {
                return true;
            }
        }
        
        return false;
    }    
    
    /**
     * Delete an item from the collection.
     *
     * @param string|int $key The key.
     * @return static $this
     */
    public function delete(string|int $key): static
    {
        $this->items = Arr::delete($this->items, $key);
        
        return $this;
    }
    
    /**
     * Gets the item keys. First array level only.
     * 
     * @param mixed $searchValue The search value.
     * @param bool $strict If true uses strict (===).
     * @return static
     */         
    public function keys(mixed $searchValue = null, bool $strict = false): static
    {
        if ($searchValue === null)
        {
            return new static(array_keys($this->items));
        }
        
        return new static(array_keys($this->items, $searchValue, $strict));
    }

    /**
     * Gets the item values.
     * 
     * @return static
     */         
    public function values(): static
    {
        return new static(array_values($this->items));
    }

    /**
     * Replace the items
     *
     * @param mixed $items The items
     * @return static
     */    
    public function replace(mixed $items): static
    {
        return new static(array_replace($this->items, $this->ensureItems($items)));
    }
    
    /**
     * Replace the items recursive
     *
     * @param mixed $items The data items
     * @return static
     */    
    public function replaceRecursive(mixed $items): static
    {
        return new static(array_replace_recursive($this->items, $this->ensureItems($items)));
    }
    
    /**
     * Merge items
     *
     * @param mixed $items The items to merge
     * @return static
     */    
    public function merge(mixed $items): static
    {
        return new static(array_merge($this->items, $this->ensureItems($items)));
    }

    /**
     * Merge items recursive
     *
     * @param mixed $items The items to merge
     * @return static
     */    
    public function mergeRecursive(mixed $items): static
    {
        return new static(array_merge_recursive($this->items, $this->ensureItems($items)));
    }    

    /**
     * Combine items
     *
     * @param mixed $items The items to combine
     * @return static
     */    
    public function combine(mixed $items): static
    {    
        return new static(array_combine($this->all(), $this->ensureItems($items)));
    }

    /**
     * Union items
     *
     * @param mixed $items The items to combine
     * @return static
     */    
    public function union(mixed $items): static
    {
        return new static($this->items + $this->ensureItems($items));
    }
    
    /**
     * Map over each of the items.
     *
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback): static
    {
        $keys = array_keys($this->items);

        $items = array_map($callback, $this->items, $keys);

        return new static(array_combine($keys, $items));
    }

    /**
     * Filter the items.
     *
     * @param callable $callback
     * @return static
     */
    public function filter(callable $callback): static
    {
        return new static(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
    }
    
    /**
     * Get only the items from the keys specified.
     * If key does not exists it sets default specified.
     *
     * @param array $keys The keys.
     * @param mixed $default A default value if a key does not exist.
     * @return static
     */
    public function only(array $keys, mixed $default = null): static
    {
        return new static(Arr::only($this->items, $keys, $default));
    }    

    /**
     * Get all items except the keys specified.
     *
     * @param array $keys The keys.
     * @return static
     */
    public function except(array $keys): static
    {
        return new static(Arr::except($this->items, $keys));
    }

    /**
     * Flatten array to single level array
     *
     * @param int|float $depth
     * @return static
     */
    public function flatten(int|float $depth = INF): static
    {
        return new static(Arr::flatten($this->items, $depth));
    }

    /**
     * If collection is empty or an item if key is set.
     *
     * @param null|string|int $key The key. If null it checks all
     * @return bool True if exist, else false.
     */
    public function empty(null|string|int $key = null): bool
    {
        if (is_null($key)) {
            return empty($this->all());
        }
        
        if (!$this->has($key)) {
            return true;
        }
        
        return empty($this->get($key));
    }

    /**
     * Get first item passing a given truth test.
     *
     * @param null|callable $callback
     * @param  mixed $default
     * @return mixed
     */
    public function first(?callable $callback = null, mixed $default = null): mixed
    {
        return Arr::first($this->items, $callback, $default);
    }

    /**
     * Get last item passing a given truth test.
     *
     * @param null|callable $callback
     * @param  mixed $default
     * @return mixed
     */
    public function last(?callable $callback = null, mixed $default = null): mixed
    {
        return Arr::last($this->items, $callback, $default);
    }    
    
    /**
     * Object to json
     *
     * @param int $options
     * @return string
     */    
    public function toJson(int $options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return array_map(function ($value) {
            if ($value instanceof JsonSerializable) {
                return $value->jsonSerialize();
            } elseif ($value instanceof Jsonable) {
                return json_decode($value->toJson(), true);
            } elseif ($value instanceof Arrayable) {
                return $value->toArray();
            }

            return $value;
            
        }, $this->all());
    }

    /**
     * Object to array
     *
     * @return array
     */    
    public function toArray(): array
    {
        return $this->map(function ($value) {
            
            if (is_array($value)) {
                return (new static($value))->toArray();
            }
            
            return $value instanceof Arrayable ? $value->toArray() : $value;
        })->all();    
    }

    /**
     * Returns an iterator for the items.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Returns the number of items.
     *
     * @return int The number of items
     */
    public function count(): int
    {
        return count($this->items);
    }
    
    /**
     * Handle dynamic method calls.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */    
    public function __call(string $method, array $parameters): mixed
    {
        // dateAvailableTo -> date_available_to
        $attribute = Str::snake($method);
        
        if ($this->has($attribute))
        {
            return $this->get($attribute, ...$parameters);
        }
    }
    
    /**
     * If default value is set. It ensure the type of it.
     *
     * @param mixed $data The data
     * @param mixed $default The default value
     * @return mixed The ensured value
     */
    protected function ensureType(mixed $data, mixed $default): mixed
    {
        // do not ensure the type if default is null.
        if ($default === null)
        {
            return $data;
        }
        
        // verify type based on the default. If data is not the same just return $default.        
        $defaultType = gettype($default);
        $dataType = gettype($data);
        
        if ($defaultType !== $dataType)
        {            
            // int, float are valid types.
            $types = ['double' => ['integer'], 'integer' => ['double']];
            
            if (isset($types[$defaultType]) && in_array($dataType, $types[$defaultType]))
            {
                return $data;
            }
            
            if ($defaultType === 'string')
            {
                $types = ['int', 'double', 'integer'];

                if (in_array($dataType, $types))
                {
                    return (string) $data;
                }
            }
            
            return $default;
        }
        
        return $data;
    }

    /**
     * Ensure items
     * 
     * @param mixed $items The items
     * @return array
     */         
    protected function ensureItems(mixed $items): array
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof Collection) {
            return $items->all();
        } elseif ($items instanceof Arrayable) {
            return $items->toArray();
        } elseif ($items instanceof Jsonable) {
            return json_decode($items->toJson(), true);
        } elseif ($items instanceof JsonSerializable) {
            return (array) $items->jsonSerialize();
        } elseif ($items instanceof Traversable) {
            return iterator_to_array($items);
        }
        
        return (array) $items;
    }    
}