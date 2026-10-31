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
 * Reading values of a known type from uncertain data.
 * Typed getters return the value as the requested type if it is valid, otherwise the default.
 * Implementations define what counts as valid, values are never cast.
 */
interface TypedDataInterface
{
    /**
     * Returns a new instance with the given data.
     *
     * @param array $data The data.
     * @return static
     */
    public function new(array $data): static;
    
    /**
     * Returns true if the key exists, otherwise false.
     *
     * @param string|int $key The key, supports dot notation.
     * @return bool
     */
    public function has(string|int $key): bool;
    
    /**
     * Returns the value without any type check.
     *
     * @param string|int $key The key, supports dot notation.
     * @param mixed $default The default value if the key does not exist.
     * @return mixed
     */
    public function get(string|int $key, mixed $default = null): mixed;
    
    /**
     * Returns the value as a string, or the default if it is not a valid string.
     *
     * @param string|int $key The key, supports dot notation.
     * @param string $default The default value.
     * @return string
     */
    public function string(string|int $key, string $default = ''): string;
    
    /**
     * Returns the value as an int, or the default if it is not a valid int.
     *
     * @param string|int $key The key, supports dot notation.
     * @param int $default The default value.
     * @return int
     */
    public function int(string|int $key, int $default = 0): int;
    
    /**
     * Returns the value as a float, or the default if it is not a valid float.
     *
     * @param string|int $key The key, supports dot notation.
     * @param float $default The default value.
     * @return float
     */
    public function float(string|int $key, float $default = 0.0): float;
    
    /**
     * Returns the value as a bool, or the default if it is not a valid bool.
     *
     * @param string|int $key The key, supports dot notation.
     * @param bool $default The default value.
     * @return bool
     */
    public function bool(string|int $key, bool $default = false): bool;
    
    /**
     * Returns the value as an array, or the default if it is not a valid array.
     *
     * @param string|int $key The key, supports dot notation.
     * @param array $default The default value.
     * @return array
     */
    public function array(string|int $key, array $default = []): array;
    
    /**
     * Returns the value as a list (array with sequential keys starting at 0), or the default if it is not a valid list.
     *
     * @param string|int $key The key, supports dot notation.
     * @param array $default The default value.
     * @return array
     */
    public function list(string|int $key, array $default = []): array;
    
    /**
     * Returns all data.
     *
     * @return array
     */
    public function all(): array;
}