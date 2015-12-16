## Description
Store an Options array in a JSON column. Get/Set values as if they were seperate keys in the Database

## Installation

Edit your project's `composer.json` file to require:

    "require": {
        "igaster/laravel-model-options": "~1.0"
    }

and install with `composer update`

## How to use

1. Define a JSON key with name 'options' in your migration file:


    $table->json('options');


2. Use the Trait in the coresponding model:

    use igaster\modelOptions\modelOptions;

3. Define the valid option keys in model:

    protected $validOptions=[
        'option_1',
        'option_2',
    ];

4. Access option key as if they were columns in your Database. eg:

	$model->option_1 = 'value1';
