<?php namespace igaster\modelOptions;

/**********************************
    
    1.Create a column in migrations:

        $table->json('options');

    2.Use trait in Model:

        use igaster\modelOptions\modelOptions;

    3.Define valid options keys in Model:

        protected $validOptions=[
            'option1',
            'option2',
        ];

**********************************/


trait modelOptions {

    // Laravel mutators: get options
    public function getOptionsAttribute($value){
        if ($value == null)
            return [];

        return json_decode($value, true);
    }

    // Laravel mutators: set options
    public function setOptionsAttribute($value){
        $this->attributes['options'] = json_encode($value);
    }

    // Return  valid keys from options array 
    public function __get($key) {
        if (in_array($key, $this->validOptions))
            if(array_key_exists($key, $this->options))
                return ($this->options[$key]);
            else
                return null;

        return parent::__get($key);
    }

    // Set valid keys in options array 
    public function __set($key, $value) {
        if (in_array($key, $this->validOptions)) {
            $options = $this->options;
            $options[$key] = $value;
            $this->options = $options;
        } else
            parent::__set($key, $value);
    }    
}