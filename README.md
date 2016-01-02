## Description
[![Laravel](https://img.shields.io/badge/Laravel-5.x-orange.svg?style=flat-square)](http://laravel.com)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)
[![Build Status](https://travis-ci.org/igaster/laravel-model-options.svg?branch=master)](https://travis-ci.org/igaster/laravel-model-options)
[![Downloads](https://img.shields.io/packagist/dt/igaster/laravel-model-options.svg?style=flat-square)](https://packagist.org/packages/igaster/laravel-model-options)

A simple Trait to store an Options array in a JSON column. Get/Set values as if they were seperate keys in the Database

## Installation

Edit your project's `composer.json` file to require:

    "require": {
        "igaster/laravel-model-options": "~1.0"
    }

and install with `composer update`

## How to use

1. Define a JSON key with name 'options' in your migration file:

```php
$table->json('options')->nullable();
```

note that older versions of mySql don't support the json type. In that case you can safely fallback to a string type:

```php
$table->string('options')->nullable();
```


2. Use the Trait in the coresponding model:

        use \igaster\modelOptions\modelOptions;

3. Define the valid option keys in model:

        protected $validOptions=[
            'option_1',
            'option_2',
        ];


## Usage:

Access option key as if they were columns in your Database. eg:

        $model->option_1 = 'value1';


## Handle Conflicts:

This Trait makes use of the `__get()` and `__set()` magic methods to perform its ... well... magic! However if you want to implement these functions in your model or another trait then php will complain about conflicts. To overcome this problem you have to hide the Traits methods when you import it:

```php
use igaster\modelOptions\modelOptions {
    __get as private; 
    __set as private; 
}
```

and call them manually from your `__get()` / `__set()` mehods:

```php
//--- copy these in your model if you need to implement __get() __set() methods

public function __get($key) {
    // Handle modelOptions keys
    $result=$this->modelOptions_get($key);
    if ($this->modelOptions_handled)
        return $result;
    
    //your code goes here
    
    return parent::__get($key);
}

public function __set($key, $value) {
    // Handle modelOptions keys
    $this->modelOptions_set($key, $value);
    if ($this->modelOptions_handled)
        return;

    //your code goes here

    parent::__set($key, $value);
}     
```
