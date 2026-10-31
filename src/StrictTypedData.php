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

/**
 * Strict typed data: only values which already have the requested type are valid.
 * Typed getters return the value if it has the type, otherwise the default. Values are never cast.
 * Use it for data with known types, such as stored JSON, cart data or config.
 */
class StrictTypedData implements TypedDataInterface
{
    /**
     * Create a new StrictTypedData.
     *
     * @param array $data The data.
     */
    public function __construct(
        protected array $data = [],
    ) {}
    
    /**
     * Returns a new instance with the given data.
     *
     * @param array $data The data.
     * @return static
     */
    public function new(array $data): static
    {
        return new static($data);
    }
    
    /**
     * Returns true if the key exists, otherwise false.
     *
     * @param string|int $key The key, supports dot notation.
     * @return bool
     */
    public function has(string|int $key): bool
    {
        return Arr::has($this->all(), $key);
    }
    
    /**
     * Returns the value without any type check.
     *
     * @param string|int $key The key, supports dot notation.
     * @param mixed $default The default value if the key does not exist.
     * @return mixed
     */
    public function get(string|int $key, mixed $default = null): mixed
    {
        return Arr::get($this->all(), $key, $default);
    }
    
    /**
     * Returns the value if it is a string, otherwise the default.
     *
     * @param string|int $key The key, supports dot notation.
     * @param string $default The default value.
     * @return string
     */
    public function string(string|int $key, string $default = ''): string
    {
        $value = $this->get($key);
        
        return is_string($value) ? $value : $default;
    }
    
    /**
     * Returns the value if it is an int, otherwise the default.
     *
     * @param string|int $key The key, supports dot notation.
     * @param int $default The default value.
     * @return int
     */
    public function int(string|int $key, int $default = 0): int
    {
        $value = $this->get($key);
        
        return is_int($value) ? $value : $default;
    }
    
    /**
     * Returns the value if it is a float, otherwise the default.
     *
     * @param string|int $key The key, supports dot notation.
     * @param float $default The default value.
     * @return float
     */
    public function float(string|int $key, float $default = 0.0): float
    {
        $value = $this->get($key);
        
        return is_float($value) ? $value : $default;
    }
    
    /**
     * Returns the value if it is a bool, otherwise the default.
     *
     * @param string|int $key The key, supports dot notation.
     * @param bool $default The default value.
     * @return bool
     */
    public function bool(string|int $key, bool $default = false): bool
    {
        $value = $this->get($key);
        
        return is_bool($value) ? $value : $default;
    }
    
    /**
     * Returns the value if it is an array, otherwise the default.
     *
     * @param string|int $key The key, supports dot notation.
     * @param array $default The default value.
     * @return array
     */
    public function array(string|int $key, array $default = []): array
    {
        $value = $this->get($key);
        
        return is_array($value) ? $value : $default;
    }
    
    /**
     * Returns the value if it is a list (array with sequential keys starting at 0), otherwise the default.
     *
     * @param string|int $key The key, supports dot notation.
     * @param array $default The default value.
     * @return array
     */
    public function list(string|int $key, array $default = []): array
    {
        $value = $this->get($key);
        
        return is_array($value) && array_is_list($value) ? $value : $default;
    }
    
    /**
     * Returns all data.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }
}