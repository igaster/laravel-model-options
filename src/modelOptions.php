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


    //----------------------------------------
    protected $modelOptions_handled;

    // Return  valid keys from options array 
    public function modelOptions_get($key) {
        $this->modelOptions_handled = false;
        if (in_array($key, $this->validOptions)){
            $result = null;
            
            if(array_key_exists($key, $this->options))
                $result = $this->options[$key];
            
            $this->modelOptions_handled = true;
            
            return $result;
        }
    }

    // Set valid keys in options array 
    public function modelOptions_set($key, $value) {
        $this->modelOptions_handled = false;

        if (in_array($key, $this->validOptions)) {
            $options = $this->options;
            $options[$key] = $value;
            $this->options = $options;
            $this->modelOptions_handled = true;
        };
    }    

    //--- copy these in your model if you need to implement __get __set methods

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

}