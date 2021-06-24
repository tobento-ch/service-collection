<?php

/**
 * TOBENTO
 *
 * @copyright	Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Collection;

use Tobento\Service\Support\Arrayable;
use Tobento\Service\Support\Jsonable;
use JsonSerializable;
use IteratorAggregate;
use ArrayIterator;
use Traversable;
use Countable;

/**
 * Translations
 */
class Translations implements Arrayable, IteratorAggregate, Jsonable, JsonSerializable
{
	/**
	 * @var Collection The translations.
	 */	
	protected Collection $translations;

	/**
	 * @var string The locale.
	 */	
	protected string $locale;

	/**
	 * @var array The locale fallbacks.
	 */	
	protected array $localeFallbacks = [];	

	/**
	 * @var array ['de' (requested) => '1' (stored)]
	 */	
	protected array $localeMapping = [];
	
	/**
	 * Create a collection of translations
	 *
	 * @param array $translations The translations
	 * @param string $locale The default locale
	 */	
	final public function __construct(
        array $translations = [],
        string $locale = 'en',
    ) {
		$this->setLocale($locale);
		$this->setAll($translations);
	}

	/**
	 * Set the locale
	 *
	 * @param string $locale
	 * @return static $this
	 */	
	public function setLocale(string $locale): static
	{
		$this->locale = $locale;
		return $this;
	}

	/**
	 * Set the locale fallbacks. ['de-CH' => 'en-US']
	 *
	 * @param array $localeFallbacks
	 * @return static $this
	 */	
	public function setLocaleFallbacks(array $localeFallbacks): static
	{
    	$this->localeFallbacks = $localeFallbacks;
		return $this;
    }

	/**
	 * Set the locale mappings.
	 *
	 * @param array $locales ['de' (requested) => '1' (stored)]
	 * @return static $this
	 */	
	public function setLocaleMapping(array $locales): static
	{
		$this->localeMapping = $locales;
		return $this;		
	}
	
	/**
	 * Set all translations.
	 * 
	 * @param array $translations The translations.
	 * @return static $this
	 */		 
	public function setAll(array $translations): static
	{
		$this->translations = new Collection($translations);
		
		return $this;
	}
	
	/**
	 * Make a new translations
	 * 
	 * @param array $translations The translations
	 * @param string $defaultLocale The default locale
	 * @return static New instance
	 */		 
	public static function make(array $translations = [], string $defaultLocale = 'en'): static
	{
		return new static($translations, $defaultLocale);
	}
	
	/**
	 * Get all translation(s).
	 * 
	 * @param null|int|string|array $locales The locale(s).
	 * @return array All translation(s).
	 */		 
	public function all(null|int|string|array $locales = null): array
	{
		// On empty array, get all tranlations, otherwise only the defined.
		if (is_array($locales)) {
			
			if (empty($locales)) {
				$locales = $this->translations->keys()->all();
			} else {
				$locales = array_map(function($locale) {
					return $this->localeMapping[$locale] ?? $locale;
				}, $locales);
			}

			return $this->translations->only($locales, [])->all();			
		}
		
		$locale = $locales ?: $this->locale;
		
		$locale = $this->localeMapping[$locale] ?? $locale;
		
		return $this->translations->get($locale, []);
	}

	/**
	 * Set a translation(s) value by key.
	 * 
	 * @param string $key The key.
	 * @param mixed $value The value.
	 * @param null|string|int|array $locales The locales
	 * @return static $this
	 */		 
	public function set(string $key, mixed $value, null|int|string|array $locales = null): static
	{
		if (is_array($locales)) {

			if (empty($locales)) {
				$locales = $this->translations->keys()->all();
                // always add default locale if none is set.
                $locales[] = $this->locale;
                $locales = array_unique($locales);
			} else {
				$locales = array_map(function($locale) {
					return $this->localeMapping[$locale] ?? $locale;
				}, $locales);
			}
			
			foreach($locales as $locale)
			{
				$this->translations->set((string)$locale.'.'.$key, $value);
			}
			
			return $this;
		}
		
		$locale = $locales ?: $this->locale;
		
		// check locale mapping
		$locale = $this->localeMapping[$locale] ?? $locale;

		$this->translations->set((string)$locale.'.'.$key, $value);
		
		return $this;
	}

	/**
	 * Add a translation(s) value by key if it does not exist or is null.
	 * 
	 * @param string $key The key.
	 * @param mixed $value The value.
	 * @param null|string|int|array $locales The locales
	 * @return static $this
	 */		 
	public function add(string $key, mixed $value, null|int|string|array $locales = null): static
	{
		if (is_array($locales)) {

			if (empty($locales)) {
				$locales = $this->translations->keys()->all();
                // always add default locale if none is set.
                $locales[] = $this->locale;
                $locales = array_unique($locales);
			} else {
				$locales = array_map(function($locale) {
					return $this->localeMapping[$locale] ?? $locale;
				}, $locales);
			}
			
			foreach($locales as $locale)
			{
				$this->translations->add((string)$locale.'.'.$key, $value);
			}
			
			return $this;
		}
		
		$locale = $locales ?: $this->locale;
		
		// check locale mapping
		$locale = $this->localeMapping[$locale] ?? $locale;

		$this->translations->add((string)$locale.'.'.$key, $value);
		
		return $this;
	}
	
	/**
	 * Get a translation(s) value by key.
	 *
	 * @param string $key The key.
	 * @param mixed $default A default value.
	 * @param null|int|string|array $locale 
     *                              string: locale,
     *                              array: [] if empty gets all languages,
	 *                              otherwise the keys set ['de', 'en']
	 * @return mixed The value or the default value if not exist.
	 */
	public function get(string $key, mixed $default = null, null|int|string|array $locale = null): mixed
	{
		if (is_array($locale)) {
            
            if (empty($locale)) {
                $locales = array_keys($this->all([]));
                // always add default locale if none is set.
                $locales[] = $this->locale;
                $locales = array_unique($locales);
            } else {
                $locales = $locale;
            }            
            
			$result = [];
			
			foreach($locales as $locale)
			{
				$result[$locale] = $this->get($key, $default, $locale);
			}
			
			return $result;
		}
		
		// check locale mapping
		$locale = $this->localeMapping[$locale] ?? $locale;
		
		// fallback to locale if no mapping is found.
		$locale = $locale ?: $this->locale;
		
		$item = $this->translations->get((string)$locale.'.'.$key, $default);
		
		// if item does not exist and no default value is set,
		// we look for the locale fallback	
        if ($item === null && $default === null && $locale !== $this->locale) {
			
			return $this->get($key, $default, $this->getLocaleFallback($locale));
        }
		
		return $item;
	}

	/**
	 * If a translation exist.
	 *
	 * @param string $key The key.
	 * @param null|int|string|array $locales The locales
	 * @return bool True if exist, otherwise false.
	 */
	public function has(string $key, null|int|string|array $locales = null): bool
	{
		if (is_array($locales)) {

			if (empty($locales)) {
				$locales = $this->translations->keys()->all();
			} else {
				$locales = array_map(function($locale) {
					return $this->localeMapping[$locale] ?? $locale;
				}, $locales);
			}
			
			foreach($locales as $locale)
			{
				if (! $this->translations->has((string)$locale.'.'.$key)) {
					return false;
				}
			}
			
			return true;
		}
		
		$locale = $locales ?: $this->locale;
		
		// check locale mapping
		$locale = $this->localeMapping[$locale] ?? $locale;
		
		return $this->translations->has((string)$locale.'.'.$key);
	}

	/**
	 * Delete a translation item(s)
	 *
	 * @param string $key The key.
	 * @param null|int|string|array $locales
	 *        string: locale, array: [] if empty deletes all translations, otherwise the locales set ['de', 'en']
	 * @return static $this
	 */
	public function delete(string $key, null|int|string|array $locales = null): static
	{
		if (is_array($locales)) {

			if (empty($locales)) {
				$locales = $this->translations->keys()->all();
			} else {
				$locales = array_map(function($locale) {
					return $this->localeMapping[$locale] ?? $locale;
				}, $locales);
			}
			
			foreach($locales as $locale)
			{
				$this->translations->delete((string)$locale.'.'.$key);
			}
			
			return $this;
		}
			
		$locale = $locales ?: $this->locale;
		
		$locale = $this->localeMapping[$locale] ?? $locale;
		
		$this->translations->delete((string)$locale.'.'.$key);
		
		return $this;	
	}

	/**
	 * Delete all translation(s)
	 *
	 * @param null|int|string|array $locales
	 *        string: locale, array: [] if empty deletes all translations, otherwise the locales set ['de', 'en']
	 * @return static $this
	 */
	public function deleteAll(null|int|string|array $locales = null): static
	{
		if (is_array($locales)) {

			if (empty($locales)) {
				$this->translations = new Collection();
			} else {
				$locales = array_map(function($locale) {
					return $this->localeMapping[$locale] ?? $locale;
				}, $locales);
			}
			
			foreach($locales as $locale)
			{
				$this->translations->delete((string)$locale);
			}
			
			return $this;
		}
			
		$locale = $locales ?: $this->locale;
		
		$locale = $this->localeMapping[$locale] ?? $locale;
		
		$this->translations->delete((string)$locale);
		
		return $this;	
	}

	/**
	 * Object to array
	 *
	 * @return array
	 */	
	public function toArray(): array
	{		
		return $this->translations->toArray();
	}

	/**
	 * Object to json
	 *
     * @param int $options
	 * @return string
	 */	
	public function toJson(int $options = 0): string
	{
		return $this->translations->toJson($options);
	}

    /**
     * Convert the object into something JSON serializable.
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->translations->jsonSerialize();
    }

    /**
     * Returns an iterator for the items.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return $this->translations->getIterator();
    }
	
	/**
	 * Get the locale fallback for the given locale.
	 *
	 * @param int|string $locale A locale key such as 2,5,de,en-CH, ...
	 * @return int|string
	 */
	protected function getLocaleFallback(int|string $locale): int|string
	{
		return $this->localeFallbacks[$locale] ?? $this->locale;
	}	
}