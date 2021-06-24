# Collection Service

The Collection Service provides fluent and convenient wrapper classes for working with arrays of data.

## Table of Contents

- [Getting started](#getting-started)
    - [Requirements](#requirements)
    - [Highlights](#highlights)
- [Documentation](#documentation)
    - [Collection](#collection)
    - [Translations](#translations)
- [Credits](#credits)
___

# Getting started

Add the latest version of the collection service running this command.

```
composer require tobento/service-collection
```

## Requirements

- PHP 8.0 or greater

## Highlights

- Framework-agnostic, will work with any project
- Decoupled design

# Documentation

## Collection

| Method | Description | Dot Notation Supported |
| --- | --- | --- |
| [add()](#add) | Add an item value if it does not exist or is null. | yes |
| [all()](#all) | Get all items. | - |
| [any()](#any) | Check if at least one of the items exists. | yes |
| [combine()](#combine) | Combine item values with item keys. | no |
| [count()](#count) | Counts the items. | - |
| [delete()](#delete) | Delete an item by key. | yes |
| [empty()](#empty) | Check whether collection or an item is empty. | yes |
| [except()](#except) | Get all items except the keys specified. | yes |
| [filter()](#filter) | Filter items. | - |
| [first()](#first) | Get first item passing a given truth test. | - |
| [flatten()](#flatten) | Flatten array to single level array. | - |
| [get()](#get) | Get an item value by key. | yes |
| [has()](#has) | Check if an item by key exists. | yes |
| [keys()](#keys) | Gets the item keys. First array level only. | no |
| [last()](#last) | Get last item passing a given truth test. | - |
| [map()](#map) | Map over each of the items. | - |
| [merge()](#merge) | Merge items. | no |
| [mergeRecursive()](#merge) | Merge items recursive. | no |
| [only()](#only) | Get only the items from the keys specified. | yes |
| [replace()](#replace) | Replace the items. | - |
| [replaceRecursive()](#replace-recursive) | Replace the items recursive. | - |
| [set()](#set) | Set an item value by key. | yes |
| [setAll()](#set-all) | Set all items. | no |
| [toArray()](#to-array) | Converts the collection into a plain PHP array. | - |
| [toJson()](#to-json) | Converts the collection into a JSON serialized string. | - |
| [union()](#union) | Same as merge, except existing items got not overwritten. | - |
| [values()](#values) | Gets the item values. | - |

#### add()

Add an item value if it does not exist or is null.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))
->add('sku', 'car')
->add('title', 'Car New')
->add('meta.color', 'blue')
->all();

/*
Array
(
    [key] => car
    [title] => Car
    [sku] => car
    [meta] => Array
        (
            [color] => blue
        )

)
*/
```

#### all()

Get all items from the collection.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->all();

/*
Array
(
    [key] => car
    [title] => Car
)
*/
```

#### any()

Check if at least one of the items exists.

```php
use Tobento\Service\Collection\Collection;

$exists = (new Collection([
    'key' => 'car',
    'title' => 'Car',
    'meta' => [
        'color' => 'blue'
    ]
]))->any('foo', 'meta.color');

var_dump($exists);
// bool(true)

$exists = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->any('bar', 'foo');

var_dump($exists);
// bool(false)
```

#### combine()

Combine item values with item keys.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key',
    'title',
]))->combine(['car', 'Car'])->all();

/*
Array
(
    [key] => car
    [title] => Car
)
*/
```

#### count()

Counts the items.

```php
use Tobento\Service\Collection\Collection;

$count = (new Collection([
    'key',
    'title',
]))->count();

var_dump($count);
// int(2)
```

#### delete()

Delete an item by key.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car',
    'meta' => [
        'color' => 'red'
    ]    
]))->delete('meta.color')->all();

/*
Array
(
    [key] => car
    [title] => Car
    [meta] => Array
        (
        )

)
*/
```

#### empty()

Check whether collection or an item is empty.

```php
use Tobento\Service\Collection\Collection;

$empty = (new Collection([
    'key' => 'car',
    'title' => 'Car',
    'meta' => [
        'color' => 'red'
    ]     
]))->empty('meta.color');

var_dump($empty);
// bool(false)

$empty = (new Collection([
    'key' => 'car',
    'title' => ''
]))->empty('title');

var_dump($empty);
// bool(true)

// check if collection is empty
$empty = (new Collection([
    'key' => 'car',
    'title' => ''
]))->empty();

var_dump($empty);
// bool(false)
```

#### except()

Get all items except the keys specified.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car',
    'meta' => [
        'color' => 'red',
        'weight' => 1500,
    ]    
]))->except(['key', 'meta.weight'])->all();

/*
Array
(
    [title] => Car
    [meta] => Array
        (
            [color] => red
        )

)
*/
```

#### filter()

Filter items.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key',
    'title',
]))->filter(fn($value, $key) => $key >= 1)->all();

/*
Array
(
    [1] => title
)
*/
```

#### first()

Get first item passing a given truth test.

```php
use Tobento\Service\Collection\Collection;

// by a truth test
$first = (new Collection([
    2,
    8,
    9
]))->first(fn($value) => $value > 2);

var_dump($first);
// int(8)

// by a truth test with a fallback
$first = (new Collection([
    2,
    8,
    9
]))->first(fn($value) => $value > 12, 15);

var_dump($first);
// int(15)

// without truth test
$first = (new Collection([
    2,
    8,
    9
]))->first();

var_dump($first);
// int(2)
```

#### flatten()

Flatten array to single level array.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car',
    'meta' => [
        'foo' => 'bar'
    ]
]))->flatten()->all();

/*
Array
(
    [0] => car
    [1] => Car
    [2] => bar
)
*/
```

#### get()

Get an item value by key.

```php
use Tobento\Service\Collection\Collection;

$value = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->get('title');

var_dump($value);
// string(3) "Car"

// With fallback. If the value exist but does not match the fallback type,
// it returns the fallback instead.
$value = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->get('title', ['foo']);

var_dump($value);
// array(1) { [0]=> string(3) "foo" }

// using dot notation for array depth
$value = (new Collection([
    'key' => 'car',
    'title' => 'Car',
    'meta' => [
        'color' => 'red'
    ]
]))->get('meta.color');

var_dump($value);
// string(3) "red"
```

#### has()

Check if an item by key exists.

```php
use Tobento\Service\Collection\Collection;

$has = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->has('title', 'key');

var_dump($has);
// bool(true)

$has = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->has('title', 'foo');

var_dump($has);
// bool(false)

// using dot notation for array depth
$has = (new Collection([
    'key' => 'car',
    'title' => 'Car',
    'meta' => [
        'color' => 'red'
    ]
]))->has('title', 'meta.color');

var_dump($has);
// bool(true)
```

#### keys()

Gets the item keys. First array level only.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->keys()->all();

/*
Array
(
    [0] => key
    [1] => title
)
*/

// With a search value
$all = (new Collection([
    'blue', 'red', 'blue', 'green'
]))->keys('blue', strict: false)->all();

/*
Array
(
    [0] => 0
    [1] => 2
)
*/
```

#### last()

Get last item passing a given truth test.

```php
use Tobento\Service\Collection\Collection;

// by a truth test
$last = (new Collection([
    2,
    8,
    9
]))->last(fn($value) => $value < 7);

var_dump($last);
// int(2)

// by a truth test with a fallback
$last = (new Collection([
    2,
    8,
    9
]))->last(fn($value) => $value > 12, 15);

var_dump($last);
// int(15)

// without truth test
$last = (new Collection([
    2,
    8,
    9
]))->last();

var_dump($last);
// int(9)
```

#### map()

Map over each of the items.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->map(fn($value, $key) => strtoupper($value))->all();

/*
Array
(
    [key] => CAR
    [title] => CAR
)
*/
```

#### merge()

Merge items.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->merge(['foo' => 'bar', 'title' => 'Car VW'])->all();

/*
Array
(
    [key] => car
    [title] => Car VW
    [foo] => bar
)
*/
```

#### mergeRecursive()

Merge items recursive.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->mergeRecursive(['foo' => 'bar', 'title' => 'Car VW'])->all();

/*
Array
(
    [key] => car
    [title] => Array
        (
            [0] => Car
            [1] => Car VW
        )

    [foo] => bar
)
*/
```

#### only()

Get only the items from the keys specified.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car',
    'meta' => [
        'color' => 'red',
        'weight' => 1500,
    ]    
]))->only(['title', 'meta.color'])->all();

/*
Array
(
    [title] => Car
    [meta] => Array
        (
            [color] => red
        )

)
*/

// Define a default value.
$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->only(['title', 'foo'], 'default value')->all();

/*
Array
(
    [title] => Car
    [foo] => default value 
)
*/
```

#### replace()

Replace the items.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->replace(['title' => 'Car VW', 'foo' => 'bar'])->all();

/*
Array
(
    [key] => car
    [title] => Car VW
    [foo] => bar
)
*/
```

#### replaceRecursive()

Replace the items recursive.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car',
    'colors' => [
        'blue', 'red'
    ]
]))->replaceRecursive(['colors' => [0 => 'green']])->all();

/*
Array
(
    [key] => car
    [title] => Car
    [colors] => Array
        (
            [0] => green
            [1] => red
        )

)
*/
```

#### set()

Set an item value by key.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->set('color', 'red')->all();

/*
Array
(
    [key] => car
    [title] => Car
    [color] => red
)
*/

// using dot notation for array depth
$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'
]))->set('meta.color', 'red')->all();

/*
Array
(
    [key] => car
    [title] => Car
    [meta] => Array
        (
            [color] => red
        )

)
*/
```

#### setAll()

Set all items.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'  
]))->setAll(['title' => 'foo'])->all();

/*
Array
(
    [title] => foo
)
*/
```

#### toArray()

Converts the collection into a plain PHP array.

```php
use Tobento\Service\Collection\Collection;

$array = (new Collection([
    'key' => 'car',
    'title' => 'Car'  
]))->toArray();

/*
Array
(
    [key] => car
    [title] => Car
)
*/
```

#### toJson()

Converts the collection into a JSON serialized string.

```php
use Tobento\Service\Collection\Collection;

$json = (new Collection([
    'key' => 'car',
    'title' => 'Car'  
]))->toJson();

// {"key":"car","title":"Car"}
```

#### union()

Same as merge, except existing items got not overwritten.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'  
]))->union(['title' => 'foo', 'foo' => 'bar'])->all();

/*
Array
(
    [key] => car
    [title] => Car
    [foo] => bar
)
*/
```

#### values()

Gets the item values.

```php
use Tobento\Service\Collection\Collection;

$all = (new Collection([
    'key' => 'car',
    'title' => 'Car'  
]))->values()->all();

/*
Array
(
    [0] => car
    [1] => Car
)
*/
```

## Translations

#### Create a new Translations collection.

```php
use Tobento\Service\Collection\Translations;

$trans = new Translations([
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
], 'en');

$trans->setLocaleFallbacks(['it' => 'en', 'de' => 'en']);
// only get() method takes fallabacks into account.

$trans->setLocaleMapping(['de-CH' => 'de', 1 => 'de']);
// ['de-CH' (requested) => 'de' (stored)]

$trans->setLocale('de');
// change default locale
```

#### add()

# Credits

- [Tobias Strub](https://www.tobento.ch)
- [All Contributors](../../contributors)

Idea and some code snippets is taken from [Collections](https://github.com/illuminate/collections) of the [Laravel framework](https://laravel.com).