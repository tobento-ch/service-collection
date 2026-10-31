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
 * Lenient typed data: values which have the requested type are valid,
 * and strings which exactly represent an int, float or bool.
 * Typed getters return the value as the type if it is valid, otherwise the default.
 * Strings are validated, never cast. Use it for data where everything arrives as string,
 * such as request data, cookies or imported CSV data.
 */
class LenientTypedData implements TypedDataInterface
{
    /**
     * Create a new LenientTypedData.
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
     * Returns the value if it is an int,
     * or if it is a string which is exactly an integer (e.g. '3', '-3'), otherwise the default.
     * Strings with whitespace, leading zeros, decimals or exponents are not valid.
     *
     * @param string|int $key The key, supports dot notation.
     * @param int $default The default value.
     * @return int
     */
    public function int(string|int $key, int $default = 0): int
    {
        $value = $this->get($key);
        
        if (is_int($value)) {
            return $value;
        }
        
        if (!is_string($value) || trim($value) !== $value) {
            return $default;
        }
        
        $int = filter_var($value, FILTER_VALIDATE_INT);
        
        return is_int($int) ? $int : $default;
    }
    
    /**
     * Returns the value if it is a float or an int (as float),
     * or if it is a string which is exactly a decimal number (e.g. '2.5', '3', '.5'), otherwise the default.
     * Strings with whitespace, comma decimals or exponents are not valid.
     *
     * @param string|int $key The key, supports dot notation.
     * @param float $default The default value.
     * @return float
     */
    public function float(string|int $key, float $default = 0.0): float
    {
        $value = $this->get($key);
        
        if (is_float($value)) {
            return $value;
        }
        
        if (is_int($value)) {
            // safe: the value is verified to be an int.
            return (float) $value;
        }
        
        if (
            !is_string($value)
            || trim($value) !== $value
            || str_contains(strtolower($value), 'e')
        ) {
            return $default;
        }
        
        $float = filter_var($value, FILTER_VALIDATE_FLOAT);
        
        return is_float($float) ? $float : $default;
    }
    
    /**
     * Returns the value if it is a bool,
     * or if it is a string representing a bool, otherwise the default.
     * True: '1', 'true', 'on', 'yes'. False: '0', 'false', 'off', 'no', ''. Case-insensitive.
     *
     * @param string|int $key The key, supports dot notation.
     * @param bool $default The default value.
     * @return bool
     */
    public function bool(string|int $key, bool $default = false): bool
    {
        $value = $this->get($key);
        
        if (is_bool($value)) {
            return $value;
        }
        
        if (!is_string($value) || trim($value) !== $value) {
            return $default;
        }
        
        $bool = filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);
        
        return is_bool($bool) ? $bool : $default;
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